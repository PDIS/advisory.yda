<?php namespace Nashyang\Proposal\Models;

use Illuminate\Support\Facades\DB;
use Model;
use October\Rain\Support\Facades\Flash;

/**
 * Model
 */
class Proposal_list extends Model {
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = [ 'deleted_at' ];

    /*
     * Validation
     */
    public $rules = [
        'user_id' => 'required|integer',
        'content' => 'required|string|min:2',
        'description' => 'required|string|min:2',
        'suggest' => 'required|string|min:2',
    ];

    protected $fillable = [ 'user_id', 'content', 'description', 'status', 'suggest', 'sort', 'is_show' ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_list';

    public $belongsTo = [
        'user' => [ 'RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'id' ],
        'meetingIndex' => [ 'Nashyang\Proposal\Models\Meeting_index', 'key' => 'id', 'otherKey' => 'list_id' ],
    ];

    public $belongsToMany = [
        'corganiseruser' => [
            'Nashyang\Proposal\Models\User',
            'table' => 'nashyang_proposal_co_rganiser',
            'key' => 'list_id',
            'otherKey' => 'user_id',
        ],
        'plusoneuser' => [
            'Nashyang\Proposal\Models\User',
            'table' => 'nashyang_proposal_countersign',
            'key' => 'list_id',
            'otherKey' => 'user_id',
            'pivot' => [ 'why', 'id' ],
            'timestamps' => TRUE,
        ],
        'hostrespondent' => [
            'Nashyang\Proposal\Models\Respondents',
            'table' => 'nashyang_proposal_hostrespondents',
            'key' => 'res_id',
            'otherKey' => 'list_id',
//            'pivot' => [ 'respondents', ],
            'timestamps' => TRUE,
        ],
    ];

    public $hasOne = [
        'user' => [
            'Nashyang\Proposal\Models\User',
            'key' => 'id',
            'otherKey' => 'user_id',
        ],
    ];

    public $hasMany = [
        'countersign' => [ 'Nashyang\Proposal\Models\Countersign', 'key' => 'list_id', 'otherKey' => 'id' ],
        'respondents' => [ 'Nashyang\Proposal\Models\Respondents', 'key' => 'list_id', 'otherKey' => 'id' ],
        'department' => [ 'Nashyang\Proposal\Models\List_department', 'key' => 'list_id', 'otherKey' => 'id' ],
        'corganiser' => [ 'Nashyang\Proposal\Models\Coganiser', 'key' => 'list_id', 'otherKey' => 'id' ],
    ];

    public static $statusArr = [
        0 => '委員提案',
        1 => '自行撤案',
        2 => '暫不提大會',
        3 => '送部會研處',
        4 => '大會否決',
        5 => '辦理中',
        6 => '完全參採',
        7 => '部分參採',
        8 => '暫不參採',
    ];

    public static $preStatusArr = [
        1 => '委員自行撤案',
        3 => '送部會研處',
        4 => '會前會辦理中',
        5 => '送交大會',
        6 => '完全參採',
        7 => '部分參採',
        8 => '暫不參採',
    ];

    public static function createProposalList() {
        $postData = post();
        $listID = Proposal_list::create( post() )->id;
        if ( isset( $postData['authority'] ) ) {
            foreach ( $postData['authority'] AS $valorName ) {
                $appendArr = [
                    'list_id' => $listID,
                    'user_id' => is_numeric( $valorName ) ? $valorName : NULL,
                    'etc_name' => !is_numeric( $valorName ) ? $valorName : NULL,
                    'isco' => 0,
                ];
                List_department::create( $appendArr );
            }
        }
        if ( isset( $postData['coauthority'] ) ) {
            foreach ( $postData['coauthority'] as $valorName ) {
                $appendArr = [
                    'list_id' => $listID,
                    'user_id' => is_numeric( $valorName ) ? $valorName : NULL,
                    'etc_name' => !is_numeric( $valorName ) ? $valorName : NULL,
                    'isco' => 1,
                ];
                List_department::create( $appendArr );
            }
        }
        Flash::success( '操作成功。' );
    }

    public static function updateProposalList() {
        $id = post( 'listid' );
        $userID = post( 'user_id' );
        $model = Countersign::where( 'listid', $id )->where( 'user_id', $userID );
        if ( $model->count() > 0 ) {
            $model->delete();
        } else {
            Countersign::create( [
                'why' => post( 'why' ) === '' ? NULL : post( 'why' ),
                'user_id' => $userID,
                'list_id' => $id,
            ] );
        }
        Flash::success( '操作成功。' );
    }

    public static function cancelProposalList() {
        $model = Proposal_list::find( post( 'id' ) );
        $model->status = '2';
        $model->save();
        Flash::success( '操作成功。' );
    }

    public function getNameuser_idOptions() {
        return ForumUser::getCommitteeMemberList();
    }

    public function getDepartmentOptions() {
        $listID = post( 'listid' );
        $meetingID = post( 'meetingid' );
        return Respondents::where( 'meeting_id', $meetingID )->where( 'list_id', $listID )->list();
    }

    public function getCustomerMeetIndexAttribute( $value ) {
        return is_null( $this->meetingIndex->customer_index ) ?
            $this->meetingIndex->meeting_index . '-' . $this->meetingIndex->list_index :
            $this->meetingIndex->customer_index;
    }

    public function getstatusStrAttribute( $value ) {
        return self::$statusArr[ $this->attributes['status'] ];
    }


}