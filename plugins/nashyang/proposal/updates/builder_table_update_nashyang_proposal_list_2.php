<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalList2 extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_list', function($table)
        {
            $table->boolean('is_show')->nullable()->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_list', function($table)
        {
            $table->dropColumn('is_show');
        });
    }
}
