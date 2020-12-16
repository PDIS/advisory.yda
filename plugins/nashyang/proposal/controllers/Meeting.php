<?php namespace Nashyang\Proposal\Controllers;

use Backend\Classes\Controller;
use Nashyang\Proposal\Models\HostRes;
use Nashyang\Proposal\Models\List_meeting;
use Nashyang\Proposal\Models\Meeting_index AS Meeting_index;
use Nashyang\Proposal\Models\Proposal_list AS Proposal_list;
use BackendMenu;
use Nashyang\Proposal\Models\ProposalSendEmail;
use Nashyang\Proposal\Models\Resolution;
use Nashyang\Proposal\Models\Respondents;
use October\Rain\Support\Facades\Flash;
use RainLab\User\Models\User;


class Meeting extends Controller {
    public $implement = [ 'Backend\Behaviors\ListController', 'Backend\Behaviors\FormController' ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    protected $meetingID;

    public function listExtendQuery( $query ) {
        return $query->where( 'is_pre', 0 );
    }

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext( 'Nashyang.Proposal', 'main-menu-nav_top', 'side-menu-meeting' );
        $this->meetingID = isset( $this->params[0] ) ? $this->params[0] : 0;
    }

    public function onSendShowAndClose() {
        $model = \Nashyang\Proposal\Models\Meeting::find( post( 'id' ) );
        $is_show = $model->is_show;
        $model->is_show = !$is_show;
        $model->save();
        $this->onSuccess();
        return $this->listRefresh();
    }

    public function onLoadProposalForm() {
        if ( $this->getId() == 'Meeting-update' ) {
            $config = $this->makeConfig( '$/nashyang/proposal/models/proposal_list/meeting_edit_fields.yaml' );
        } else {
            $config = $this->makeConfig( '$/nashyang/proposal/models/proposal_list/premeeting_edit_fields.yaml' );
        }
        $config->alias = 'proposalForm';
        $config->arrayName = 'proposalForm';
        $config->model = Proposal_list::find( post( 'listid' ) );
        $this->vars['formWidget'] = $this->makeWidget( 'Backend\Widgets\Form', $config );
        $this->vars['meeting_id'] = $this->meetingID;
        $this->vars['list_id'] = post( 'listid' );
        return $this->makePartial( 'proposal_edit_form' );
    }

    public function onLoadSetDepartmentForm() {
        $config = $this->makeConfig( '$/nashyang/proposal/models/proposal_list/meeting_sethost.yaml' );
        $config->alias = 'sethostform';
        $config->arrayName = 'sethostform';
        $config->model = Proposal_list::find( post( 'listid' ) );
        $this->vars['formWidget'] = $this->makeWidget( 'Backend\Widgets\Form', $config );
        $this->vars['meeting_id'] = $this->meetingID;
        $this->vars['list_id'] = post( 'listid' );
        return $this->makePartial( 'sethostform' );
    }

    public function onLoadResolutionForm() {
        $config = $this->makeConfig( '$/nashyang/proposal/models/proposal_list/responsibility_update_fields.yaml' );
        $postData = post();
        $postData['meetingid'];
        $postData['listid'];
        $resModel = Resolution::firstOrCreate( [
            'meeting_id' => $postData['meetingid'],
            'list_id' => $postData['listid'],
        ] );
        $this->vars['meeting_id'] = $resModel->meeting_id;
        $this->vars['list_id'] = $resModel->list_id;
        $this->vars['res_id'] = $resModel->id;
        $this->vars['resolution'] = $resModel->resolution;
        $this->vars['responsibility'] = $resModel->responsibility;
        $config->alias = 'responsibilityForm';
        $config->arrayName = 'responsibilityForm';
        $config->model = $resModel;
        $this->vars['formWidget'] = $this->makeWidget( 'Backend\Widgets\Form', $config );
        return $this->makePartial( 'responsibility_update_form' );
    }

    public function onLoadRespondentsForm() {
        $postData = post();
        $this->vars['meeting_id'] = $this->meetingID;
        $this->vars['list_id'] = post( 'listid' );
        $this->vars['meetingData'] = $postData['Meeting'];
        $proListModel = Proposal_list::find( post( 'listid' ) );
        $this->vars['content'] = $proListModel->content;
        $this->vars['description'] = $proListModel->description;
        $this->vars['suggest'] = $proListModel->suggest;
        $this->vars['resData'] = [];
        foreach ( Respondents::where( 'meeting_id', $this->meetingID )->where( 'list_id', $this->vars['list_id'] )->get() AS $res ) {
            $this->vars['resData'][] = [
                'name' => is_null( $res->users['name'] ) ? $res['etc_name'] : $res->users['name'],
                'respondents' => is_null( $res['respondents'] ) ? '' : $res['respondents'],
                'other_reply1' => is_null( $res['other_reply1'] ) ? '' : $res['other_reply1'],
                'other_reply2' => is_null( $res['other_reply2'] ) ? '' : $res['other_reply2'],
                'other_reply3' => is_null( $res['other_reply3'] ) ? '' : $res['other_reply3'],
                'other_reply4' => is_null( $res['other_reply4'] ) ? '' : $res['other_reply4'],
                'other_reply6' => is_null( $res['other_reply6'] ) ? '' : $res['other_reply6'],
                'other_reply7' => is_null( $res['other_reply7'] ) ? '' : $res['other_reply7'],
                'other_reply8' => is_null( $res['other_reply8'] ) ? '' : $res['other_reply8'],
                'resid' => $res['id'],
                'ishost' => !is_null( $res->hostres['res_id'] ),
                'hostres' => is_null( $res->hostres['respondents'] ) ? '' : $res->hostres['respondents'],
                'hostres_other_reply' => is_null( $res->hostres['other_reply'] ) ? '' : $res->hostres['other_reply'],
                'updated_at' => $res['updated_at'],
//                'hostres_other_reply1' => is_null( $res->hostres['other_reply1'] ) ? '' : $res->hostres['other_reply1'],
//                'hostres_other_reply2' => is_null( $res->hostres['other_reply2'] ) ? '' : $res->hostres['other_reply2'],
//                'hostres_other_reply3' => is_null( $res->hostres['other_reply3'] ) ? '' : $res->hostres['other_reply3'],
//                'hostres_other_reply4' => is_null( $res->hostres['other_reply4'] ) ? '' : $res->hostres['other_reply4'],
//                'hostres_other_reply5' => is_null( $res->hostres['other_reply5'] ) ? '' : $res->hostres['other_reply5'],
//                'hostres_other_reply6' => is_null( $res->hostres['other_reply6'] ) ? '' : $res->hostres['other_reply6'],
//                'hostres_other_reply7' => is_null( $res->hostres['other_reply7'] ) ? '' : $res->hostres['other_reply7'],
//                'hostres_other_reply8' => is_null( $res->hostres['other_reply8'] ) ? '' : $res->hostres['other_reply8'],
            ];
        }
        return $this->makePartial( 'respondent_update_form' );
    }

    protected function checkRespondentReplayTxt( $_postData, $_key, $_id ) {
        if ( isset( $_postData[ $_key ][ $_id ] ) ) {
            return empty( $_postData[ $_key ][ $_id ] ) ? NULL : $_postData[ $_key ][ $_id ];
        } else {
            return NULL;
        }
    }

    public function onUpdateRespondent() {
        $postData = post();
        $resPostData = post( 'respondents' );
        foreach ( $resPostData AS $id => $resStr ) {
            Respondents::find( $id )->update( [
                'other_reply1' => $this->checkRespondentReplayTxt( $postData, 'other_reply1', $id ),
                'other_reply2' => $this->checkRespondentReplayTxt( $postData, 'other_reply2', $id ),
                'other_reply3' => $this->checkRespondentReplayTxt( $postData, 'other_reply3', $id ),
                'other_reply4' => $this->checkRespondentReplayTxt( $postData, 'other_reply4', $id ),
                'respondents' => $resStr === '' ? NULL : $resStr,
                'other_reply6' => $this->checkRespondentReplayTxt( $postData, 'other_reply6', $id ),
                'other_reply7' => $this->checkRespondentReplayTxt( $postData, 'other_reply7', $id ),
                'other_reply8' => $this->checkRespondentReplayTxt( $postData, 'other_reply8', $id ),
            ] );
        }
        $hostResData = post( 'hostres' );
        if ( !is_null( $hostResData ) ) {
            foreach ( $hostResData AS $resid => $hostResStr ) {
                HostRes::where( 'res_id', $resid )->update( [
                    'respondents' => $hostResStr === '' ? NULL : $hostResStr,
                    'other_reply' => $postData['hostres_other_reply'][ $resid ] === '' ? NULL : $postData['hostres_other_reply'][ $resid ],
//                    'other_reply1' => $postData['hostres_other_reply1'][ $resid ] === '' ? NULL : $postData['hostres_other_reply1'][ $resid ],
//                    'other_reply2' => $postData['hostres_other_reply2'][ $resid ] === '' ? NULL : $postData['hostres_other_reply2'][ $resid ],
//                    'other_reply3' => $postData['hostres_other_reply3'][ $resid ] === '' ? NULL : $postData['hostres_other_reply3'][ $resid ],
//                    'other_reply4' => $postData['hostres_other_reply4'][ $resid ] === '' ? NULL : $postData['hostres_other_reply4'][ $resid ],
//                    'other_reply5' => $postData['hostres_other_reply5'][ $resid ] === '' ? NULL : $postData['hostres_other_reply5'][ $resid ],
//                    'other_reply6' => $postData['hostres_other_reply6'][ $resid ] === '' ? NULL : $postData['hostres_other_reply6'][ $resid ],
//                    'other_reply7' => $postData['hostres_other_reply7'][ $resid ] === '' ? NULL : $postData['hostres_other_reply7'][ $resid ],
//                    'other_reply8' => $postData['hostres_other_reply8'][ $resid ] === '' ? NULL : $postData['hostres_other_reply8'][ $resid ],
                ] );
            }
        }
        $this->onSuccess();
    }

    public function onUpdateResponsibility() {
        $postData = post();
        Resolution::find( $postData['res_id'] )->update( [
            'resolution' => $postData['responsibilityForm']['resolution'] === '' ? NULL : $postData['responsibilityForm']['resolution'],
            'responsibility' => $postData['responsibilityForm']['responsibility'] === '' ? NULL : $postData['responsibilityForm']['responsibility'],
        ] );
        $this->onSuccess();
    }

    public function onUpdateEditList() {
        $postData = post();
        Proposal_list::find( $postData['list_id'] )->update( [
            'content' => $postData['proposalForm']['content'],
            'sort' => $postData['proposalForm']['sort'],
            'is_show' => $postData['proposalForm']['is_show'],
//            'user_id' => $postData['proposalForm']['user_id'],
            'description' => $postData['proposalForm']['description'],
            'suggest' => $postData['proposalForm']['suggest'],
            'status' => $postData['proposalForm']['status'],
        ] );
        $customerIndex = Meeting_index::find( $postData['list_id'] );
        $customerIndex->customer_index = $postData['proposalForm']['meetingIndex']['customer_index'] === '' ? NULL : $postData['proposalForm']['meetingIndex']['customer_index'];
        $customerIndex->save();
        $organizerIdList = [];
        $organizerEtcNameList = [];
        $defaultres = is_null( post( 'defaultres' ) ) ? [] : post( 'defaultres' );
        $org = is_null( post( 'organizer' ) ) ? $defaultres : post( 'organizer' );
        foreach ( array_unique( $org ) AS $o ) {
            $_t = User::where( [ 'name' => $o ] )->first();
            if ( is_null( $_t ) ) {
                $organizerEtcNameList[] = $o;
                continue;
            }
            $organizerIdList[] = $_t->id;
            unset( $_t );
        }
        Respondents::where( 'meeting_id', $postData['meeting_id'] )
            ->where( 'list_id', $postData['list_id'] )
            ->where( function( $query ) use ( $postData, $organizerIdList, $organizerEtcNameList ) {
                if ( !empty( $organizerIdList ) ) {
                    $query->whereNotIn( 'user_id', $organizerIdList );
                }
                $query->whereNull( 'etc_name' )
                    ->orWhere( function( $orQrury ) use ( $organizerEtcNameList ) {
                        $orQrury->whereNull( 'user_id' );
                        if ( !empty( $organizerEtcNameList ) ) {
                            $orQrury->whereNotIn( 'etc_name', $organizerEtcNameList );
                        }
                    } );
            } )->delete();
        foreach ( $organizerEtcNameList AS $etcName ) {
            Respondents::updateOrCreate( [
                'meeting_id' => $postData['meeting_id'],
                'list_id' => $postData['list_id'],
                'etc_name' => $etcName,
            ] );
        }
        foreach ( $organizerIdList AS $uid ) {
            Respondents::updateOrCreate( [
                'meeting_id' => $postData['meeting_id'],
                'list_id' => $postData['list_id'],
                'user_id' => $uid,
            ] );
        }
        List_meeting::where( 'meeting_id', $postData['meeting_id'] )->where( 'list_id', $postData['list_id'] )
            ->update( [ 'status' => $postData['proposalForm']['status'], ] );
        $this->onSuccess();
        return [
            '.meetingproposallist > div' => $this->makePartial(
                'meetingproposallist',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $postData['meeting_id'] ) ]
            ),
            '.meetingproposallistcancel > div' => $this->makePartial(
                'meetingproposallistcancel',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $postData['meeting_id'] ) ]
            ),
            '.meetingproposallisttube > div' => $this->makePartial(
                'meetingproposallisttube',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $postData['meeting_id'] ) ]
            ),
        ];
    }

    protected function onSuccess( $message = NULL ) {
        Flash::success( is_null( $message ) ? '操作成功。' : $message );
    }

    public function onImportProposal() {
        $model = new \Nashyang\Proposal\Models\Meeting();
        $model->importProposal_list( $this->meetingID );
        return [
            '.meetingproposallist > div' => $this->makePartial(
                'meetingproposallist',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $this->meetingID ) ]
            ),
            '.meetingproposallistcancel > div' => $this->makePartial(
                'meetingproposallistcancel',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $this->meetingID ) ]
            ),
            '.meetingproposallisttube > div' => $this->makePartial(
                'meetingproposallisttube',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $this->meetingID ) ]
            ),
        ];
    }

    public function onSaveSethost() {
        $ressortList = post( 'ressort' );
        $list_id = post( 'list_id' );
        $resIDList = Respondents::where( 'list_id', $list_id )->lists( 'id' );
        $setHostList = post( 'sethostid' );
        $allList = Respondents::where( 'meeting_id', post( 'meeting_id' ) )->lists( 'id' );
        foreach ( $ressortList AS $sortIndex => $resid ) {
            Respondents::find( $resid )->update( [ 'res_sort' => $sortIndex ] );
        }
        if ( is_null( $setHostList ) ) {
            HostRes::where( 'list_id', $list_id )->whereIn( 'res_id', $resIDList )->whereIn( 'res_id', $allList )->delete();
        } else {
            HostRes::where( 'list_id', $list_id )->whereNotIn( 'res_id', $setHostList )->whereIn( 'res_id', $allList )->delete();
            foreach ( $setHostList AS $resID ) {
                HostRes::firstOrCreate( ['list_id' => $list_id, 'res_id' => $resID ] );
            }
        }
        $this->onSuccess();
        return [
            '.meetingproposallist > div' => $this->makePartial(
                'meetingproposallist',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $this->meetingID ) ]
            ),
            '.meetingproposallistcancel > div' => $this->makePartial(
                'meetingproposallistcancel',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $this->meetingID ) ]
            ),
            '.meetingproposallisttube > div' => $this->makePartial(
                'meetingproposallisttube',
                [ 'model' => \Nashyang\Proposal\Models\Meeting::find( $this->meetingID ) ]
            ),
        ];
    }

    public function onSendProposalEmail2() {
        ProposalSendEmail::onSendProposalEmail2( $this->meetingID );
    }
    public function onSendProposalEmail3() {
        ProposalSendEmail::onSendProposalEmail3( $this->meetingID );
    }
}