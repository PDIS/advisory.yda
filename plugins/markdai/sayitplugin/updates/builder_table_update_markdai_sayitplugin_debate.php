<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMarkdaiSayitpluginDebate extends Migration
{
    public function up()
    {
        Schema::table('markdai_sayitplugin_debate', function($table)
        {
            $table->string('anurl')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('markdai_sayitplugin_debate', function($table)
        {
            $table->dropColumn('anurl');
        });
    }
}
