<?php namespace RainLab\Blog\Controllers;

use Flash;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;
use ApplicationException;
use RainLab\Blog\Models\Post;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Drive;

class Posts extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        // 'Backend.Behaviors.ImportExportController'
        'RainLab.Blog.Behaviors.ImportExportBehavior'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';
    public $relationConfig;

    public $requiredPermissions = ['rainlab.blog.access_other_posts', 'rainlab.blog.access_posts'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('RainLab.Blog', 'blog', 'posts');
    }

    /**
    * Returns an authorized API client.
    * @return Google_Client the authorized client object
    */
    public function getCalendarData()
    {
        $client = new Google_Client();
        $client->setClientId("14448337952-cfil8u4aksd7q3rb7jfcsikunopib82a.apps.googleusercontent.com");
        $client->setClientSecret("mbMQue9_5DB8ET2imVGUdwe5");

        if (isset($_GET['code']))
        {
            $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/demo/backend/rainlab/blog/posts/getCalendarData');
            $client->authenticate($_GET['code']);

            $access_token = $client->getAccessToken();
            $client->setAccessToken($access_token);
    
            $service = new Google_Service_Calendar($client);

            $calendarId = 'primary';
            // 撈取Calendar的參數設定
            $optParams = array(
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c'),
                'q'=> "青諮會"
            );
            $results = $service->events->listEvents($calendarId, $optParams);
    return view('', ['calendarData' => $results->items]);
            $events = $service->events->listEvents('primary');
            
            while(true) {
              foreach ($events->getItems() as $event) {
                echo $event->getSummary();
              }
              $pageToken = $events->getNextPageToken();
              if ($pageToken) {
                $optParams = array('pageToken' => $pageToken,'summy'=>'青諮會');
                $events = $service->events->listEvents('primary', $optParams);
              } else {
                break;
              }
            }
            echo "<pre>";
            print_r($events);
            echo "</pre>";
            // 資料處理，存進資料庫
            if (empty($results->getItems())) {
                print "No upcoming events found.\n";
            } else {
                print "Upcoming events:\n";
                foreach ($results->getItems() as $event) {
                    $start = $event->start->dateTime;
                    if (empty($start)) {
                        $start = $event->start->date;
                    }
                    printf("%s (%s)\n", $event->getSummary(), $start);
                }
            }
        }
        // 1) 前往 Google 登入網址，請求用戶授權
        else 
        {
            $client->revokeToken();
            // 添加授權範圍，參考 https://developers.google.com/identity/protocols/googlescopes
            $client->addScope(['https://www.googleapis.com/auth/calendar.readonly']);
            $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/demo/backend/rainlab/blog/posts/getCalendarData');
            $authUrl = $client->createAuthUrl();
            header("Location:{$authUrl}");
        }
        exit();
    }

    public function frontendAPI(){
        // Calendar::all()->;

    }
 
    /**
    * Expands the home directory alias '~' to the full path.
    * @param string $path the path to expand.
    * @return string the expanded path.
    */
    private function expandHomeDirectory($path)
    {
        $homeDirectory = getenv('HOME');
        if (empty($homeDirectory)) {
            $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }
        return str_replace('~', realpath($homeDirectory), $path);
    }

    public function index()
    {
        $this->vars['postsTotal'] = Post::count();
        $this->vars['postsPublished'] = Post::isPublished()->count();
        $this->vars['postsDrafts'] = $this->vars['postsTotal'] - $this->vars['postsPublished'];

        // Get the API client and construct the service object.

        $this->asExtension('ListController')->index();
    }

    public function create()
    {
        BackendMenu::setContextSideMenu('new_post');
        
        $this->bodyClass = 'compact-container';
        $this->addCss('/plugins/rainlab/blog/assets/css/rainlab.blog-preview.css');
        $this->addJs('/plugins/rainlab/blog/assets/js/post-form.js');

        return $this->asExtension('FormController')->create();
    }

    public function update($recordId = null)
    {
        $this->bodyClass = 'compact-container';
        $this->addCss('/plugins/rainlab/blog/assets/css/rainlab.blog-preview.css');
        $this->addJs('/plugins/rainlab/blog/assets/js/post-form.js');
        
        return $this->asExtension('FormController')->update($recordId);
    }

    public function listExtendQuery($query)
    {
        if (!$this->user->hasAnyAccess(['rainlab.blog.access_other_posts'])) {
            $query->where('user_id', $this->user->id);
        }
    }

    public function formExtendQuery($query)
    {
        if (!$this->user->hasAnyAccess(['rainlab.blog.access_other_posts'])) {
            $query->where('user_id', $this->user->id);
        }
    }

    public function formExtendFieldsBefore($widget)
    {
        if (!$model = $widget->model) {
            return;
        }

        if ($model instanceof Post && $model->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')) {
            $widget->secondaryTabs['fields']['content']['type'] = 'RainLab\Blog\FormWidgets\MLBlogMarkdown';
        }
    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $postId) {
                if ((!$post = Post::find($postId)) || !$post->canEdit($this->user)) {
                    continue;
                }

                $post->delete();
            }

            Flash::success('Successfully deleted those posts.');
        }

        return $this->listRefresh();
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass($record, $definition = null)
    {
        if (!$record->published) {
            return 'safe disabled';
        }
    }

    public function formBeforeCreate($model)
    {
        $model->user_id = $this->user->id;
    }

    public function onRefreshPreview()
    {
        $data = post('Post');

        $previewHtml = Post::formatHtml($data['content'], true);

        return [
            'preview' => $previewHtml
        ];
    }
}
