<?php namespace Kenshin\Facebook\Components;

use Cms\Classes\ComponentBase;
use ApplicationException;

class Comment extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Comment',
            'description' => 'Using comment facebook'
        ];
    }

    public function defineProperties()
    {
        return [
            'numposts' => [
                'description' => 'Number Comment Facebook',
                'title' => 'Comment Facebook',
                'default' => 10,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'

            ]
        ];
    }

    public function getNameFanFaceOptions()
    {
        $result = Request::input('numposts');
        return $result;
    }

    public function info()
    {
        $nameFanFace = $this->property('numposts');
        return $nameFanFace;
    }
    public function onRun()
    {
        $this->page['numposts'] = $this->info();
    }
}