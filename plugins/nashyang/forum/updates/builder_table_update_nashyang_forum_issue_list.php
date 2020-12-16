<?php namespace Nashyang\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangForumIssueList extends Migration
{
    public function up()
    {
        Schema::table('nashyang_forum_issue_list', function($table)
        {
            $table->integer('questioner_sort')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_forum_issue_list', function($table)
        {
            $table->dropColumn('questioner_sort');
        });
    }
}
