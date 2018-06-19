<?php namespace RainLab\User\Models;

use Db;
use Str;
use Auth;
use Mail;
use Event;
use October\Rain\Auth\Models\User as UserBase;
use RainLab\User\Models\Settings as UserSettings;

class User extends UserBase
{
    use \October\Rain\Database\Traits\SoftDeleting;

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'users';

    /**
     * Validation rules
     */
    public $rules = [
        'email'    => 'required|between:6,255|email|unique:users',
        'username' => 'required|between:2,255|unique:users',
        'password' => 'required:create|between:4,255|confirmed',
        'password_confirmation' => 'required_with:password|between:4,255'
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'groups' => ['RainLab\User\Models\UserGroup', 'table' => 'users_groups'],
        'tags' => ['Bedard\BlogTags\Models\Tag', 'table' => 'bedard_blogtags_user_tag']
    ];

    public $attachOne = [
        'avatar' => ['System\Models\File']
    ];

    

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'surname',
        'login',
        'username',
        'email',
        'password',
        'password_confirmation'
    ];

    /**
     * Purge attributes from data set.
     */
    protected $purgeable = ['password_confirmation', 'send_invite'];

    protected $dates = [
        'last_seen',
        'deleted_at',
        'created_at',
        'updated_at',
        'activated_at',
        'last_login'
        
    ];

    public static $loginAttribute = null;

    /**
     * Sends the confirmation email to a user, after activating.
     * @param  string $code
     * @return void
     */
    public function attemptActivation($code)
    {
        $result = parent::attemptActivation($code);
        if ($result === false) {
            return false;
        }

        if ($mailTemplate = UserSettings::get('welcome_template')) {
            Mail::sendTo($this, $mailTemplate, $this->getNotificationVars());
        }

        Event::fire('rainlab.user.activate', [$this]);

        return true;
    }

    /**
     * Converts a guest user to a registered one and sends an invitation notification.
     * @return void
     */
    public function convertToRegistered($sendNotification = true)
    {
        // Already a registered user
        if (!$this->is_guest) {
            return;
        }

        if ($sendNotification) {
            $this->generatePassword();
        }

        $this->is_guest = false;
        $this->save();

        if ($sendNotification) {
            $this->sendInvitation();
        }
    }

    //
    // Constructors
    //

    /**
     * Looks up a user by their email address.
     * @return self
     */
    public static function findByEmail($email)
    {
        if (!$email) {
            return;
        }

        return self::where('email', $email)->first();
    }

    //
    // Getters
    //

    /**
     * Gets a code for when the user is persisted to a cookie or session which identifies the user.
     * @return string
     */
    public function getPersistCode()
    {
        $block = UserSettings::get('block_persistence', false);

        if ($block || !$this->persist_code) {
            return parent::getPersistCode();
        }

        return $this->persist_code;
    }

    /**
     * Returns the public image file path to this user's avatar.
     */
    public function getAvatarThumb($size = 25, $options = null)
    {
        if (is_string($options)) {
            $options = ['default' => $options];
        }
        elseif (!is_array($options)) {
            $options = [];
        }

        // Default is "mm" (Mystery man)
        $default = array_get($options, 'default', 'mm');

        if ($this->avatar) {
            return $this->avatar->getThumb($size, $size, $options);
        }
        else {
            return '//www.gravatar.com/avatar/'.
                md5(strtolower(trim($this->email))).
                '?s='.$size.
                '&d='.urlencode($default);
        }
    }

    /**
     * Returns the name for the user's login.
     * @return string
     */
    public function getLoginName()
    {
        if (static::$loginAttribute !== null) {
            return static::$loginAttribute;
        }

        return static::$loginAttribute = UserSettings::get('login_attribute', UserSettings::LOGIN_EMAIL);
    }

    //
    // Scopes
    //

    public function scopeIsActivated($query)
    {
        return $query->where('is_activated', 1);
    }

    public function scopeFilterByGroup($query, $filter)
    {
        return $query->whereHas('groups', function($group) use ($filter) {
            $group->whereIn('id', $filter);
        });
    }

    //
    // Events
    //

    /**
     * Before validation event
     * @return void
     */
    public function beforeValidate()
    {
        /*
         * Guests are special
         */
        if ($this->is_guest && !$this->password) {
            $this->generatePassword();
        }

        /*
         * When the username is not used, the email is substituted.
         */
        if (
            (!$this->username) ||
            ($this->isDirty('email') && $this->getOriginal('email') == $this->username)
        ) {
            $this->username = $this->email;
        }
    }

    /**
     * After create event
     * @return void
     */
    public function afterCreate()
    {
        $this->restorePurgedValues();

        if ($this->send_invite) {
            $this->sendInvitation();
        }
    }

    /**
     * After login event
     * @return void
     */
    public function afterLogin()
    {
        $this->last_login = $this->last_seen = $this->freshTimestamp();

        if ($this->trashed()) {
            $this->restore();

            Mail::sendTo($this, 'rainlab.user::mail.reactivate', [
                'name' => $this->name
            ]);

            Event::fire('rainlab.user.reactivate', [$this]);
        }
        else {
            parent::afterLogin();
        }

        Event::fire('rainlab.user.login', [$this]);
    }

    /**
     * After delete event
     * @return void
     */
    public function afterDelete()
    {
        if ($this->isSoftDelete()) {
            Event::fire('rainlab.user.deactivate', [$this]);
            return;
        }

        $this->avatar && $this->avatar->delete();

        parent::afterDelete();
    }

    //
    // Banning
    //

    /**
     * Ban this user, preventing them from signing in.
     * @return void
     */
    public function ban()
    {
        Auth::findThrottleByUserId($this->id)->ban();
    }

    /**
     * Remove the ban on this user.
     * @return void
     */
    public function unban()
    {
        Auth::findThrottleByUserId($this->id)->unban();
    }

    /**
     * Check if the user is banned.
     * @return bool
     */
    public function isBanned()
    {
        $throttle = Auth::createThrottleModel()->where('user_id', $this->id)->first();
        return $throttle ? $throttle->is_banned : false;
    }

    //
    // Last Seen
    //

    /**
     * Checks if the user has been seen in the last 5 minutes, and if not,
     * updates the last_seen timestamp to reflect their online status.
     * @return void
     */
    public function touchLastSeen()
    {
        if ($this->isOnline()) {
            return;
        }

        $oldTimestamps = $this->timestamps;
        $this->timestamps = false;

        $this
            ->newQuery()
            ->where('id', $this->id)
            ->update(['last_seen' => $this->freshTimestamp()])
        ;

        $this->last_seen = $this->freshTimestamp();
        $this->timestamps = $oldTimestamps;
    }

    /**
     * Returns true if the user has been active within the last 5 minutes.
     * @return bool
     */
    public function isOnline()
    {
        return $this->getLastSeen() > $this->freshTimestamp()->subMinutes(5);
    }

    /**
     * Returns the date this user was last seen.
     * @return Carbon\Carbon
     */
    public function getLastSeen()
    {
        return $this->last_seen ?: $this->created_at;
    }

    //
    // Utils
    //

    /**
     * Returns the variables available when sending a user notification.
     * @return array
     */
    protected function getNotificationVars()
    {
        $vars = [
            'name'  => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'login' => $this->getLogin(),
            'password' => $this->getOriginalHashValue('password'),
        ];

        /*
         * Extensibility
         */
        $result = Event::fire('rainlab.user.getNotificationVars', [$this]);
        if ($result && is_array($result)) {
            $vars = call_user_func_array('array_merge', $result) + $vars;
        }

        return $vars;
    }

    /**
     * Sends an invitation to the user using template "rainlab.user::mail.invite".
     * @return void
     */
    protected function sendInvitation()
    {
        Mail::sendTo($this, 'rainlab.user::mail.invite', $this->getNotificationVars());
    }

    /**
     * Assigns this user with a random password.
     * @return void
     */
    protected function generatePassword()
    {
        $this->password = $this->password_confirmation = Str::random(6);
    }

    // function getAvatarSrc() {
    //     return Db::table('system_files')->
    // }
    public function getPosts() {
       
        $posts = Db::table('users')
            ->join('rainlab_blog_user_post', 'users.id', '=', 'user_id')
            ->join('rainlab_blog_posts', 'rainlab_blog_user_post.post_id', '=', 'rainlab_blog_posts.id')
            ->join('rainlab_blog_posts_categories', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
            ->where('users.id', '=', $this->id)
            ->where('rainlab_blog_posts_categories.category_id','=','1')->get();
    
           
        
        
        return $posts;
    }
    public function getReconsiderationPost() {
        
         $posts = Db::table('users')
             ->join('rainlab_blog_reconsideration_user_post', 'users.id', '=', 'user_id')
             ->join('rainlab_blog_posts', 'rainlab_blog_reconsideration_user_post.post_id', '=', 'rainlab_blog_posts.id')
             ->join('rainlab_blog_posts_categories', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
             ->where('users.id', '=', $this->id)
             ->where('rainlab_blog_posts_categories.category_id','=','1')->get();
     
            
         
         
         return $posts;
     }
     public function getOthersPost() {
        $postPosts = Db::table('users')
            ->join('rainlab_blog_posts', 'users.id', '=', 'rainlab_blog_posts.author_id')
            ->join('rainlab_blog_posts_categories', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
            ->where('users.id', '=', $this->id)
            ->where('rainlab_blog_posts_categories.category_id','!=','1')->get();

        $attendPosts = Db::table('users')
            ->join('rainlab_blog_user_post', 'users.id', '=', 'user_id')
            ->join('rainlab_blog_posts', 'rainlab_blog_user_post.post_id', '=', 'rainlab_blog_posts.id')
            ->join('rainlab_blog_posts_categories', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
            ->Where('rainlab_blog_user_post.user_id', '=', $this->id)
            ->where('rainlab_blog_posts_categories.category_id','!=','1')
            ->get();

        $reconsiderationPosts = Db::table('users')
            ->join('rainlab_blog_reconsideration_user_post', 'users.id', '=', 'rainlab_blog_reconsideration_user_post.user_id')
            ->join('rainlab_blog_posts', 'rainlab_blog_reconsideration_user_post.post_id', '=', 'rainlab_blog_posts.id')
            ->join('rainlab_blog_posts_categories', 'rainlab_blog_posts.id', '=', 'rainlab_blog_posts_categories.post_id')
            ->where('rainlab_blog_posts_categories.category_id','!=','1')
            ->get();

        $posts = array();
        $postTmp = array();
        $postIdAndDate = array();
        $postIdArray = array();
        $postUsers = array();
        $userIdArray = array();
        $userModel = array();

        foreach($postPosts as $post) {
            $postTmp[$post->post_id] = $post;
            $postIdAndDate[$post->post_id] = $post->created_at;
        }

        foreach($attendPosts as $post) {
            $postTmp[$post->post_id] = $post;
            $postIdAndDate[$post->post_id] = $post->created_at;
        }

        foreach($reconsiderationPosts as $post) {
            $postTmp[$post->post_id] = $post;
            $postIdAndDate[$post->post_id] = $post->created_at;
        }
        arsort($postIdAndDate);

        foreach($postIdAndDate as $postId => $post) {
            $posts[] = $postTmp[$postId];
            $postIdArray[] = $postId;
        }

        $postUserIds = Db::table('rainlab_blog_user_post')
            ->whereIn('rainlab_blog_user_post.post_id', $postIdArray)
            ->get();

        foreach($postUserIds as $postUser) {
            try {
                $postUsers[$postUser->post_id][] = $postUser->user_id;
            } catch (Exception $e) {
                $postUsers[$postUser->post_id] = array();
                $postUsers[$postUser->post_id][] = $postUser->user_id;
            }
            $userIdArray[] = $postUser->user_id;
        }
        
        $users = $this::find($userIdArray); // User::find
        foreach($users as $user) {
            $userModel[$user->id] = $user;
        }
        foreach($posts as $key => $post) {
            $posts[$key]->userModel = array();
            if(isset($postUsers[$post->id])) {
                foreach($postUsers[$post->id] as $userId){
                    $posts[$key]->userModel[] = $userModel[$userId];
                }
            }
        }
        
        return $posts;
     }

}
