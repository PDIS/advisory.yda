<?php namespace Nashyang\Forum\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Tags extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Nashyang.Forum', 'main-menu-nav_top', 'side-menu-tags');
    }
}