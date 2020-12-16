<?php namespace Nashyang\Proposal\Models;

use Model;
use October\Rain\Support\Facades\Flash;

/**
 * Model
 */
class Respondents extends Model {
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = [ 'deleted_at' ];

    /*
     * Validation
     */
    public $rules = [
    ];

    protected $fillable = [
        'meeting_id', 'list_id', 'user_id', 'etc_name', 'respondents', 'other_reply1', 'other_reply2',
        'other_reply3', 'other_reply4', 'other_reply6', 'other_reply7', 'other_reply8', 'res_sort',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_respondents';

    public $belongsTo = [
        'user' => [ 'RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'id' ],
    ];

    public $hasOne = [
        'users' => [
            'RainLab\User\Models\User',
            'key' => 'id',
            'otherKey' => 'user_id',
        ],
        'hostres' => [
            'Nashyang\Proposal\Models\HostRes',
            'key' => 'res_id',
            'otherKey' => 'id',
        ],
        'prolist' => [
            'Nashyang\Proposal\Models\Proposal_list',
            'key' => 'id',
            'otherKey' => 'list_id',
        ],
        'meeting' => [
            'Nashyang\Proposal\Models\Meeting',
            'key' => 'id',
            'otherKey' => 'meeting_id',
        ],
    ];

    public static function getUserNameOrEtcName( $id ) {
        $model = self::find( $id );
        return is_null( $model->user_id ) ? $model->etc_name : $model->users->name;
    }

    static function frontUpdateRespondent() {
        self::find( post( 'resid' ) )->update( [
            'respondents' => post( 'respondents' ),
            'other_reply1' => post( 'other_reply1' ),
            'other_reply2' => post( 'other_reply2' ),
            'other_reply3' => post( 'other_reply3' ),
            'other_reply4' => post( 'other_reply4' ),
            'other_reply6' => post( 'other_reply6' ),
            'other_reply7' => post( 'other_reply7' ),
            'other_reply8' => post( 'other_reply8' ),
        ] );
        if ( !is_null( post( 'respondentshost' ) ) ) {
            HostRes::where( 'res_id', post( 'resid' ) )->update( [
                'respondents' => post( 'respondentshost' ),
                'other_reply' => post( 'hostother_reply' ),
                'other_reply1' => post( 'hostother_reply1' ),
                'other_reply2' => post( 'hostother_reply2' ),
                'other_reply3' => post( 'hostother_reply3' ),
                'other_reply4' => post( 'hostother_reply4' ),
                'other_reply5' => post( 'hostother_reply5' ),
                'other_reply6' => post( 'hostother_reply6' ),
                'other_reply7' => post( 'hostother_reply7' ),
                'other_reply8' => post( 'hostother_reply8' ),
            ] );
        }
        Flash::success( '操作完成。' );
    }

    static public function getFrontRespondentByListId( $_listID, $_isAdmin = FALSE ) {
        $prolistModel = Proposal_list::find( $_listID );
        $indexObj = Meeting_index::where( 'list_id', $_listID )->first();
        $resObj = Respondents::where( 'list_id', $_listID )->orderBy( 'meeting_id', 'desc' )->orderBy( 'res_sort', 'asc' )->get();
        $countersignArr = [];
        $countersignUserList = Countersign::where( 'list_id', $_listID )->lists( 'user_id' );
        foreach ( $countersignUserList AS $uid ) {
            $userObj = \RainLab\User\Models\User::find( $uid );
            $countersignArr[] = [
                'thumb' => $userObj->getAvatarThumb( 100 ),
                'name' => $userObj->name,
                'id' => $uid,
            ];
        }

        $cou = [];
        $cou[] = [
            'thumb' => \RainLab\User\Models\User::find( $prolistModel->user_id )->getAvatarThumb( 100 ),
            'name' => $prolistModel->user->name,
            'id' => $prolistModel->user_id,
        ];
        foreach ( $prolistModel->corganiser AS $k => $v ) {
            $cou[] = [
                'thumb' => \RainLab\User\Models\User::find( $v->user->id )->getAvatarThumb( 100 ),
                'name' => $v->user->name,
                'id' => $v->user->id,
            ];
        }

        $resArr = $resStatusMeetingArr = $resMeetingName = $resMeetingTime = $resMeetingAsName = [];
        foreach ( $resObj AS $otherResObj ) {
            if ( is_null( Meeting::find( $otherResObj->meeting_id ) ) ) {
                continue;
            }
            $meetingTime = Meeting::find( $otherResObj->meeting_id )->is_show;
            if ( !$meetingTime && !$_isAdmin ) {
                continue;
            }
            if ( !isset( $resArr[ $otherResObj->meeting_id ] ) ) {
                $resArr[ $otherResObj->meeting_id ] = [];
            }
            $resMeetingAsName[ $otherResObj->meeting_id ] = empty( $otherResObj->meeting->name_as ) ? $otherResObj->meeting->name : $otherResObj->meeting->name_as;
            $resMeetingName[ $otherResObj->meeting_id ] = $otherResObj->meeting->name;
            $resMeetingTime[ $otherResObj->meeting_id ] = $otherResObj->meeting->time;
            $resStatusMeetingArr[ $otherResObj->meeting_id ] = List_meeting::where( 'meeting_id', $otherResObj->meeting_id )
                ->where( 'list_id', $_listID )->first()->status;
            $resArr[ $otherResObj->meeting_id ][] = [
                'meetingid' => $otherResObj->meeting_id,
                'meetingname' => $otherResObj->meeting->name,
                'name' => is_null( $otherResObj->etc_name ) ? $otherResObj->users->name : $otherResObj->etc_name,
                'res' => !is_null( $otherResObj->respondents ) ? nl2br( $otherResObj->respondents ) : "",
                'res2' => !is_null( $otherResObj->other_reply2 ) ? nl2br( $otherResObj->other_reply2 ) : "",
                'ishost' => !is_null( $otherResObj->hostres ),
                'hostres' => !is_null( $otherResObj->hostres ) ? is_null( $otherResObj->hostres->respondents ) ? '' : nl2br( $otherResObj->hostres->respondents ) : '',
            ];
        }
        $resolutionArr = [
            'responsibility' => [],
            'resolution' => [],
        ];
        $resolutionLists = Resolution::where( 'list_id', $_listID )->lists( 'id' );
        foreach ( $resolutionLists AS $id ) {
            $rObj = Resolution::find( $id );
            if ( $rObj->responsibility ) {
                $resolutionArr['responsibility'][ (int)$rObj->meeting->id ] = [
                    'name' => $rObj->meeting->name,
                    'datetime' => $rObj->meeting->time,
                    'responsibility' => nl2br( $rObj->responsibility ),
                ];
            }
            if ( $rObj->resolution ) {
                $resolutionArr['resolution'][ (int)$rObj->meeting->id ] = [
                    'name' => $rObj->meeting->name,
                    'datetime' => $rObj->meeting->time,
                    'resolution' => nl2br( $rObj->resolution ),
                ];
            }
        }


        $statusCss = [
            3 => 'status_active',
            4 => 'status_active',
            5 => 'status_processing',
            6 => 'status_done',
            7 => 'status_almost',
            8 => 'status_notok',
        ];
        // getAvatarThumb
        return [
            'index' => is_null( $indexObj->customer_index ) ? $indexObj->meeting_index . '-' . $indexObj->list_index : $indexObj->customer_index,
            'content' => nl2br( $prolistModel->content ),
            'description' => nl2br( $prolistModel->description ),
            'suggest' => nl2br( $prolistModel->suggest ),
            'corganiserlist' => $cou,
            'countersignlist' => $countersignArr,
            'status' => $prolistModel->status,
            'statusstr' => Proposal_list::$statusArr[ $prolistModel->status ],
            'statuscss' => $statusCss[ $prolistModel->status ],
            'res' => $resArr,
            'resStatusMeeting' => $resStatusMeetingArr,
            'resMeetingName' => $resMeetingName,
            'resMeetingAsName' => $resMeetingAsName,
            'resMeetingTime' => $resMeetingTime,
            'resolution' => $resolutionArr,
        ];
    }

    static public function getRespondentListByUserID( $userID ) {
        $returnArr = [];
        foreach ( self::where( 'user_id', $userID )->get() as $resObj ) {
            $prolistObj = $resObj->prolist;
            if ( is_null( $resObj->meeting ) ) {
                continue;
            }
            if ( $resObj->meeting->time < date( 'Y-m-d H:i:s' ) && !is_null( $resObj->meeting->time ) ) {
                continue;
            }
            if ( $prolistObj->status !== 3 && $prolistObj->status !== 5 ) {
                continue;
            }
            $meetObj = Meeting::find( $resObj->meeting_id );
            $indexObj = Meeting_index::where( 'list_id', $resObj->list_id )->first();
            $otherResModel = Respondents::where( 'list_id', $resObj->list_id )
                ->where( 'meeting_id', $resObj->meeting_id )
                ->where( 'user_id', '!=', $userID )->orderBy( 'res_sort', 'asc' )->get();
            $otherResArr = [];
            foreach ( $otherResModel AS $otherResObj ) {
                $otherResArr[] = [
                    'name' => is_null( $otherResObj->etc_name ) ? $otherResObj->users->name : $otherResObj->etc_name,
                    'res' => $otherResObj->respondents,
                    'ishost' => !is_null( $otherResObj->hostres ),
                    'hostres' => !is_null( $otherResObj->hostres ) ? $otherResObj->hostres->respondents : NULL,
                    'hostobj' => $otherResObj->hostres,
                    'resobj' => $otherResObj,
                ];
            }
            $returnArr[] = [
                'meeting' => [
                    'name' => $meetObj->name,
                    'time' => $meetObj->time,
                    'location' => $meetObj->location,
                    'is_pre' => $meetObj->is_pre,
                ],
                'list' => [
                    'listID' => $prolistObj->id,
                    'listuser' => $prolistObj->user->name,
                    'content' => $prolistObj->content,
                    'description' => $prolistObj->description,
                    'suggest' => $prolistObj->suggest,
                    'index' => is_null( $indexObj->customer_index ) ? $indexObj->meeting_index . '-' . $indexObj->list_index : $indexObj->customer_index,
                ],
                'res' => [
                    'resid' => $resObj->id,
                    'respondents' => $resObj,
                    'ishost' => !is_null( $resObj->hostres ),
                    'hostres' => !is_null( $resObj->hostres ) ? $resObj->hostres : NULL,
                ],
                'otherRes' => $otherResArr,
            ];
        }
        return $returnArr;
    }
}