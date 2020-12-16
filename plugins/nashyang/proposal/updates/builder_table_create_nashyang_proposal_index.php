<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalIndex extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_index', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigInteger('list_id');
            $table->bigInteger('meeting_index')->nullable();
            $table->bigInteger('list_index')->nullable();
            $table->string('customer_index', 255)->nullable();
            $table->primary(['list_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_index');
    }
}