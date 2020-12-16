<?php namespace Nashyang\Proposal\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateNashyangProposalListDepartment extends Migration
{
    public function up()
    {
        Schema::table('nashyang_proposal_list_department', function($table)
        {
            $table->boolean('isco')->default(0);
            $table->dropColumn('respondents');
        });
    }
    
    public function down()
    {
        Schema::table('nashyang_proposal_list_department', function($table)
        {
            $table->dropColumn('isco');
            $table->text('respondents')->nullable();
        });
    }
}