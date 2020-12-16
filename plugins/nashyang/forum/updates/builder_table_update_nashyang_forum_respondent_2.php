<?php namespace Nashyang\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangForumRespondent2 extends Migration
{
    public function up()
    {
        Schema::table('nashyang_forum_respondent', function($table)
        {
            $table->integer('res_sort')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_forum_respondent', function($table)
        {
            $table->dropColumn('res_sort');
        });
    }
}
