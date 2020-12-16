<?php namespace Nashyang\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangForumIssueList extends Migration
{
    public function up()
    {
        Schema::create('nashyang_forum_issue_list', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('event_id');
            $table->smallInteger('status')->default(0);
            $table->text('questioner_name');
            $table->text('questioner_company');
            $table->text('questioner_jobtitle');
            $table->text('questioner');
            $table->text('suggest');
            $table->text('phone');
            $table->text('questioner_email');
            $table->boolean('is_tube')->default(0);
            $table->boolean('is_sendmail')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_forum_issue_list');
    }
}