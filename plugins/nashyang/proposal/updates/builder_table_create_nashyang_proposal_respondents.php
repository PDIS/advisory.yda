<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateNashyangProposalRespondents extends Migration
{
    public function up()
    {
        Schema::create('nashyang_proposal_respondents', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('meeting_id');
            $table->bigInteger('list_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('etc_name', 255)->nullable();
            $table->text('respondents')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nashyang_proposal_respondents');
    }
}