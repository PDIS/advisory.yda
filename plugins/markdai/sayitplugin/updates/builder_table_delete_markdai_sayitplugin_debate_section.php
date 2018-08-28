<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteMarkdaiSayitpluginDebateSection extends Migration
{
    public function up()
    {
        Schema::dropIfExists('markdai_sayitplugin_debate_section');
    }
    
    public function down()
    {
        Schema::create('markdai_sayitplugin_debate_section', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('debate_id');
            $table->string('speaker');
            $table->string('speech');
        });
    }
}
