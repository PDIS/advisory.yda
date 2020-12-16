<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalMeeting extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_meeting', function($table)
        {
            $table->dateTime('time')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_meeting', function($table)
        {
            $table->dateTime('time')->nullable(false)->change();
        });
    }
}