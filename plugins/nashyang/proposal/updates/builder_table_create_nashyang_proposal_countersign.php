<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalCountersign extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_countersign', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('list_id');
            $table->bigInteger('user_id');
            $table->text('why')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_countersign');
    }
}