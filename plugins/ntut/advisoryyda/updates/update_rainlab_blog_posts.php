<?php namespace Ntut\AdvisoryYda\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRainlabBlogPosts extends Migration
{
    public function up()
    {
        Schema::table('rainlab_blog_posts', function($table)
        {
            $table->integer('level')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('rainlab_blog_posts', function($table)
        {
            $table->dropColumn('level');
        });
    }
}