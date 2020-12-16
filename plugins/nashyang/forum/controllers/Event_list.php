<?php namespace Nashyang\Forum\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\Backend;
use BackendMenu;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Nashyang\Forum\Models\ForumUser;
use Nashyang\Forum\Models\GoogleSheetApi;
use Nashyang\Forum\Models\Respondent;
use Nashyang\Forum\Models\TagIssue;
use October\Rain\Exception\ValidationException;
use October\Rain\Support\Facades\Flash;
use Illuminate\Support\Facades\DB;
use Vdomah\Excel\Classes\Excel;

class Event_list extends Controller {
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    protected $issueFormWidget;
    protected $issueUpdateFormWidget;
    protected $issueListWidget;
    protected $eventListID;

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext( 'Nashyang.Forum', 'main-menu-nav_top', 'side-menu-event_list' );
        $this->eventListID = isset( $this->params[0] ) ? $this->params[0] : 0;
        $this->issueFormWidget = $this->createIssueFormWidget();
        if ( $this->action === 'update' ) {
            if ( \Illuminate\Support\Facades\Request::ajax() && post( 'issue_id' ) ) {
                $this->issueUpdateFormWidget = $this->updateIssueFormWidget( post( 'issue_id' ) );
            }
            $this->vars['issueList'] = $this->getIssueList();
        }
    }

    public function onLoadCreateIssueForm() {
        $this->vars['issueFormWidget'] = $this->issueFormWidget;
        $this->vars['eventListID'] = $this->eventListID;
        return $this->makePartial( 'issue_create_form' );
    }

    public function onLoadCreateIssueOtherForm() {
        $this->issueFormWidget = $this->createIssueFormWidget( TRUE );
        $this->vars['issueFormWidget'] = $this->issueFormWidget;
        $this->vars['eventListID'] = $this->eventListID;
        return $this->makePartial( 'issue_create_form' );
    }

    public function onLoadSheetImport() {
        return $this->makePartial( 'issue_import_sheet_form' );
    }

    protected function getIssueList() {
        return $this->getIssueModel()->where( 'event_id', $this->eventListID )->orderBy( 'questioner_sort', 'asc' )->get();
    }

    protected function createIssueFormWidget( $isOther = FALSE ) {
        $config = $this->makeConfig( '$/nashyang/forum/models/issue/issue_form.yaml' );
        $config->alias = 'issueForm';
        $config->arrayName = 'issue';
        if ( $isOther ) {
            unset( $config->fields['status']['placeholder'] );
            $config->fields['status']['options'] = [ 5 => '已回覆' ];
        } else {
            unset( $config->fields['reply_json'] );
        }
        $config->model = new \Nashyang\Forum\Models\Issue;
        $widget = $this->makeWidget( 'Backend\Widgets\Form', $config );
        $widget->bindToController();
        return $widget;
    }

    protected function onCreateIssue() {
        $data = $this->issueFormWidget->getSaveData();
        $mails = explode( ',', $data['questioner_email'] );
        $isTrue = TRUE;
        foreach ( $mails AS $mail ) {
            $isTrue = $isTrue && preg_match( '/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/', $mail );
        }
        if ( $isTrue === FALSE ) {
            throw new ValidationException( [ 'questioner_email' => '信箱格式錯誤!' ] );
        }
        DB::transaction( function() {
            $isReplyArr = post( 'reply_json' );
            $data = $this->issueFormWidget->getSaveData();
            if ( empty( $data['user_id'] ) && empty( $data['etc_name'] ) ) {
                throw new ValidationException( [ 'respondent' => '指定回答者必需填入' ] );
            }
            $model = new \Nashyang\Forum\Models\Issue;
            $data['event_id'] = post( 'id' );
            $data['is_tube'] = $data['status'] === '5' ? 1 : 0;
            $data['questioner_sort'] = $data['questioner_sort'] == '' ? null : $data['questioner_sort'];
            $model->fill( $data )->save();
            $newIssueID = $model->getKey();
            if ( !is_null( $data['user_id'] ) ) {
                foreach ( $data['user_id'] AS $userID ) {
                    $respondentModel = new Respondent;
                    $respondentModel->issue_id = $newIssueID;
                    $respondentModel->user_id = $userID;
                    $respondentModel->is_reply = isset( $isReplyArr[ $userID ] ) ? 1 : 0;
                    $respondentModel->save();
                }
            }
            $etcNames = explode( ',', $data['etc_name'] );
            foreach ( $etcNames AS $etcName ) {
                if ( !empty( $etcName ) ) {
                    Respondent::create( [ 'issue_id' => $newIssueID, 'etc_name' => $etcName ] );
                }
            }
            if ( !is_null( $data['tag'] ) ) {
                foreach ( $data['tag'] AS $tag ) {
                    $tagID = \Nashyang\Forum\Models\Tags::firstOrCreate( [ 'name' => $tag ] )->id;
                    $tagIssueModel = new \Nashyang\Forum\Models\TagIssue;
                    $tagIssueModel->tag_id = $tagID;
                    $tagIssueModel->issue_id = $newIssueID;
                    $tagIssueModel->save();
                }
            }
        } );
        $this->onSuccess( '新增提問問題成功。' );
        return $this->refreshIssueList();
    }

    protected function onUpdateIssue() {
        $data = $this->issueUpdateFormWidget->getSaveData();
        $issueID = post( 'issue_id' );
        $mails = explode( ',', $data['questioner_email'] );
        $isTrue = TRUE;
        foreach ( $mails AS $mail ) {
            $isTrue = $isTrue && preg_match( '/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/', $mail );
        }
        if ( $isTrue === FALSE ) {
            throw new ValidationException( [ 'questioner_email' => '信箱格式錯誤!' ] );
        }
        if ( empty( $data['user_id'] ) && empty( $data['etc_name'] ) ) {
            throw new ValidationException( [ 'user_id' => '指定回答者必需填入' ] );
        }
        DB::transaction( function() use ( $data, $issueID ) {
            $issueModel = \Nashyang\Forum\Models\Issue::find( $issueID );
            $updateArr = [
                'questioner_name' => $data['questioner_name'],
                'questioner_email' => $data['questioner_email'],
                'questioner' => $data['questioner'],
                'questioner_sort' => $data['questioner_sort'] == '' ? null : $data['questioner_sort'],
                'questioner_jobtitle' => $data['questioner_jobtitle'],
                'questioner_company' => $data['questioner_company'],
                'status' => $data['status'],
            ];
            $issueModel->update( $updateArr );
            $data['etc_name'] = explode( ',', $data['etc_name'] );
            Respondent::where( 'issue_id', $issueID )
                ->where( function( $query ) use ( $data ) {
                    if ( !is_null( $data['user_id'] ) ) {
                        $query->whereNotIn( 'user_id', $data['user_id'] );
                    }
                    $query->whereNull( 'etc_name' )
                        ->orWhere( function( $orQrury ) use ( $data ) {
                            $orQrury->whereNull( 'user_id' );
                            if ( !is_null( $data['etc_name'] ) ) {
                                $orQrury->whereNotIn( 'etc_name', $data['etc_name'] );
                            }
                        } );
                } )->delete();

            if ( !is_null( $data['etc_name'] ) ) {
                foreach ( $data['etc_name'] AS $etcName ) {
                    if ( !empty( $etcName ) ) {
                        Respondent::updateOrCreate( [ 'issue_id' => $issueID, 'etc_name' => $etcName ] );
                    }
                }
            }
            if ( !is_null( $data['user_id'] ) ) {
                foreach ( $data['user_id'] AS $userID ) {
                    if ( !empty( $userID ) ) {
                        $isReplyArr = post( 'reply_json' );
                        Respondent::updateOrCreate( [
                            'issue_id' => $issueID,
                            'user_id' => $userID,
                        ], [
                            'is_reply' => isset( $isReplyArr[ $userID ] ) ? 1 : 0,
                        ] );
                    }
                }
            }
            \Nashyang\Forum\Models\TagIssue::where( 'issue_id', $issueID )->delete();
            if ( !is_null( $data['tag'] ) ) {
                foreach ( $data['tag'] AS $tag ) {
                    $tagID = \Nashyang\Forum\Models\Tags::firstOrCreate( [ 'name' => $tag ] )->id;
                    $tagIssueModel = new \Nashyang\Forum\Models\TagIssue;
                    $tagIssueModel->tag_id = $tagID;
                    $tagIssueModel->issue_id = $issueID;
                    $tagIssueModel->save();
                }
            }
        } );
        $this->onSuccess( '提問問題已更新完成。' );
        return $this->refreshIssueList();
    }

    public function onLoadUpdateIssueForm() {
        $this->vars['issueUpdateFormWidget'] = $this->issueUpdateFormWidget;
        $this->vars['eventListID'] = $this->eventListID;
        $this->vars['issueData'] = \Nashyang\Forum\Models\Issue::where( 'id', post( 'issue_id' ) )->first()->toArray();
        $this->vars['issueID'] = post( 'issue_id' );
        return $this->makePartial( 'issue_update_form' );
    }

    public function onLoadUpdateIssueOtherForm() {
        $this->issueUpdateFormWidget = $this->updateIssueFormWidget( post( 'issue_id' ), TRUE );
        $this->vars['issueUpdateFormWidget'] = $this->issueUpdateFormWidget;
        $this->vars['eventListID'] = $this->eventListID;
        $this->vars['issueData'] = \Nashyang\Forum\Models\Issue::where( 'id', post( 'issue_id' ) )->first()->toArray();
        $this->vars['issueID'] = post( 'issue_id' );
        return $this->makePartial( 'issue_update_form' );
    }

    public function onLoadRespondentsForm() {
        $this->vars['eventListID'] = $this->eventListID;
        $this->vars['issueData'] = \Nashyang\Forum\Models\Issue::where( 'id', post( 'issueid' ) )
            ->select( 'questioner', 'questioner_name' )
            ->first()->toArray();
        $this->vars['respondentList'] = Respondent::getRespondentAndUserDataByIssueID( post( 'issueid' ) );
        $this->vars['eventList'] = \Nashyang\Forum\Models\Event_list::find( $this->eventListID )->toArray();
        $this->vars['issueID'] = post( 'issueid' );
        return $this->makePartial( 'respondent_update_form' );
    }

    public function onUpdateRespondent() {
        $printsArr = post( 'prints' );
        foreach ( post( 'content' ) AS $id => $content ) {
            $prints = isset( $printsArr[ $id ] ) ? $printsArr[ $id ] : NULL;
            $prints = empty( $prints ) ? NULL : $prints;
            $result = Respondent::find( $id );
            $isTube = $result->issue->status === 5 ? FALSE : TRUE;
            $result->update( [
                'respondents' => empty( $content ) ? NULL : $content,
                'prints' => $prints,
            ] );
        }
        $this->onSuccess();
        if ( $isTube ) {
            $this->onReplyTubeSendMail( $result->issue->id );
        }
        return $this->refreshIssueList();
    }

    protected function updateIssueFormWidget( $issueID, $isOther = FALSE ) {
        $config = $this->makeConfig( '$/nashyang/forum/models/issue/issue_updateform.yaml' );
        $config->alias = 'issueUpdateForm';
        $config->arrayName = 'issueUpdate';
        $config->model = new \Nashyang\Forum\Models\Issue;
        $issueData = $config->model->find( $issueID );
        $config->fields['questioner_name']['default'] = $issueData->questioner_name;
        $config->fields['questioner_sort']['default'] = $issueData->questioner_sort;
        $config->fields['questioner']['default'] = $issueData->questioner;
        $config->fields['questioner_email']['default'] = $issueData->questioner_email;
        $config->fields['questioner_company']['default'] = $issueData->questioner_company;
        $config->fields['questioner_jobtitle']['default'] = $issueData->questioner_jobtitle;
        $config->fields['status']['default'] = $issueData->status;
        $config->fields['tag']['default'] = TagIssue::getTagNameListByIssueID( $issueID );
        $defaultArr = [
            'userID' => [],
            'etcName' => [],
            'reslist' => [],
        ];
        foreach ( Respondent::where( 'issue_id', $issueID )->select( 'user_id', 'etc_name', 'is_reply' )->get() AS $queryResult ) {
            if ( $queryResult->user_id )
                $defaultArr['userID'][] = $queryResult->user_id;
            if ( $queryResult->etc_name )
                $defaultArr['etcName'][] = $queryResult->etc_name;
            $defaultArr['reslist'][] = [
                'user' => $queryResult->user_id,
                'username' => $queryResult->user_id ? $queryResult->users->name : $queryResult->etc_name,
                'isReply' => $queryResult->is_reply,
            ];
        }
        $config->fields['user_id']['default'] = $defaultArr['userID'];
        $config->fields['etc_name']['default'] = implode( ',', $defaultArr['etcName'] );
        $this->vars['resList'] = $defaultArr['reslist'];
        if ( $isOther ) {
            unset( $config->fields['status']['placeholder'] );
            $config->fields['status']['options'] = [ 5 => '已回覆' ];
        } else {
            unset( $config->fields['reply_json'] );
        }
        $widget = $this->makeWidget( 'Backend\Widgets\Form', $config );
        $widget->bindToController();
        return $widget;
    }

    protected function onDeleteIssue() {
        \Nashyang\Forum\Models\Issue::destroy( post( 'issueid' ) );
        $this->onSuccess( '該提問問題已被刪除。' );
        return $this->refreshIssueList();
    }

    protected function onDeleteAllIssue() {
        \Nashyang\Forum\Models\Issue::where( 'event_id', $this->eventListID )->where( 'status', 5 )->delete();
        $this->onSuccess( '所有問題已被刪除。' );
        return $this->refreshIssueList();
    }

    protected function refreshIssueList() {
        $this->vars['issueList'] = $this->getIssueList();
        return [
            '#issueList' => $this->makePartial( 'issue_list' ),
            '#tubeList' => $this->makePartial( 'tube_list' ),
        ];
    }

    protected function getIssueModel() {
        $eventID = $this->eventListID;
        $issue = $eventID
            ? \Nashyang\Forum\Models\Issue::where( 'event_id', $eventID )
            : new \Nashyang\Forum\Models\Issue;
        return $issue;
    }

    protected function onSuccess( $message = NULL ) {
        Flash::success( is_null( $message ) ? '操作成功。' : $message );
    }

    public function onReplyTubeSendMail( $issueID ) {
        $issue = \Nashyang\Forum\Models\Issue::find( $issueID );
        $event = $issue->eventList;
        $resList = Respondent::where( 'issue_id', $issueID )->get()->toArray();
        $respondentsUserIDList = [];
        foreach ( $resList AS $res ) {
            if ( $res['user_id'] > 0 ) {
                $respondentsUserIDList[] = $res['user_id'];
            }
        }
        foreach ( ForumUser::getUserEmailList( array_unique( $respondentsUserIDList ) ) AS $user ) {
            $mails[ $user->email ] = $user->name;
        }
        $mails[ $issue->questioner_email ] = $issue->questioner_name;
        $vars = [
            'eventName' => $event->name,
            'eventTime' => $event->time,
            'location' => $event->location,
            'link' => url( 'forumredirect/forum' ),
            'notificationCount' => '',
            'mailtemplates' => 'nashyang.forum::mail.NotificationDepartmentTubeReply',
        ];
        Mail::send( $vars['mailtemplates'], $vars, function( $message ) use ( $mails ) {
            $message->from( 'yda_noreply@mail.yda.gov.tw', '行政院青年諮詢委員會(系統郵件)' )
                ->bcc( $mails, $name = NULL );
        } );
    }

    public function onSendMailFormTubeOne() {
        $issueID = post( 'issue_id' );
        $eventArr = post( 'Event_list' );
        $issueObj = \Nashyang\Forum\Models\Issue::where( [ 'id' => $issueID, ] )->first();
        if ( is_null( $issueObj ) ) {
            $this->onSuccess( '沒有問題需要通知部會。' );
            return $this->listRefresh();
        }
        $issueObj->is_sendmail = 1;
        $issueObj->save();
        $respondentsUserIDList = [];
        $resList = Respondent::where( 'issue_id', $issueID )->get()->toArray();
        foreach ( $resList AS $res ) {
            if ( $res['user_id'] > 0 ) {
                $respondentsUserIDList[] = $res['user_id'];
            }
        }
        foreach ( ForumUser::getUserEmailList( array_unique( $respondentsUserIDList ) ) AS $user ) {
            $mails[ $user->email ] = $user->name;
        }
        $vars = [
            'eventName' => $eventArr['name'],
            'eventTime' => $eventArr['time'],
            'location' => $eventArr['location'],
            'link' => url( 'forumredirect/forum' ),
            'notificationCount' => '',
            'mailtemplates' => 'nashyang.forum::mail.NotificationDepartmentTube',
        ];
        Mail::send( $vars['mailtemplates'], $vars, function( $message ) use ( $mails ) {
            $message->from( 'yda_noreply@mail.yda.gov.tw', '行政院青年諮詢委員會(系統郵件)' )
                ->bcc( $mails, $name = NULL );
        } );
        $this->onSuccess( '信件已寄出。' );
        return $this->refreshIssueList();
    }

    protected function onSendMailFormIssueOne() {
        $issueID = post( 'issue_id' );
        $eventArr = post( 'Event_list' );
        $issueObj = \Nashyang\Forum\Models\Issue::where( [ 'id' => $issueID, 'status' => 5 ] )->first();
        if ( is_null( $issueObj ) ) {
            $this->onSuccess( '沒有問題需要通知部會。' );
            return $this->listRefresh();
        }
        $issueObj->is_sendmail = 1;
        $respondentsUserIDList = [];
        $resList = Respondent::where( 'issue_id', $issueID )->get()->toArray();
        foreach ( $resList AS $res ) {
            if ( $res['user_id'] > 0 ) {
                $respondentsUserIDList[] = $res['user_id'];
            }
        }
        $mails = [];
        foreach ( ForumUser::getUserEmailList( array_unique( $respondentsUserIDList ) ) AS $user ) {
            $mails[ $user->email ] = $user->name;
        }
        $vars = [
            'eventName' => $eventArr['name'],
            'eventTime' => $eventArr['time'],
            'location' => $eventArr['location'],
            'link' => url( 'forumredirect/forum' ),
            'notificationCount' => '',
            'mailtemplates' => 'nashyang.forum::mail.NotificationDepartmentReply1',
        ];
        if ( empty( $mails ) ) {
            throw new ValidationException( [ 'errmsg' => '您尚未選擇分案部會。' ] );
        }
        Mail::send( $vars['mailtemplates'], $vars, function( $message ) use ( $mails ) {
            $message->from( 'yda_noreply@mail.yda.gov.tw', '行政院青年諮詢委員會(系統郵件)' )
                ->bcc( $mails, $name = NULL );
        } );
        $issueObj->save();
        $this->onSuccess( '信件已寄出。' );
        return $this->refreshIssueList();
    }

    protected function sendNotificationMail() {
        $eventID = post( 'id' );
        $eventObj = \Nashyang\Forum\Models\Event_list::find( $eventID );
        $vars = [
            'eventName' => $eventObj->name,
            'eventTime' => $eventObj->time,
            'location' => $eventObj->location,
            'link' => url( 'forumredirect/forum' ),
            'notificationCount' => '',
            'mailtemplates' => 'nashyang.forum::mail.NotificationDepartmentReply1',
        ];
        $issueObj = \Nashyang\Forum\Models\Issue::where( [ 'event_id' => $eventID, 'is_sendmail' => 0, 'status' => 5 ] )->get();
        if ( $issueObj->count() === 0 ) {
            $this->onSuccess( '沒有問題需要通知部會。' );
            return $this->listRefresh();
        }
        $respondentsUserIDList = [];
        foreach ( $issueObj AS $issueList ) {
            $issueList->is_sendmail = 1;
            $issueList->save();
            $list = $issueList->toArray();
            $resList = Respondent::where( 'issue_id', $list['id'] )->get()->toArray();
            foreach ( $resList AS $res ) {
                if ( $res['user_id'] > 0 ) {
                    $respondentsUserIDList[] = $res['user_id'];
                }
            }
        }
        foreach ( ForumUser::getUserEmailList( array_unique( $respondentsUserIDList ) ) AS $user ) {
            $mails[ $user->email ] = $user->name;
        }
        Mail::send( $vars['mailtemplates'], $vars, function( $message ) use ( $mails ) {
            $message->from( 'yda_noreply@mail.yda.gov.tw', '行政院青年諮詢委員會(系統郵件)' )
                ->bcc( $mails, $name = NULL );
        } );
    }

    public function onRefreshEventSend() {
        $model = \Nashyang\Forum\Models\Event_list::find( $this->eventListID );
        $model->is_send1 = 0;
        $model->is_send2 = 0;
        $model->save();
        $this->onSuccess( '已重置通知。' );
        return $this->listRefresh();
    }

    public function onSendNotificationDepartmentReply() {
        $this->sendNotificationMail();
        $model = \Nashyang\Forum\Models\Event_list::find( post( 'id' ) );
        $model->is_send1 = 1;
        $model->save();
        $this->onSuccess( '通知信件已寄出。' );
        return $this->listRefresh();
    }

//    public function onSendNotificationDepartmentReplyTwo() {
//        $this->sendNotificationMail( FALSE );
//        $model = \Nashyang\Forum\Models\Event_list::find( post( 'id' ) );
//        $model->is_send2 = 1;
//        $model->save();
//        $this->onSuccess( '通知信件已寄出。' );
//        return $this->listRefresh();
//    }

    public function onSendShowAndClose() {
        $eventID = post( 'id' );
        $model = \Nashyang\Forum\Models\Event_list::find( $eventID );
        $is_show = $model->is_show;
        $model->is_show = !$is_show;
        if ( $model->is_show ) {
            $vars = [
                'eventName' => $model->name,
                'eventTime' => $model->time,
                'location' => $model->location,
                'link' => url( 'forum' ),
            ];
            $mails = [];
            foreach ( \Nashyang\Forum\Models\Issue::getQuestionerEmailByEventID( $eventID ) AS $user ) {
                $emailArr = explode( ',', $user->email );
                $nameArr = explode( ',', $user->name );
                foreach ( $emailArr AS $key => $mail ) {
                    $mails[ $mail ] = $nameArr[ $key ];
                }
            }
            foreach ( \Nashyang\Forum\Models\Issue::getRespondentsUserEmailByEventID( $eventID ) AS $user ) {
                $mails[ $user->email ] = $user->name;
            }
            Mail::send( 'nashyang.forum::mail.showForumNotification', $vars, function( $message ) use ( $mails ) {
                $message->from( 'yda_noreply@mail.yda.gov.tw', '行政院青年諮詢委員會(系統郵件)' )
                    ->bcc( $mails, $name = NULL );
            } );
        }
        $model->save();
        $this->onSuccess();
        return $this->listRefresh();
    }

    public function onSubmitSheetLink() {
        $link = post( 'sheetLink' );
        $validator = Validator::make(
            [ 'sheetLink' => $link, ], [ 'sheetLink' => 'required|active_url', ]
        );
        if ( $validator->fails() ) {
            throw new ValidationException( [ 'sheetLink' => '傳入的網址不是有效的連結。' ] );
        }
        $googleClient = new GoogleSheetApi();
        if ( !$googleClient->checkSheetID( $link ) ) {
            throw new ValidationException( [ 'sheetLink' => '無效的 Google Sheets 連結。' ] );
        }
        $googleClient->setSheetID( $googleClient->getSheetIdFormUrl( $link ) );
        $googleClient->getSheets();
        $googleClient->saveSheetDataToDB( $this->eventListID );
        $this->onSuccess( '提問問題匯入成功。' );
        return $this->refreshIssueList();
    }

    public function exportexcel() {
        if ( isset( $this->params[0] ) ) {
            $this->eventListID = $this->params[0];
        } else {
            return redirect( Backend::url( 'nashyang/forum/event_list' ) );
        }
        $excelDataList = \Nashyang\Forum\Models\Event_list::getEventListExcelDataByID( $this->eventListID );
        $excelData = $excelDataList['excelArr'];

        Excel::excel()->create( $excelDataList['name'], function( $excel ) use ( $excelData, $excelDataList ) {
            $excel->sheet( $excelDataList['name'], function( $sheet ) use ( $excelData ) {
                $sheet->cells( '1', function( $row ) {
                    $row->setBackground( '#F4A460' );
                } );
                $sheet->fromArray( $excelData, NULL, NULL, FALSE, FALSE )
                    ->setWidth( [
                        'B' => 30,
                        'C' => 30,
                        'D' => 20,
                        'E' => 50,
                        'F' => 30,
                        'G' => 50,
                    ] );
            } );
        } )->download( 'xlsx' );
    }

    public function onLoadSetResSortForm() {
        $config = $this->makeConfig( '$/nashyang/forum/models/event_list/setressort.yaml' );
        $config->alias = 'setressort';
        $config->arrayName = 'setressort';
        $config->model = new Respondent();
        $this->vars['formWidget'] = $this->makeWidget( 'Backend\Widgets\Form', $config );
        $this->vars['issue_id'] = post( 'issue_id' );
        return $this->makePartial( 'setressort' );
    }

    public function onSaveSetSort() {
        $ressortList = post( 'ressort' );
        foreach ( $ressortList AS $sortIndex => $resid ) {
            Respondent::find( $resid )->update( [ 'res_sort' => $sortIndex ] );
        }

        $this->onSuccess();
        return $this->refreshIssueList();
    }
}