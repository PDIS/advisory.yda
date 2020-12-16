<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalHostrespondents extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_hostrespondents', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigInteger('list_id');
            $table->bigInteger('res_id');
            $table->text('respondents')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['list_id','res_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_hostrespondents');
    }
}