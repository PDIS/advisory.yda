<?php namespace RainLab\Blog\Models;

use ApplicationException;
use Backend\Models\ImportModel;
use Backend\Models\User as AuthorModel;
use Bedard\BlogTags\Models\Tag as Tag;
use Exception;
use MarkDai\SayitPlugin\Models\Debate as Transcript;
use RainLab\User\Models\User as User;
use Vdomah\Excel\Classes\Excel;

/**
 * Post Import Model
 */
class PostImport extends ImportModel
{
    public $table = 'rainlab_blog_posts';

    /**
     * Validation rules
     */
    public $rules = [
        'title' => 'required',
        'content' => 'required',
    ];

    protected $authorEmailCache = [];

    protected $categoryNameCache = [];

    public static $combineColumn = array(
        'casenum' => '案號',
        'case' => '案由',
        'proposer' => '提案人',
        'cosigner' => '連署人',
        'content' => '一、青年委員提案內容',
        'description' => '(一)提案說明',
        'suggestion' => '(二)具體建議',
        'opinion' => '二、綜合研處意見',
        'resolution' => '決議',
    );

    public function getDefaultAuthorOptions()
    {
        return AuthorModel::all()->lists('full_name', 'email');
    }

    public function getPostCategoriesOptions()
    {
        return Category::lists('name', 'id');
    }

    public function importData($results, $sessionKey = null)
    {
        if (count($results) == 0) {
            return;
        }

        // date_default_timezone_set("Asia/Taipei");

        $firstRow = reset($results);

        /*
         * Validation
         */
        if ($this->auto_create_categories && !array_key_exists('categories', $firstRow)) {
            throw new ApplicationException('Please specify a match for the Categories column.');
        }

        /*
         * Import
         */
        foreach ($results as $row => $data) {
            try {

                if (!$title = array_get($data, 'title')) {
                    $this->logSkipped($row, 'Missing post title');
                    continue;
                }

                /*
                 * Find or create
                 */
                $post = Post::make();

                // if ($this->update_existing) {
                //     $post = $this->findDuplicatePost($data) ?: $post;
                // }

                // $postExists = $post->exists;

                /*
                 * Set attributes
                 */
                $except = ['id', 'slug', 'categories', 'author_email', 'tags', 'petitioners', 'relative_posts'];

                foreach (array_except($data, $except) as $attribute => $value) {
                    $post->{$attribute} = $value ?: null;
                }


                if (!$post->{'title'}) {
                    $this->logError($row, '[Title] could not be empty.');
                }

                // $la_time = new DateTimeZone('Asia/Taipei');

                if ($post->{'published_at'}) {
                    // $post->{'published_at'}->setTimezone($la_time);;
                    $post->{'published'} = 1;
                }
                $post->{'slug'} = md5($post->{'title'} . date('Y-m-d h:i:s'));

                if ($author = $this->findAuthorFromEmail($data)) {
                    $post->user_id = $author->id;
                }

                $post->forceSave();

                //提案/參與人員
                if ($users = $this->findUsers($data, 'attendees')) {
                    foreach ($users as $user) {
                        $post->users()->save($user);
                    }
                }

                //連署人
                if ($users = $this->findUsers($data, 'petitioners')) {
                    foreach ($users as $user) {
                        $post->reconsideration_users()->save($user);
                    }
                }

                //文章標籤
                if ($tags = $this->findTags($data)) {
                    foreach ($tags as $tag) {
                        $post->tags()->save($tag);
                    }
                }

                // 相關提案
                if ($postChilds = $this->findPosts($data)) {
                    foreach ($postChilds as $postChild) {
                        $post->post_child()->save($postChild);
                    }
                }

                $transcript = $this->findTranscript($data);
                if ($transcript) {
                    $post->transcript()->save($transcript);
                }

                if ($categoryIds = $this->getCategoryIdsForPost($data)) {
                    $post->categories()->sync($categoryIds, false);
                }

                /*
                 * Log results
                 */
                // if ($postExists) {
                //     $this->logUpdated();
                // } else {
                $this->logCreated();
                // }
            } catch (Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }

    protected function findAuthorFromEmail($data)
    {
        if (!$email = array_get($data, 'email', $this->default_author)) {
            return null;
        }

        if (isset($this->authorEmailCache[$email])) {
            return $this->authorEmailCache[$email];
        }

        $author = AuthorModel::where('email', $email)->first();
        return $this->authorEmailCache[$email] = $author;
    }

    protected function findUsers($data, $type)
    {

        if (!$usersStr = array_get($data, $type)) {
            return;
        }

        $arr = explode(",", $usersStr);

        $users = [];

        foreach ($arr as $value) {
            $user = User::where('name', $value)->first();
            if ($user) {
                $users[] = $user;
            }
        }

        return $users;
    }

    protected function findTags($data)
    {

        if (!$tagsStr = array_get($data, 'tags')) {
            return;
        }

        $arr = explode(",", $tagsStr);

        $tags = [];
        foreach ($arr as $value) {
            $item = Tag::where('name', $value)->first();
            if (!$item) {
                $item = new Tag;
                $item->name = $value;
                $item->save();
            }
            $tags[] = $item;
        }

        return $tags;
    }

    protected function findPosts($data)
    {

        if (!$itemsStr = array_get($data, 'relative_posts')) {
            return;
        }

        $arr = explode(",", $itemsStr);

        $items = [];
        foreach ($arr as $value) {
            $item = Post::where('title', $value)->first();
            if ($item) {
                $items[] = $item;
            }
        }

        return $items;
    }

    protected function findTranscript($data)
    {

        if (!$itemStr = array_get($data, 'transcript')) {
            return;
        }

        $item = Transcript::where('heading', $itemStr)->first();

        return $item;
    }

    protected function findDuplicatePost($data)
    {
        if ($id = array_get($data, 'id')) {
            return Post::find($id);
        }

        $title = array_get($data, 'title');
        $post = Post::where('title', $title);

        if ($slug = array_get($data, 'slug')) {
            $post->orWhere('slug', $slug);
        }

        return $post->first();
    }

    protected function getCategoryIdsForPost($data)
    {
        $ids = [];

        if ($this->auto_create_categories) {
            $categoryNames = $this->decodeArrayValue(array_get($data, 'categories'));

            foreach ($categoryNames as $name) {
                if (!$name = trim($name)) {
                    continue;
                }

                if (isset($this->categoryNameCache[$name])) {
                    $ids[] = $this->categoryNameCache[$name];
                } else {
                    $newCategory = Category::firstOrCreate(['name' => $name]);
                    $ids[] = $this->categoryNameCache[$name] = $newCategory->id;
                }
            }
        } elseif ($this->categories) {
            $ids = (array) $this->categories;
        }

        return $ids;
    }

    protected function processImportData($filePath, $matches, $options)
    {
        $excelReader = Excel::excel()->load($filePath, function ($reader) {
            $reader->setDateFormat('Y-m-d H:i:s');
        });
        $dataArray = $excelReader->toArray();

        $result = [];
        if (count($dataArray) > 0) {
            foreach ($dataArray as $idx => $item) {
                $row = [];
                $combineResult = '';
                $nullFlag = true; //如果此row全是null，則nullFlag為true
                foreach ($item as $key => $val) {
                    if ($nullFlag && $val) {
                        $nullFlag = false;
                    }
                    $combineColumn = $this::$combineColumn;
                    if (array_key_exists($key, $combineColumn)) {
                        $combineResult .= "{$combineColumn[$key]}:\n$val\n\n"; //"案號:<br/>案號內容"
                    } else {
                        array_push($row, $val);
                    }
                }

                if (!$nullFlag) {
                    array_push($row, $combineResult);
                    $result[] = $this->processImportRow($row, $matches);
                }
            }
        }

        return $result;
    }
}
