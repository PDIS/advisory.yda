<?php namespace Nashyang\Proposal\Models;

use Model;

/**
 * Model
 */
class List_department extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
    ];

    public $belongsTo = [
        'user' => [ 'RainLab\User\Models\User', 'key' => 'user_id', 'otherKey' => 'id' ],
    ];

    protected $fillable = [ 'list_id', 'user_id', 'etc_name', 'isco' ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_proposal_list_department';

//    public $hasOne = [
//        'users' => [
//            'RainLab\User\Models\User',
//            'key' => 'id',
//            'otherKey' => 'user_id',
//        ],
//    ];
}