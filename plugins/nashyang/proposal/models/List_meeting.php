<?php namespace Nashyang\Proposal\Models;

use Model;

/**
 * Model
 */
class List_meeting extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $fillable = [ 'meeting_id', 'list_id', 'status' ];

    /*
     * Validation
     */
    public $rules = [];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_list_meeting';

    public $hasMany = [
        'proposallist' => [ 'Nashyang\Proposal\Models\Proposal_list', 'key' => 'id', 'otherKey' => 'list_id', 'order' => 'nashyang_proposal_list.sort desc' ],
    ];

    public function getStatusTxtAttribute( $value ) {
        return Proposal_list::$statusArr[ $this->attributes['status'] ];
    }
}