<?php namespace Nashyang\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangForumTagAndIssue extends Migration
{
    public function up()
    {
        Schema::create('nashyang_forum_tag_and_issue', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigInteger('tag_id');
            $table->bigInteger('issue_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_forum_tag_and_issue');
    }
}