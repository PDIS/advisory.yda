<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalList extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_list', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->text('content');
            $table->text('description');
            $table->text('suggest');
            $table->bigInteger('meeting_id')->nullable();
            $table->smallInteger('status')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('expiration_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_list');
    }
}