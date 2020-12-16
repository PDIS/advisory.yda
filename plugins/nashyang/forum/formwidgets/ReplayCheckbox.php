<?php

namespace Nashyang\Forum\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Config;
use Nashyang\Forum\Models\Respondent;


class ReplayCheckbox extends FormWidgetBase {
    public function widgetDetails() {
        return [
            'name' => 'replaycheckbox',
            'description' => 'ReplayCheckbox',
        ];
    }

    public function render() {
        $this->prepareVars();
        return $this->makePartial( 'widget' );
    }

    public function prepareVars() {
        $this->vars['resList'] = isset( $this->getController()->vars['resList'] ) ? $this->getController()->vars['resList'] : NULL;
    }

    public function loadAssets() {
    }

}