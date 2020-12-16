<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalCoRganiser extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_co_rganiser', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigInteger('list_id');
            $table->bigInteger('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_co_rganiser');
    }
}