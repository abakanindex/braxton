<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class ChartDashboardWidget extends Widget
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $boxBody;

//    public function init()
//    {
//    }

    public function run()
    {
        return $this->render('chartDashboard/chart-dashboard', [
            'type'    => $this->type,
            'title'   => $this->title,
            'boxBody' => $this->boxBody
        ]);
    }
}
