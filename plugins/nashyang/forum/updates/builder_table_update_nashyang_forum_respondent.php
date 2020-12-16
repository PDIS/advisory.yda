<?php namespace Nashyang\Forum\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangForumRespondent extends Migration
{
    public function up()
    {
        Schema::table('nashyang_forum_respondent', function($table)
        {
            $table->text('keep_respondents')->nullable();
            $table->text('keep_prints')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_forum_respondent', function($table)
        {
            $table->dropColumn('keep_respondents');
            $table->dropColumn('keep_prints');
        });
    }
}
