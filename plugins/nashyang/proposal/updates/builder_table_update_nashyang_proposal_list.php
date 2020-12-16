<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalList extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_list', function($table)
        {
            $table->integer('sort')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_list', function($table)
        {
            $table->dropColumn('sort');
        });
    }
}
