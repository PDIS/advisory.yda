<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMarkdaiSayitpluginDebateSectionSpeech extends Migration
{
    public function up()
    {
        Schema::table('markdai_sayitplugin_debate_section_speech', function($table)
        {
            $table->increments('id')->change();
        });
    }
    
    public function down()
    {
        Schema::table('markdai_sayitplugin_debate_section_speech', function($table)
        {
            $table->integer('id')->change();
        });
    }
}
