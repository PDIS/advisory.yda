<?php namespace Ntut\AdvisoryYda\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateRainlabBlogPostChildren extends Migration
{
    public function up()
    {
        Schema::create('rainlab_blog_post_children', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('post_id')->unsigned();
            $table->integer('post_child_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rainlab_blog_post_children');
    }
}
