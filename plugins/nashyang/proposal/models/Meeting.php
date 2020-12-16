<?php namespace Nashyang\Proposal\Models;

use Model;
use Carbon\Carbon;
use Nashyang\Proposal\Models\Proposal_list as Proposal_list;

/**
 * Model
 */
class Meeting extends Model {
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = [ 'deleted_at' ];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|string|min:2|max:100',
        'location' => 'required|string|min:2|max:200',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_meeting';

    public $hasMany = [
        'proposallist' => [ 'Nashyang\Proposal\Models\Proposal_list', 'key' => 'meeting_id', 'otherKey' => 'id' ],
        'listmeetint' => [ 'Nashyang\Proposal\Models\List_meeting', 'key' => 'meeting_id', 'otherKey' => 'id' ],
    ];

    public function afterSave() {
        parent::afterSave();
//        Proposal_list::whereNull( 'meeting_id' )->where( 'status', 1 )
//            ->whereRaw( 'IFNULL( expiration_at, DATE_ADD( created_at, INTERVAL 14 DAY ) ) >= ' . "'$this->time'" )
//            ->update( [ 'meeting_id' => , 'expiration_at' => $this->time, ] );
    }

    public function importProposal_list( $id ) {
        // 新提案陣列
        $newProList = Proposal_list::whereNull( 'meeting_id' )->where( 'status', 0 )->get();
        foreach ( $newProList AS $k => $list ) {
            if ( $list->countersign->count() >= 2 ) {
                $proID = $list->id;
                $list->status = 3;
                $list->meeting_id = $id;
                $list->save();
                List_meeting::updateOrCreate( [ 'meeting_id' => $id, 'list_id' => $proID, ], [ 'status' => 3, ] );
                $listIndex = Meeting_index::getMeetingMaxIndex( $id ) + 1;
                Meeting_index::create( [ 'list_id' => $proID, 'meeting_index' => $id, 'list_index' => $listIndex, ] );
            }
        }
        // 上次的會議ID
        $lastMeetObj = Meeting::select( 'id' )->where( 'id', '<', $id )->orderBy( 'id', 'desc' )->first();
        if (is_null($lastMeetObj)) {
            return false;
        }
        $lastMid = $lastMeetObj->id;
        // $lastMid = 10
        // 上次未完成的提案
        $tubeList = Proposal_list::whereNotNull( 'meeting_id' )->where( 'status', 5 )->get();
        foreach ( $tubeList AS $k => $list ) {
            $proID = $list->id;
            $list->meeting_id = $id;
            $list->save();
            List_meeting::updateOrCreate( [ 'meeting_id' => $id, 'list_id' => $proID, ], [ 'status' => 5, ] );
            $thisResModel = Respondents::where( 'meeting_id', $id )->where( 'list_id', $list->id );
            if ( $thisResModel->count() > 0 ) {
                $thisResModel->delete();
            }
            foreach( Respondents::where( 'meeting_id', $lastMid )->where( 'list_id', $list->id )->get() AS $lastList ) {
                $newR = Respondents::create( [
                    'meeting_id' => $id,
                    'list_id' => $list->id,
                    'user_id' => $lastList->user_id,
                    'etc_name' => $lastList->etc_name,
                ] );
                if ( HostRes::where( 'list_id', $list->id )->where( 'res_id', $lastList->id )->count() ) {
                    HostRes::create( [
                        'list_id' => $list->id,
                        'res_id' => $newR->id,
                    ] );
                }
            }
        }
    }

    public function getForumDateAttribute( $value ) {
        return $this->attributes['time'] === '0000-00-00 00:00:00' ? '' : Carbon::parse( $this->attributes['time'] )->format( 'Y-m-d' );
    }

    public function getForumTimeAttribute( $value ) {
        return $this->attributes['time'] === '0000-00-00 00:00:00' ? '' : Carbon::parse( $this->attributes['time'] )->format( 'H:i' );
    }

}