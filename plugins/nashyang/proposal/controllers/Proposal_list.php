<?php namespace Nashyang\Proposal\Controllers;

use Backend\Classes\Controller;
use Nashyang\Proposal\Models\Countersign;
use \Nashyang\Proposal\Models\Proposal_list AS ListModel;
use \Nashyang\Proposal\Models\Coganiser;
use BackendMenu;
use October\Rain\Support\Facades\Flash;
use Illuminate\Support\Facades\Redirect;

class Proposal_list extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    protected $updateFormWidget;
    protected $jsonable = [ 'otherform' ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Nashyang.Proposal', 'main-menu-nav_top', 'side-menu-proposal_list');
    }

    public function onUpdateProListSave() {
        if ( !isset( $this->params[0] ) ) {
            Flash::error( '參數錯誤' );
            return Redirect::to( 'backend/nashyang/proposal/proposal_list/' )->with( '參數錯誤', '參數錯誤' );
        }
        $listID = $this->params[0];
        ListModel::find( $listID )->update( [
            'user_id' => post( 'Proposal_list.user_id' ),
            'content' => post( 'Proposal_list.content' ),
            'description' => post( 'Proposal_list.description' ),
            'suggest' => post( 'Proposal_list.suggest' ),
            'expiration_at' => post( 'Proposal_list.expiration_at' ),
        ] );
        if ( !is_null( post( 'Proposal_list.co_rganiser' ) ) ) {
            foreach ( post( 'Proposal_list.co_rganiser' ) AS $coUserID ) {
                Coganiser::create( [ 'list_id' => $listID, 'user_id' => $coUserID ] );
            }
        }
        if ( !is_null( post( 'Proposal_list.plusone' ) ) ) {
            foreach ( post( 'Proposal_list.plusone' ) AS $plusUserID ) {
                Countersign::create( [ 'list_id' => $listID, 'user_id' => $plusUserID ] );
            }
        }
    }

    public function onCreateProListSave() {
        $proID = ListModel::create( [
            'user_id' => post( 'Proposal_list.user_id' ),
            'content' => post( 'Proposal_list.content' ),
            'description' => post( 'Proposal_list.description' ),
            'suggest' => post( 'Proposal_list.suggest' ),
            'expiration_at' => post( 'Proposal_list.expiration_at' ),
            'status' => 0,
        ] )->id;
        if ( !is_null( post( 'Proposal_list.corganiser.co_rganiser' ) ) ) {
            foreach ( post( 'Proposal_list.corganiser.co_rganiser' ) AS $coUserID ) {
                Coganiser::create( [ 'list_id' => $proID, 'user_id' => $coUserID ] );
            }
        }
        if ( !is_null( post( 'Proposal_list.countersign.plusone' ) ) ) {
            foreach ( post( 'Proposal_list.countersign.plusone' ) AS $plusUserID ) {
                Countersign::create( [ 'list_id' => $proID, 'user_id' => $plusUserID, ] );
            }
        }
        Flash::success( '建立成功' );
        if ( post( 'close' ) ) {
            return Redirect::to( 'backend/nashyang/proposal/proposal_list/' )->with( '建立成功', '建立成功' );
        }
        return Redirect::to( 'backend/nashyang/proposal/proposal_list/update/' . $proID )->with( '建立成功', '建立成功' );
    }

}