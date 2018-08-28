<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMarkdaiSayitpluginDebate2 extends Migration
{
    public function up()
    {
        Schema::table('markdai_sayitplugin_debate', function($table)
        {
            $table->string('anurl')->nullable(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('markdai_sayitplugin_debate', function($table)
        {
            $table->string('anurl')->nullable()->change();
        });
    }
}
