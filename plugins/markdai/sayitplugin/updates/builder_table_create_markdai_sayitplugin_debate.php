<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMarkdaiSayitpluginDebate extends Migration
{
    public function up()
    {
        Schema::create('markdai_sayitplugin_debate', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('heading');
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('markdai_sayitplugin_debate');
    }
}
