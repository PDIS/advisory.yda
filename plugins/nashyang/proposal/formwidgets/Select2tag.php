<?php

namespace Nashyang\Proposal\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Config;


class Select2tag extends FormWidgetBase {
    public function widgetDetails() {
        return [
            'name' => 'Select2box',
            'description' => 'Field for select',
        ];
    }

    /**
     * @var string HTML 送出的 name.
     */
    public $sendHtmlName = 'submitName';

    /**
     * @var array 預設可選的 tags 列表.
     * @example public $defaultTags = [ '11', '22' ];
     */
    public $defaultTags = [];

    /**
     * @var array 預設在 $defaultTags 陣列中，被選中的 tags 列表.
     * @example public $defaultTags = [ '11' ];
     */
    public $defaultOnSelectTags = [];

    public function init() {
        $this->fillFromConfig( [
            'sendHtmlName',
            'defaultTags',
            'defaultOnSelectTags',
        ] );
    }

    public function render( $select2List = NULL ) {
        return $this->makePartial( 'widget', $select2List );
    }

    public function loadAssets() {
        $this->addJs( 'js' . DIRECTORY_SEPARATOR . 'select2.min.js' );
        $this->addJs( 'js' . DIRECTORY_SEPARATOR . 'i18n/zh-TW.js' );
    }

}