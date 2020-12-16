<?php

namespace Nashyang\Forum\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Backend\Models\User;
use RainLab\User\Models\User AS Users;
use Config;
use Nashyang\Forum\Models\Respondent;


class Setressort extends FormWidgetBase {

    public function render() {
        $this->prepareVars();
        return $this->makePartial( 'widget' );
    }

    public function prepareVars() {
        $this->vars['issue_id'] = post( 'issue_id' );
        $allList = [];
        $idList = Respondent::where( 'issue_id', post( 'issue_id' ) )
            ->select( 'id', 'user_id', 'etc_name', 'res_sort' )->orderBy( 'res_sort', 'asc' )->get()->toArray();
        foreach ( $idList AS $lists ) {
            $allList[ $lists['id'] ] = [
                'user_id' => $lists['user_id'],
                'show_name' => ( !is_null( $lists['user_id'] ) ) ?
                    Users::find( $lists['user_id'] )->name : $lists['etc_name'],
                'etc_name' => $lists['etc_name'],
                'res_sort' => $lists['res_sort'],
            ];
        }
        $this->vars['allList'] = $allList;
    }

}