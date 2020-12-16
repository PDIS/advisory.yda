<?php namespace Nashyang\Forum\Models;

use Model;

/**
 * Model
 */
class Tags extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
//    use \October\Rain\Database\Traits\SoftDelete;

//    protected $dates = ['deleted_at'];

    protected $fillable = [ 'id', 'name' ];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|string|min:1|max:100',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'bedard_blogtags_tags';

    public $belongsToMany = [
        'issue' => [
            'NashYang\Forum\Models\Issue',
            'table' => 'nashyang_forum_tag_and_issue',
            'key' => 'tag_id',
            'otherKey' => 'issue_id',
        ],
    ];
}