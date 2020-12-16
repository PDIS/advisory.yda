<?php namespace Nashyang\Proposal\Controllers;

use Backend\Behaviors\ListController;
use Backend\Classes\Controller;
use BackendMenu;

class Premeeting extends Meeting {
    public $implement = [ 'Backend\Behaviors\ListController', 'Backend\Behaviors\FormController' ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    protected $meetingID;

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext( 'Nashyang.Proposal', 'main-menu-nav_top', 'side-menu-premeeting' );
        $this->meetingID = isset( $this->params[0] ) ? $this->params[0] : 0;
    }

    public function listExtendQuery( $query ) {
        return $query->where( 'is_pre', 1 );
    }

    public function formBeforeSave( $model ) {
        $model->is_pre = 1;
    }

}