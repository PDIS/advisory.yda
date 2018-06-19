<?php namespace FireUnion\BlogFront\Components;

use Cms\Classes\ComponentBase;
use Input;
use Redirect;
use System\Classes\PluginManager;
use Bedard\BlogTags\Models\Tag;
use RainLab\Blog\Models\Post;
use RainLab\User\Models\User;
use DB;

class PostForm extends ComponentBase {
	use \FireUnion\BlogFront\Traits\Loaders;
	use \FireUnion\BlogFront\Traits\Mailer;
	public $listPage;
	public $postPage;

	public function componentDetails() {
		return [
			'name' => 'fireunion.blogfront::lang.form_comp.name',
			'description' => 'fireunion.blogfront::lang.form_comp.description',
		];
	}

	public function defineProperties() {
		return $this->propertiesFor('form');
	}

	public function init() {

		$this->initFor('form');
		$this->post = $this->loadPost();

		if ($this->allow_images) {

			$manager = PluginManager::instance();
			if ($manager->exists('Responsiv.Uploader')) {

				$component = $this->addComponent(
					'Responsiv\Uploader\Components\ImageUploader',
					'imageUploader',
					[
						'placeholderText' => 'Add Image',
						'deferredBinding' => false,
						//'fileTypes' => 'jpg',
						'maxSize' => '3',
					]
				);
				$component->bindModel('featured_images', $this->post);
			} else {
				$this->allow_images = false;
				die('You must have <strong>Responsive.Uploader</strong> plugin installed and enabled to allow image uploading.  Disabling "Allow Image Uploading" should prvent this error from showing.');
			}
		}
	}

	public function onRun() {
		$this->runFor('form');
	}

	/**
	 * Ajax handler to save an event from form
	 * triggers onRun to show list after delete
	 * @return array for a flash like error message if there is a problem with form validation
	 */
	public function onSave() {
		if (!$this->save()) {
			return null;
		}
	
		$tagNamesStr = Input::get('tags_name');
		$tagNameArray = explode(",", $tagNamesStr);
		$insertArray = array();
		$attendeesName =Input::get('attendees');
		$attendeesArray =explode(",",$attendeesName);
		$attendeesNameArray=array();

		/* Delete post and tag relation */
		DB::table('bedard_blogtags_post_tag')->where('post_id', $this->post->id)->delete();
		/* Insert post and tag relation */
		foreach($tagNameArray as $tagName) {
			$tag = Tag::where("name", "=", $tagName)->first();
			if ($tag === null) {
				$newTag = new Tag();
				$newTag->name = $tagName;
				$newTag->save();
				$tagId = $newTag->id;
			} else {
				$tagId = $tag->id;
			}
			array_push($insertArray, ['post_id' => $this->post->id, 'tag_id' => $tagId]);
			
		}
		DB::table('bedard_blogtags_post_tag')->insert($insertArray);
		////attendees
		
		DB::table('rainlab_blog_user_post')->where('post_id', $this->post->id)->delete();
		foreach($attendeesArray as $attender) {
			
			$user = User::where("name", "=", $attender)->first();
			if ($user != null) {
				array_push($attendeesNameArray, ['post_id' => $this->post->id, 'user_id' => $user->id]);
			}
		}
		
		DB::table('rainlab_blog_user_post')->insert($attendeesNameArray);
		
		

		// Redirect to the intended page after successful update
		// $redirectUrl = $this->pageUrl($this->property('listPage'));
		$userID = DB::table('rainlab_blog_posts')->select('author_id')->where('id', $this->post->id)->first()->author_id;
		$redirectUrl = "/userpost/{$userID}";
		return Redirect::to($redirectUrl);
	}
}
