<?php namespace Nashyang\Forum\Models;

use Model;
use Illuminate\Support\Facades\DB;

/**
 * Model
 */
class TagIssue extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_forum_tag_and_issue';

    static public function getTagNameListByIssueID( $issueID ) {
        $nameList = [];
        $dbResult = DB::table( 'nashyang_forum_tag_and_issue' )
            ->join( 'bedard_blogtags_tags as tags', 'nashyang_forum_tag_and_issue.tag_id', '=', 'tags.id' )
            ->select( 'tags.name' )
            ->where( 'nashyang_forum_tag_and_issue.issue_id', '=', $issueID )
//            ->whereNull( 'tags.deleted_at' )
            ->get()
            ->toArray();
        foreach ( $dbResult AS $queryResult ) {
            $nameList[] = $queryResult->name;
        }
        return $nameList;
    }
}