<?php namespace Nashyang\Forum;

use System\Classes\PluginBase;

class Plugin extends PluginBase {
    public function registerComponents() {
    }

    public function registerSettings() {
    }

    public function boot() {
        $userGpModel = \Nashyang\Forum\Models\ForumUser::where( 'name', '座談會群組' )->first();
        if ( is_null( $userGpModel ) ) {
            $userGpModel = new \Nashyang\Forum\Models\ForumUser;
            $userGpModel->name = '座談會群組';
            $userGpModel->code = 'froum-member';
            $userGpModel->description = '座談會使用者預設群組';
            $userGpModel->save();
            unset( $userGpModel );
        }
        $adminGpModel = \Nashyang\Forum\Models\ForumUser::where( 'code', 'froum-admin' )->first();
        if ( is_null( $adminGpModel ) ) {
            $adminGpModel = new \Nashyang\Forum\Models\ForumUser;
            $adminGpModel->name = '前台上帝模式群組';
            $adminGpModel->code = 'froum-admin';
            $adminGpModel->description = '前台上帝模式群組';
            $adminGpModel->save();
            unset( $adminGpModel );
        }
    }

    public function registerFormWidgets() {
        return [
            'Nashyang\Forum\FormWidgets\Select2tag' => [
                'label' => 'Select2',
                'code' => 'select2tag',
            ],
            'Nashyang\Forum\FormWidgets\ReplayCheckbox' => [
                'label' => 'ReplayCheckbox',
                'code' => 'replaycheckbox',
            ],
            'Nashyang\Forum\FormWidgets\Setressort' => [
                'label' => 'SetResSort',
                'code' => 'setressort',
            ],
        ];
    }
}
