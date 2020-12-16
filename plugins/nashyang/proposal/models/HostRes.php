<?php namespace Nashyang\Proposal\Models;

use Model;

/**
 * Model
 */
class HostRes extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
    ];

    protected $fillable = [ 'list_id', 'res_id', 'respondents',
        'other_reply',
        'other_reply1',
        'other_reply2',
        'other_reply3',
        'other_reply4',
        'other_reply5',
        'other_reply6',
        'other_reply7',
        'other_reply8',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_hostrespondents';
}