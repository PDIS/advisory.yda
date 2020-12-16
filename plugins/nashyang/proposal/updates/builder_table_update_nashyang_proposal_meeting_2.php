<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalMeeting2 extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_meeting', function($table)
        {
            $table->string('name_as', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_meeting', function($table)
        {
            $table->dropColumn('name_as');
        });
    }
}
