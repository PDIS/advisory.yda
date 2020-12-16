<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMarkdaiSayitpluginDebateSection2 extends Migration
{
    public function up()
    {
        Schema::create('markdai_sayitplugin_debate_section', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->integer('debate_id');
            $table->string('heading');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('markdai_sayitplugin_debate_section');
    }
}
