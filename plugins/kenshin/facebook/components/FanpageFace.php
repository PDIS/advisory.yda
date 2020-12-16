<?php namespace Kenshin\Facebook\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;

class FanpageFace extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Fanpage',
            'description' => 'Show fanpage'
        ];
    }

    public function defineProperties()
    {
        return [
            'nameFanFace' => [
                'description'       => 'Input the fanpage name',
                'title'             => 'Name Fanpage Facebook',
                'default'           => 'itplusvn',
                'type'              => 'string'
            ]
        ];
    }

    public function getNameFanFaceOptions()
    {
        $result = Request::input('nameFanFace');
        return $result;
    }

    public function info()
    {
        $nameFanFace = $this->property('nameFanFace');
        return $nameFanFace;
    }
    public function onRun()
    {
        $this->page['fanFace'] = $this->info();
    }
}