<?php

namespace Nashyang\Proposal\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Config;
use Nashyang\Proposal\Models\ForumUser;


class Corganiser extends FormWidgetBase {

    public function render() {
        $this->prepareVars();
        return $this->makePartial( 'widget' );
    }

    public function prepareVars() {
        $this->vars['id'] = $this->model->id;
        $this->vars['committeeMember'] = ForumUser::getCommitteeMemberList();
        $this->vars['formSendName'] = $this->formField->getName() . '[]';
        if ( !empty( $this->model->corganiseruser->lists( 'id' ) ) ) {
            $this->vars['selectedValues'] = $this->model->corganiseruser->lists( 'id' );
        } else {
            $this->vars['selectedValues'] = [];
        }
    }
    
}