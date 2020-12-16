<?php namespace Ntut\AdvisoryYda\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBedardBlogtagsUserTag extends Migration
{
    public function up()
    {
        Schema::create('bedard_blogtags_user_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('tag_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bedard_blogtags_user_tag');
    }
}
