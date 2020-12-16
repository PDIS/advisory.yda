<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalHostrespondents extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_hostrespondents', function($table)
        {
            $table->text('other_reply')->nullable();
            $table->text('other_reply1')->nullable();
            $table->text('other_reply2')->nullable();
            $table->text('other_reply3')->nullable();
            $table->text('other_reply4')->nullable();
            $table->text('other_reply5')->nullable();
            $table->text('other_reply6')->nullable();
            $table->text('other_reply7')->nullable();
            $table->text('other_reply8')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_hostrespondents', function($table)
        {
            $table->dropColumn('other_reply');
            $table->dropColumn('other_reply1');
            $table->dropColumn('other_reply2');
            $table->dropColumn('other_reply3');
            $table->dropColumn('other_reply4');
            $table->dropColumn('other_reply5');
            $table->dropColumn('other_reply6');
            $table->dropColumn('other_reply7');
            $table->dropColumn('other_reply8');
        });
    }
}