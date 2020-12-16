<?php namespace Nashyang\Forum\Models;

use Carbon\Carbon;
use Model;


/**
 * Model
 */
class Event_list extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|string|min:2|max:100',
        'time' => 'required|date_format:"Y-m-d H:i:s',
        'location' => 'required|string|min:2|max:200',
        'debate_link' => 'active_url|min:5',
        'etc' => 'max:255',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'nashyang_forum_event_list';

    public $hasMany = [
        'issues' => [
            'NashYang\Forum\Models\Issue',
            'key' => 'event_id',
            'otherKey' => 'id',
            'order' => 'questioner_sort asc',
        ],
    ];

    public static function getEventListExcelDataByID( $id ) {
        $eventList = self::find( $id );
        if ( is_null( $eventList ) ) {
            return [];
        }
        $issueList = Issue::getIssueListByEventID( $id )->toArray();
        foreach ( $issueList AS &$lists ) {
            $lists['tags'] = implode(', ', TagIssue::getTagNameListByIssueID( $lists['id'] ) );
            $lists['resList'] = [];
            foreach ( Issue::getRespondentListByID( $lists['id'], FALSE ) AS $resResult ) {
                $lists['resList'][] = [
                    'name' => is_null( $resResult->name ) ? $resResult->etc_name : $resResult->name,
                    'respondent' => $resResult->respondents,
                ];
            }
        }

        $excelData = [
            'name_title' => '座談會名稱',
            'location_title' => '座談會地點',
            'time_title' => '座談會時間',
            'etc_title' => '其他備註',
            'name' => $eventList->name,
            'location' => $eventList->location,
            'time' => $eventList->time,
            'etc' => $eventList->etc,
            'issue_title' => [
                'index' => '序號',
                'questioner_company' => '單位',
                'questioner_jobtitle' => '職稱',
                'questioner_name' => '姓名',
                'questioner' => '需求或問題',
                'responser' => '分案部會',
                'res' => '部會回應',
            ],
            'issueList' => $issueList,
            'excelArr' => []
        ];
        $excelArr = [
            [
                $excelData['issue_title']['index'],
                $excelData['issue_title']['questioner_company'],
                $excelData['issue_title']['questioner_jobtitle'],
                $excelData['issue_title']['questioner_name'],
                $excelData['issue_title']['questioner'],
                $excelData['issue_title']['responser'],
                $excelData['issue_title']['res'],
            ],
        ];
        foreach ( $excelData['issueList'] AS $key => $issue ) {
            $resStr = '';
            $responser = '';
            foreach ( $issue['resList'] AS $resKey => $res ) {
                $responser .= $res['name'] . "\n";
                $resStr .= $res['name'] . ': ' . "\n" . $res['respondent']  . "\n\n";
            }
            $excelArr[] = [
                $key + 1,
                $issue['questioner_company'],
                $issue['questioner_jobtitle'],
                $issue['questioner_name'],
                $issue['questioner'],
                $responser,
                $resStr
            ];
        }
        $excelData['excelArr'] = $excelArr;
        return $excelData;
    }

    public function getForumDateAttribute( $value ) {
        return is_null( $this->attributes['time'] ) ? '' : Carbon::parse( $this->attributes['time'] )->format( 'Y-m-d' );
    }

    public function getForumTimeAttribute( $value ) {
        return is_null( $this->attributes['time'] ) ? '' : Carbon::parse( $this->attributes['time'] )->format( 'H:i' );
    }

}