<?php
/**
 * Created by Kenshin.
 * User: billy
 * Date: 10/29/2017
 * Time: 4:56 PM
 */

namespace Kenshin\Facebook\Components;
use Cms\Classes\ComponentBase;
use ApplicationException;

class Message extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Message',
            'description' => 'Chat Message box'
        ];
    }

    public function defineProperties()
    {
        return [
            'name' => [
                'description'       => 'This is chatbox by Facebook',
                'title'             => 'Chat by message facebook',
                'default'           => 'itplusvn',
                'type'              => 'string'
            ]
        ];
    }

    public function getNameFanFaceOptions()
    {
        $result = Request::input('name');
        return $result;
    }

    public function info()
    {
        $nameFanFace = $this->property('name');
        return $nameFanFace;
    }
    public function onRun()
    {
        $this->page['fanFace'] = $this->info();
        $this->addJs('/plugins/kenshin/facebook/assets/js/chat.js');
    }
}