<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalMeeting4 extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_meeting', function($table)
        {
            $table->boolean('is_pre')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_meeting', function($table)
        {
            $table->dropColumn('is_pre');
        });
    }
}
