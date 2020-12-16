<?php namespace Nashyang\Proposal\Models;

use Illuminate\Support\Facades\DB;
use Model;

/**
 * Model
 */
class ForumUser extends Model {
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|string|min:4|max:255',
        'code' => 'required|string|min:4|max:255',
        'description' => 'string',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'user_groups';

    public static function getUserList() {
        return self::getGroupModel()->get();
    }

    public static function getUserByName( $name ) {
        return self::getGroupModel()->where( 'users.name', $name )->first();
    }

    public static function getGroupModel() {
        return DB::table( 'user_groups' )
            ->join( 'users_groups', 'user_groups.id', '=', 'users_groups.user_group_id' )
            ->join( 'users', 'users.id', '=', 'users_groups.user_id' )
            ->select( 'users.*' )
            ->where( 'user_groups.name', '座談會群組' )
            ->whereNull( 'deleted_at' );
    }

    public static function getCommitteeMemberList() {
        $returnArr = [];
        $userList = DB::table( 'user_groups' )
            ->join( 'users_groups', 'user_groups.id', '=', 'users_groups.user_group_id' )
            ->join( 'users', 'users.id', '=', 'users_groups.user_id' )
            ->select( 'users.id', 'users.name', 'user_groups.code' )
            ->where( 'user_groups.code', 'committee-member' )
            ->whereNull( 'deleted_at' )->get();
        foreach ( $userList as $user ) {
            $returnArr[ $user->id ] = $user->name;
        }
        return $returnArr;
    }

    public static function getUserEmailList( $userArr ) {
        return Db::table( 'users' )
            ->whereIn( 'id', $userArr )
            ->whereNull( 'deleted_at' )
            ->select( 'email', 'name', 'id' )
            ->get()->toArray();
    }
}