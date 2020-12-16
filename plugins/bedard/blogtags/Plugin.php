<?php namespace Bedard\BlogTags;

use Backend;
use Bedard\BlogTags\Models\Tag;
use Config;
use Event;
use System\Classes\PluginBase;
use RainLab\Blog\Controllers\Posts as PostsController;
use RainLab\User\Controllers\Users as UsersController;
use RainLab\Blog\Models\Post as PostModel;
use RainLab\User\Models\User as UserModel;
/**
 * BlogTags Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var array   Require the RainLab.Blog plugin
     */
    public $require = ['RainLab.Blog'];

    /**
     * Returns information about this plugin
     *
     * @return  array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'bedard.blogtags::lang.plugin.name',
            'description' => 'bedard.blogtags::lang.plugin.description',
            'author'      => 'Scott Bedard',
            'icon'        => 'icon-tags',
            'homepage'    => 'https://github.com/scottbedard/blogtags'
        ];
    }

    /**
     * Register components
     *
     * @return  array
     */
    public function registerComponents()
    {
        return [
            'Bedard\BlogTags\Components\BlogTags'      => 'blogTags',
            'Bedard\BlogTags\Components\BlogTagSearch' => 'blogTagSearch',
            'Bedard\BlogTags\Components\BlogRelated'   => 'blogRelated'
        ];
    }

    public function boot()
    {
        // extend the blog navigation
        Event::listen('backend.menu.extendItems', function($manager) {
           $manager->addSideMenuItems('RainLab.Blog', 'blog', [
                'tags' => [
                    'label' => 'bedard.blogtags::lang.navigation.tags',
                    'icon'  => 'icon-tags',
                    'code'  => 'tags',
                    'owner' => 'RainLab.Blog',
                    'url'   => Backend::url('bedard/blogtags/tags')
                ]
            ]);
        });

        // extend the post model
        PostModel::extend(function($model) {
            $model->belongsToMany['tags'] = [
                'Bedard\BlogTags\Models\Tag',
                'table' => 'bedard_blogtags_post_tag',
                'order' => 'name'
            ];
        });

        // extend the post model
        PostModel::extend(function($model) {
            $model->belongsToMany['users'] = [
                'RainLab\User\Models\User',
                'table' => 'rainlab_blog_user_post'
            ];
        });

        // extend the post model
        PostModel::extend(function($model) {
            $model->belongsToMany['reconsideration_users'] = [
                'RainLab\User\Models\User',
                'table' => 'rainlab_blog_reconsideration_user_post'
            ];
        });
        // extend the post model
        PostModel::extend(function($model) {
            $model->belongsToMany['post_child'] = [
                'RainLab\Blog\Models\Post',
                'table' => 'rainlab_blog_post_children',
                'key' => 'post_child_id'
            ];
        });

        // extend the post form
        PostsController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof PostModel) {
                return;
            }

            $form->addSecondaryTabFields([
                'tags' => [
                    'label' => 'Tags',
                    'mode'  => 'relation',
                    'tab'   => 'rainlab.blog::lang.post.tab_categories',
                    'type'  => 'taglist'
                ],
                'users' => [
                    'label' => '提案委員/出席委員',
                    'mode'  => 'relation',
                    'tab'   => 'rainlab.blog::lang.post.tab_categories',
                    'type'  => 'taglist'
                ],
                'reconsideration_users' => [
                    'label' => '連署委員',
                    'mode'  => 'relation',
                    'tab'   => 'rainlab.blog::lang.post.tab_categories',
                    'type'  => 'taglist'
                ],
                'post_child' => [
                    'label' => '相關提案',
                    'mode'  => 'relation',
                    'tab'   => 'rainlab.blog::lang.post.tab_categories',
                    'type'=> 'checkboxlist'
                    
                ],
                'level' => [
                    'label' => '專案進度',
                    'mode'  => 'relation',
                    'tab'   => 'rainlab.blog::lang.post.tab_categories',
                    'type'  => 'dropdown',
                    'placeholder' => '-- select a status --',
                    'options'=>[
                    '1'=> '提案',
                    '2'=> '進行中',
                    '3'=> '部分參採',
                    '4'=> '完全參採',
                    '5'=> '暫不參採']
                ]
            ]);
        });
    }
}
