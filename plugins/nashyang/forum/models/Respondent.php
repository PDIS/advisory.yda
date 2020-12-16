<?php namespace Nashyang\Forum\Models;

use Illuminate\Support\Facades\DB;
use Model;

/**
 * Model
 */
class Respondent extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'issue_id', 'user_id', 'etc_name', 'respondents', 'is_reply', 'prints', 'keep_respondents', 'keep_prints', 'res_sort'
    ];

    /*
     * Validation
     */
    public $rules = [];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_forum_respondent';

    public $hasOne = [
        'users' => [
            'RainLab\User\Models\User',
            'key' => 'id',
            'otherKey' => 'user_id',
        ],
    ];

    public $belongsTo = [
        'issue' => [ 'Nashyang\Forum\Models\Issue', 'key' => 'issue_id' ],
    ];

    static public function getQuestionerUserIDAndEtcNameByIssueID( $issueID ) {
        $returnList = [
            'userID' => [],
            'etcName' => [],
        ];
        $dbResult = Respondent::where( 'issue_id', $issueID )->select( 'user_id', 'etc_name' )->get()->toArray();
        foreach ( $dbResult AS $queryResult ) {
            if ( $queryResult['user_id'] )
                $returnList['userID'][] = $queryResult['user_id'];
            if ( $queryResult['etc_name'] )
                $returnList['etcName'][] = $queryResult['etc_name'];
        }
        return $returnList;
    }

    static public function getQuestionerUserIDByIssueID( $issueID ) {
        return self::getQuestionerUserIDAndEtcNameByIssueID( $issueID )['etcName'];
    }

    static public function getQuestionerEtcNameByIssueID( $issueID ) {
        return self::getQuestionerUserIDAndEtcNameByIssueID( $issueID )['userID'];
    }

    static public function getRespondentAndUserDataByIssueID( $issueID ) {
        return DB::table( 'nashyang_forum_respondent AS res' )
            ->leftJoin( 'users', 'res.user_id', '=', 'users.id' )
            ->select( 'res.id', 'users.name', 'res.etc_name', 'res.respondents', 'res.is_reply', 'res.prints', 'res.updated_at' )
            ->where( 'res.issue_id', $issueID )
            ->whereNull( 'res.deleted_at' )
            ->orderBy('res.res_sort', 'asc')
            ->get()->toArray();
    }

}