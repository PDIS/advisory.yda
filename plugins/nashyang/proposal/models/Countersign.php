<?php namespace Nashyang\Proposal\Models;

use Model;
use October\Rain\Exception\AjaxException;
use October\Rain\Exception\ValidationException;
use October\Rain\Support\Facades\Flash;

/**
 * Model
 */
class Countersign extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'list_id' => 'required|integer',
        'user_id' => 'required|integer',
    ];

    protected $fillable = [ 'list_id', 'user_id', 'why', ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_countersign';

    public $belongsTo = [
        'proposalList' => [ 'Nashyang\proposal\Models\Proposal_list', 'key' => 'list_id', 'otherKey' => 'id' ],
        'user' => [ 'RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'id' ],
    ];

    static public function userRespondent() {
        $whereArr = [
            'list_id' => (int)post( 'list_id' ),
            'user_id' => (int)post( 'user_id' ),
        ];
        if ( Proposal_list::find( $whereArr['list_id'] )->user_id == $whereArr['user_id'] ) {
            throw new ValidationException( [ 'error' => '您為本提案的提案者。' ] );
        } else {
            $model = Countersign::where( 'list_id', $whereArr['list_id'] )->where( 'user_id', $whereArr['user_id'] );
            if ( $model->count() > 0 ) {
                $model->delete();
            } else {
                Countersign::create( [
                    'why' => post( 'why' ) === '' ? NULL : post( 'why' ),
                    'user_id' => $whereArr['user_id'],
                    'list_id' => $whereArr['list_id'],
                ] );
            }
            Flash::success( '操作成功。' );
        }
    }

    static public function getUserNameListStringByProposalID( $pid ) {
        $string = '';
        $arr = [];
        foreach ( Countersign::where( 'list_id', $pid )->get() AS $k => $row ) {
            if ( $k > 0 ) {
                $string .= ', ';
            }
            $string .= $row->user->name;
            $arr[] = [
                'id' => $row->user_id,
                'name' => $row->user->name,
            ];
        }
        return [ 'string' => $string, 'list' => $arr, ];
    }

    static public function getIArgeeList( $userID ) {
        return Countersign::where( 'user_id', $userID )->get();
    }

}