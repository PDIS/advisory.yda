<?php namespace Nashyang\Forum\Models;

use Illuminate\Support\Facades\Mail;
use Model;
use Illuminate\Support\Facades\DB;
use October\Rain\Exception\AjaxException;

/**
 * Model
 */
class Issue extends Model {
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = [ 'deleted_at' ];

    protected $fillable = [
        'event_id',
        'questioner_company',
        'questioner_jobtitle',
        'questioner',
        'questioner_name',
        'questioner_email',
        'status',
        'is_tube',
        'is_sendmail',
        'phone',
        'suggest',
        'questioner_sort',
    ];

    public $rules = [
        'event_id' => 'required|numeric',
        'questioner_company' => 'required|string|min:1|max:100',
        'questioner_jobtitle' => 'required|string|min:1|max:100',
        'questioner' => 'required|string|min:1|max:2000',
        'questioner_name' => 'required|string|min:1|max:100',
        'questioner_email' => 'required|string|min:5',
        'status' => 'required|numeric|min:0|max:5',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_forum_issue_list';

    public $belongsTo = [
        'eventList' => [ 'Nashyang\Forum\Models\Event_list', 'key' => 'event_id' ],
    ];

    public function scopeEventID( $query, $eventID ) {
        return $query->where( 'event_id', $eventID );
    }

    public $hasOne = [];

    public $hasMany = [
        'respondents' => [
            'Nashyang\Forum\Models\Respondent',
            'key' => 'issue_id',
            'otherKey' => 'id',
            'order' => 'res_sort asc',
        ],
    ];

    public $belongsToMany = [
        'tag' => [
            'NashYang\Forum\Models\Tags',
            'table' => 'nashyang_forum_tag_and_issue',
            'key' => 'issue_id',
            'otherKey' => 'tag_id',
        ],
    ];

    public function getRespondentList( $fieldName, $value, $formData ) {
        $lists = [];
        foreach ( ForumUser::getUserList() AS $key => $user ) {
            $lists[ $user->id ] = empty( $user->headline ) ? $user->name : $user->headline . ' / ' . $user->name;
        }
        return $lists;
    }

    static public function getIssueListByEventID( $eventID ) {
        return Issue::where( 'event_id', $eventID )->orderBy( 'questioner_sort', 'asc' )->get();
    }

    static public function getEventIssueCount() {
        $dbObj = Issue::get();
        return $dbObj->groupBy('event_id')->toArray();
    }

    static public function getRespondentListByUserID( $userID, $eventID = NULL ) {
        $dbObj = DB::table( 'nashyang_forum_respondent AS res' )
            ->join( 'nashyang_forum_issue_list AS issue', 'issue.id', '=', 'res.issue_id' )
            ->join( 'nashyang_forum_event_list AS event', 'issue.event_id', '=', 'event.id' )
            ->select(
                'issue.questioner_name',
                'issue.questioner',
                'event.id AS eid',
                'event.name AS eventname',
                'event.location',
                'event.time AS eventtime',
                'issue.id AS issueid',
                'issue.status AS status',
                'res.prints',
                'res.is_reply',
                'res.respondents',
                'res.keep_respondents',
                'res.keep_prints',
                'res.id AS resid',
                'event.is_show'
            )
            ->where( 'res.user_id', $userID )
            ->whereNull( 'event.deleted_at' )
            ->whereNull( 'issue.deleted_at' )
            ->whereNull( 'res.deleted_at' );
        return is_null( $eventID ) ? $dbObj->get() : $dbObj->where( 'issue.event_id', $eventID )->get();
    }

    static public function getRespondentListByID( $id, $isCheckShow = TRUE ) {
        $obj = DB::table( 'nashyang_forum_issue_list' )
            ->join( 'nashyang_forum_event_list', 'nashyang_forum_issue_list.event_id', '=', 'nashyang_forum_event_list.id' )
            ->leftJoin( 'nashyang_forum_respondent', 'nashyang_forum_respondent.issue_id', '=', 'nashyang_forum_issue_list.id' )
            ->leftJoin( 'users', 'nashyang_forum_respondent.user_id', '=', 'users.id' )
            ->select(
                'nashyang_forum_issue_list.*',
                'users.name',
                'users.headline',
                'nashyang_forum_event_list.name AS eventname',
                'nashyang_forum_event_list.location',
                'nashyang_forum_event_list.time AS eventtime',
                'nashyang_forum_respondent.respondents',
                'nashyang_forum_respondent.etc_name'
            )
            ->where( 'nashyang_forum_issue_list.id', $id )
            ->whereNull( 'nashyang_forum_issue_list.deleted_at' )
            ->whereNull( 'nashyang_forum_event_list.deleted_at' )
            ->whereNull( 'nashyang_forum_respondent.deleted_at' );
        if ( $isCheckShow ) {
            $obj->where( 'nashyang_forum_event_list.is_show', '1' );
        }
        return $obj->get()->toArray();
    }


    static public function frontUpdateKeepRespondent() {
        $re = [
            'result' => FALSE,
            'message' => '資料更新失敗',
            'data' => post(),
        ];
        $issueModel = \Nashyang\Forum\Models\Issue::find( $re['data']['issueid'] );
        $resModel = Respondent::find( $re['data']['resid'] );
        if ( $resModel->user_id != $re['data']['userid'] ) {
            return $re;
        }
        if ( $issueModel->is_reply ) {
            if ( empty( $re['data']['prints'] ) ) {
                $re['message'] = '列印的名牌職稱與姓名必須輸入。';
                return $re;
            }
        }
        DB::transaction( function() use ( $resModel, $re ) {
            if ( $resModel->is_reply ) {
                $updateStr = empty( $re['data']['prints'] ) ? NULL : $re['data']['prints'];
                $resModel->update( [ 'keep_prints' => $updateStr ] );
            }
            $updateStr = empty( $re['data']['respondents'] ) ? NULL : $re['data']['respondents'];
            $resModel->update( [ 'keep_respondents' => $updateStr ] );
        } );
        $re['result'] = TRUE;
        $re['message'] = $re['result'] ? '回覆內容已暫存。' : $re['message'];
        return $re;
    }

    static public function frontUpdateRespondent() {
        $re = [
            'result' => FALSE,
            'message' => '資料更新失敗',
            'data' => post(),
        ];
        $issueModel = \Nashyang\Forum\Models\Issue::find( $re['data']['issueid'] );
        $resModel = Respondent::find( $re['data']['resid'] );
        if ( $resModel->user_id != $re['data']['userid'] ) {
            return $re;
        }
        if ( $issueModel->is_reply ) {
            if ( empty( $re['data']['prints'] ) ) {
                $re['message'] = '列印的名牌職稱與姓名必須輸入。';
                return $re;
            }
        }
        DB::transaction( function() use ( $resModel, $re ) {
            if ( $resModel->is_reply ) {
                $resModel->update( [
                    'prints' => $re['data']['prints'],
                    'keep_prints' => NULL,
                ] );
            }
            $resModel->update( [
                'respondents' => $re['data']['respondents'],
                'keep_respondents' => NULL,
            ] );
        } );
        $re['result'] = TRUE;
        $re['message'] = $re['result'] ? '回覆內容已送出。' : $re['message'];
        $isTube = $issueModel->status === 5 ? FALSE : TRUE;
        if ( $isTube ) {
            $event = $issueModel->eventList;
            $resList = Respondent::where( 'issue_id', $issueModel->id )->get()->toArray();
            $respondentsUserIDList = [];
            foreach ( $resList AS $res ) {
                if ( $res['user_id'] > 0 ) {
                    $respondentsUserIDList[] = $res['user_id'];
                }
            }
            foreach ( ForumUser::getUserEmailList( array_unique( $respondentsUserIDList ) ) AS $user ) {
                $mails[ $user->email ] = $user->name;
            }
            $mails[ $issueModel->questioner_email ] = $issueModel->questioner_name;
            $vars = [
                'eventName' => $event->name,
                'eventTime' => $event->time,
                'location' => $event->location,
                'link' => url( 'forumredirect/forum' ),
                'notificationCount' => '',
                'mailtemplates' => 'nashyang.forum::mail.NotificationDepartmentTubeReply',
            ];
            Mail::send( $vars['mailtemplates'], $vars, function( $message ) use ( $mails ) {
                $message->from( 'yda_noreply@mail.yda.gov.tw', '行政院青年諮詢委員會(系統郵件)' )
                    ->bcc( $mails, $name = NULL );
            } );
        }
        return $re;
    }

    static public function getQuestionerEmailByEventID( $eventID ) {
        return DB::table( 'nashyang_forum_event_list AS event' )
            ->join( 'nashyang_forum_issue_list AS issue', 'event.id', '=', 'issue.event_id' )
            ->select(
                'issue.questioner_email AS email',
                'issue.questioner_name AS name'
            )
            ->where( 'event.id', $eventID )
            ->whereNull( 'issue.deleted_at' )
            ->whereNull( 'event.deleted_at' )
            ->distinct()->get();
    }

    static public function getRespondentsUserEmailByEventID( $eventID ) {
        return DB::table( 'nashyang_forum_event_list AS event' )
            ->join( 'nashyang_forum_issue_list AS issue', 'event.id', '=', 'issue.event_id' )
            ->join( 'nashyang_forum_respondent AS res', 'res.issue_id', '=', 'issue.id' )
            ->join( 'users AS user', 'res.user_id', '=', 'user.id' )
            ->select( 'user.email', 'user.name' )
            ->where( 'event.id', $eventID )
            ->whereNotNull( 'res.user_id' )
            ->whereNull( 'res.deleted_at' )
            ->whereNull( 'issue.deleted_at' )
            ->whereNull( 'event.deleted_at' )
            ->distinct()->get();
    }

    static public $issueStatusArr = [
//        [ 'css' => 'info', 'str' => '提案', ],
//        [ 'css' => 'warning', 'str' => '進行中', ],
//        [ 'css' => 'secondary', 'str' => '部分參採', ],
//        [ 'css' => 'success', 'str' => '完全參採', ],
//        [ 'css' => 'danger', 'str' => '暫不參採', ],
//        [ 'css' => 'third', 'str' => '其他', ],
        [ 'css' => 'info', 'str' => '已回覆', ],
        [ 'css' => 'warning', 'str' => '處理中', ],
        [],
        [],
        [],
        [ 'css' => 'third', 'str' => '其他', ],
    ];

    static public function getStatusClass( $status ) {
        return isset( self::$issueStatusArr[ $status ]['css'] ) ? self::$issueStatusArr[ $status ]['css'] : '';
    }

    static public function getStatusStr( $status ) {
        return isset( self::$issueStatusArr[ $status ]['str'] ) ? self::$issueStatusArr[ $status ]['str'] : '未知的狀態';
    }
}