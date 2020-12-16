<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalListMeetingResolution extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_list_meeting_resolution', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('meeting_id');
            $table->bigInteger('list_id');
            $table->string('responsibility', 1000)->nullable();
            $table->text('resolution')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_list_meeting_resolution');
    }
}