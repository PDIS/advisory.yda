<?php namespace Nashyang\Proposal;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot() {
        $adminGpModel = \Nashyang\Proposal\Models\ForumUser::where( 'code', 'froum-admin' )->first();
        if ( is_null( $adminGpModel ) ) {
            $adminGpModel = new \Nashyang\Proposal\Models\ForumUser;
            $adminGpModel->name = '前台上帝模式群組';
            $adminGpModel->code = 'froum-admin';
            $adminGpModel->description = '前台上帝模式群組';
            $adminGpModel->save();
            unset( $adminGpModel );
        }
    }

    public function registerListColumnTypes() {
        return [
            'getexpirationat' => [ $this, 'getExpirationAt' ],
            'getproposalstatus' => [ $this, 'getProposalStatusAt' ],
        ];
    }

    public function getExpirationAt( $value, $column, $record ) {
        if ( is_null( $record->expiration_at ) ) {
            $t = strtotime( $record->created_at );
            $t = strtotime( '+14 day', $t );
            return date( 'Y-m-d H:i:s', $t );
        } else {
            return $record->expiration_at;
        }
    }

    public function getProposalStatusAt( $value, $column, $record ) {
        switch ( $record->status ) {
            case 0:
                return '委員提案';
                break;
            case 1:
                return '自行撤案';
                break;
            case 2:
                return '暫不提大會';
                break;
            case 3:
                return '送部會研處';
                break;
            case 4:
                return '大會否決';
                break;
            case 5:
                return '辦理中';
                break;
            case 6:
                return '已完成 完全參採';
                break;
            case 7:
                return '已完成 部分參採';
                break;
            case 8:
                return '已完成 暫不參採';
                break;
        }
    }

    public function registerFormWidgets() {
        return [
            'Nashyang\Proposal\FormWidgets\Select2tag' => [
                'label' => 'Select2',
                'code' => 'select2tag',
            ],
            'Nashyang\Proposal\FormWidgets\Corganiser' => [
                'label' => 'corganiser',
                'code' => 'corganiser',
            ],
            'Nashyang\Proposal\FormWidgets\Plusone' => [
                'label' => 'plusone',
                'code' => 'plusone',
            ],
            'Nashyang\Proposal\FormWidgets\Sethost' => [
                'label' => 'sethost',
                'code' => 'sethost',
            ],
        ];
    }
}
