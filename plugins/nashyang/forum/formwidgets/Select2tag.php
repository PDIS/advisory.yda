<?php

namespace Nashyang\Forum\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Config;
use Nashyang\Forum\Models\Tags;

class Select2tag extends FormWidgetBase {
    public function widgetDetails() {
        return [
            'name' => 'Select2box',
            'description' => 'Field for select',
        ];
    }

    public function render() {
        $this->prepareVars();
        return $this->makePartial( 'widget' );
    }

    public function prepareVars() {
        $this->vars['defaultValueList'] = isset( $this->config->default ) ? $this->config->default : [];
        $this->vars['tagList'] = Tags::all()->toArray();
        $this->vars['name'] = $this->formField->getName() . '[]';
    }

    public function loadAssets() {
        $this->addJs( 'js' . DIRECTORY_SEPARATOR . 'select2.min.js' );
        $this->addJs( 'js' . DIRECTORY_SEPARATOR . 'i18n/zh-TW.js' );
    }

}