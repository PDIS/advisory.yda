<?php namespace Nashyang\Proposal\Models;

use Model;

/**
 * Model
 */
class Meeting_index extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $primaryKey = 'list_id';

    /*
     * Validation
     */
    public $rules = [
    ];

    protected $fillable = [ 'list_id', 'meeting_index', 'list_index', 'customer_index' ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_index';

    public $hasOne = [
        'proposalList' => [
            'Nashyang\Proposal\Models\Proposal_list',
            'key' => 'id',
            'otherKey' => 'list_id',
        ],
    ];

    static public function getMeetingMaxIndex( $meetingID ) {
        $max = self::where( 'meeting_index', $meetingID )->max( 'list_index' );
        return is_null( $max ) ? 0 : $max;
    }
}