<?php namespace Nashyang\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangForumRespondent extends Migration
{
    public function up()
    {
        Schema::create('nashyang_forum_respondent', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('issue_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('etc_name', 255)->nullable();
            $table->text('respondents')->nullable();
            $table->boolean('is_reply')->default(0);
            $table->text('prints')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_forum_respondent');
    }
}