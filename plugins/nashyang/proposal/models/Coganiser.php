<?php namespace Nashyang\Proposal\Models;

use Model;

/**
 * Model
 */
class Coganiser extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    protected $fillable = [ 'user_id', 'list_id' ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_co_rganiser';

    public $hasOne = [
        'user' => [
            'Nashyang\Proposal\Models\User',
            'key' => 'id',
            'otherKey' => 'user_id',
        ],
    ];
}