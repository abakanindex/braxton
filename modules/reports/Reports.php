<?php

namespace app\modules\reports;

/**
 * reports module definition class
 */
class Reports extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\reports\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = '@app/views/layouts/reports';
        // custom initialization code goes here
    }
}
