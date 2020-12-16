<?php

namespace Nashyang\Proposal\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Config;
use Nashyang\Proposal\Models\ForumUser;
use Nashyang\Proposal\Models\HostRes;
use Nashyang\Proposal\Models\Respondents;


class Sethost extends FormWidgetBase {

    public function render() {
        $this->prepareVars();
        return $this->makePartial( 'widget' );
    }

    public function prepareVars() {
        $this->vars['list_id'] = $this->model->id;
        $this->vars['meeting_id'] = post( 'meetingid' );
        $this->vars['formSendName'] = $this->formField->getName() . '[]';
        $allList = [];
        $idList = $this->model->respondents->where( 'meeting_id', $this->vars['meeting_id'] )
            ->sortBy( 'res_sort' )->lists( 'id' );
        foreach ( $idList AS $resid ) {
            $allList[ $resid ] = [
                'name' => Respondents::getUserNameOrEtcName( $resid ),
                'checked' => HostRes::where( 'list_id', $this->model->id )
                    ->where( 'res_id', $resid )->count() > 0 ? 'checked' : '',
            ];
        }
        $this->vars['allList'] = $allList;
    }

}