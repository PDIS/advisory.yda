<?php namespace Tom\Postadd\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddNewFields extends Migration
{

    
    public function up()
    {
        Schema::table('rainlab_blog_posts', function($table)
        {
         
            $table->text('event_date')->nullable();
            $table->text('location')->nullable();
            $table->text('organizer')->nullable();
            $table->text('contact')->nullable();
            $table->text('preside')->nullable();
            $table->text('attendees')->nullable();
         
        });
        
    }

    public function down()
    {
        Schema::drop('rainlab_blog_posts');
    }

}
