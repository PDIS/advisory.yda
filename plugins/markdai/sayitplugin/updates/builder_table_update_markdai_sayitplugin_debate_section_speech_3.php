<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMarkdaiSayitpluginDebateSectionSpeech3 extends Migration
{
    public function up()
    {
        Schema::table('markdai_sayitplugin_debate_section_speech', function($table)
        {
            $table->text('speech')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('markdai_sayitplugin_debate_section_speech', function($table)
        {
            $table->string('speech', 512)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
