<?php
/**
 * Created by Kenshin.
 * User: billy
 * Date: 10/29/2017
 * Time: 9:03 AM
 */

namespace Kenshin\Facebook;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Facebook',
            'description' => 'Facebook aggregation function',
            'author'      => 'Kenshin',
            'icon'        => 'icon-facebook-square'
        ];
    }

    public function registerComponents()
    {
        return [
            '\Kenshin\Facebook\Components\FanpageFace' => 'fanpageFacebook',
            '\Kenshin\Facebook\Components\Comment' => 'comment',
            '\Kenshin\Facebook\Components\Message' => 'message'
        ];
    }
}