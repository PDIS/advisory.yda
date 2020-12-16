<?php namespace Ntut\AdvisoryYda\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRainlabBlogReconsiderationUserPost extends Migration
{
    public function up()
    {
        Schema::create('rainlab_blog_reconsideration_user_post', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('post_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rainlab_blog_reconsideration_user_post');
    }
}
