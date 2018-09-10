<?php namespace Ntut\AdvisoryYda\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRainlabBlogUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->integer('sort_num')->unsigned()->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('sort_num');
        });
    }
}