<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class SmallBoxWidget extends Widget
{
    /**
     * @var string
     */
    public $color;

    /**
     * @var string
     */
    public $count;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $urlText;

//    public function init()
//    {
//    }

    public function run()
    {
        return $this->render('smallBox/small-box', [
            'color'  => $this->color,
            'count'  => $this->count,
            'text'  => $this->text,
            'icon'  => $this->icon,
            'url'  => $this->url,
            'urlText'  => $this->urlText,
        ]);
    }
}
