<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalRespondents2 extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_respondents', function($table)
        {
            $table->integer('res_sort')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_respondents', function($table)
        {
            $table->dropColumn('res_sort');
        });
    }
}
