<?php namespace Nashyang\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangForumEventList extends Migration
{
    public function up()
    {
        Schema::create('nashyang_forum_event_list', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->dateTime('time');
            $table->string('location', 255);
            $table->string('debate_link', 500);
            $table->string('etc', 255)->nullable();
            $table->boolean('is_show')->default(0);
            $table->boolean('is_send1')->default(0);
            $table->boolean('is_send2')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_forum_event_list');
    }
}