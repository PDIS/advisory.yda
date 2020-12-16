<?php namespace Nashyang\Backuplog\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Logview extends Controller {
    public $implement = [];

    public function __construct() {
        parent::__construct();
        BackendMenu::setContext( 'Nashyang.Logview', 'main-menu-item', 'side-menu-item' );
    }

    public function index() {
        $this->pageTitle = '查閱備份';
        return;
    }
}