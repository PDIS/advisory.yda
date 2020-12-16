<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalListMeeting extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_list_meeting', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigInteger('meeting_id');
            $table->bigInteger('list_id');
            $table->smallInteger('status')->default(1);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_list_meeting');
    }
}