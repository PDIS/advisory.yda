<?php

namespace Yda\Export\Controllers;

use Backend\Classes\Controller;
use Vdomah\Excel\Classes\Excel;

class ExportController extends Controller
{
    public static $fields = [
        array(
            'Title',
            'CaseNum',
            'Case',
            'Proposer',
            'Cosigner',
            'Content',
            'Description',
            'Suggestion',
            'Opinion',
            'Resolution',
            // 'Excerpt',
            'Categories',
            'Author Email',
            // 'Created date',
            // 'Updated date',
            'Published date',
            'Event date',
            'Location',
            'Organizer',
            'Contact',
            'Preside',
            'Tags',
            'Attendees',
            'Petitioners',
            'Relative posts',
            'Transcript',
            'Level'),
        array(
            // "本行為範例，請刪除此行，但上方標題必須保留且不得變動",
            "標題",
            "案號",
            "案由",
            "提案人",
            "連署人",
            "青年委員提案內容",
            "提案說明",
            "具體建議",
            "綜合研處意見",
            "決議",
            // "摘要",
            // "大會提案\n(category若要新增不存在的內容，請先至後台手動新增)",
            "大會提案",
            "test@gmail.com",
            // "2018-08-31 11:59:00",
            // "2018-08-31 11:59:00",
            "2018-08-31 11:59:00",
            "2018-08-31 11:59:00",
            "地點",
            "主辦單位",
            "聯絡方式",
            "主持人",
            "消防,防災",
            "黃敬峰,李欣",
            "林文攀,許瑞福",
            "2-3：大型國土防災－消防資訊化橫向整合系統",
            "2016-11-23-青年諮詢委員會第1次會議",
            // "1\n(提案進度：1提案中,2進行中,3部分參採,4完全參採,5暫不參採)"),
            "1"),
    ];

    public function __construct()
    {
    }

    public function index()
    {
        $data = $this::$fields;
        Excel::excel()->create('sample', function ($excel) use ($data) {
            $excel->sheet('文章匯入範例', function ($sheet) use ($data) {
                $sheet->fromArray($data, null, null, false, false)->freezeFirstRow();
            });
        })->download('xlsx');
    }
}
