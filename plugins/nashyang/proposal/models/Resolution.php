<?php namespace Nashyang\Proposal\Models;

use Model;

/**
 * Model
 */
class Resolution extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $fillable = [
        'resolution', 'responsibility', 'meeting_id', 'list_id',
    ];

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_list_meeting_resolution';

    public $hasOne = [
        'meeting' => [
            'Nashyang\Proposal\Models\Meeting',
            'key' => 'id',
            'otherKey' => 'meeting_id',
        ],
    ];
}