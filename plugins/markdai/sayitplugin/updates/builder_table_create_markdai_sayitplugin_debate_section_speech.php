<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMarkdaiSayitpluginDebateSectionSpeech extends Migration
{
    public function up()
    {
        Schema::create('markdai_sayitplugin_debate_section_speech', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->integer('debate_section_id');
            $table->string('speaker');
            $table->string('speech');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('markdai_sayitplugin_debate_section_speech');
    }
}
