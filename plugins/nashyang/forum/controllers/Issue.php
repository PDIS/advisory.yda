<?php namespace Nashyang\Forum\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Issue extends Controller {
    public $implement = [ 'Backend\Behaviors\ListController', 'Backend\Behaviors\FormController', 'Backend\Behaviors\RelationController', ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';


    public $eventListName;

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext( 'Nashyang.Forum', 'main-menu-nav_top', 'side-menu-event_list' );
    }

    public function listExtendQuery( $query ) {
        $query->where( 'event_id', '=', $this->params['id'] );
    }

}