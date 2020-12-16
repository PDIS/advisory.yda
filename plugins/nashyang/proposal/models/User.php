<?php namespace Nashyang\Proposal\Models;

use Illuminate\Support\Facades\DB;

/**
 * Model
 */
class User extends \RainLab\User\Models\User {


    public $belongsToMany = [
        'proposallistuser' => [
            'Nashyang\Proposal\Models\Proposal_list',
            'table' => 'nashyang_proposal_co_rganiser',
            'key'      => 'user_id',
            'otherKey' => 'list_id',
        ],
        'proposallistplusone' => [
            'Nashyang\Proposal\Models\Proposal_list',
            'table' => 'nashyang_proposal_countersign',
            'key'      => 'user_id',
            'otherKey' => 'list_id',
        ],
    ];

    public static function getCommitteeMemberEmailList( $sendUserID = NULL ) {
        $queryObj = DB::table( 'user_groups' )
            ->join( 'users_groups', 'user_groups.id', '=', 'users_groups.user_group_id' )
            ->join( 'users', 'users.id', '=', 'users_groups.user_id' )
            ->select( 'users.*' )
            ->where( 'user_groups.code', 'committee-member' )
            ->whereNull( 'deleted_at' );
        if ( !is_null( $sendUserID ) ) {
            $queryObj->where( 'users.id', '<>', $sendUserID );
        }
        return $queryObj;
    }

}