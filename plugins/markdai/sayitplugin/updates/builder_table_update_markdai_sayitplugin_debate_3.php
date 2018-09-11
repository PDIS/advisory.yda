<?php namespace MarkDai\SayitPlugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMarkdaiSayitpluginDebate3 extends Migration
{
    public function up()
    {
        Schema::table('markdai_sayitplugin_debate', function($table)
        {
            $table->integer('post_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('markdai_sayitplugin_debate', function($table)
        {
            $table->integer('post_id')->nullable(false)->change();
        });
    }
}
