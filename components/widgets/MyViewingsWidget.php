<?php

namespace app\components\widgets;

use app\models\Viewings;
use Yii;
use yii\base\Widget;


class MyViewingsWidget extends Widget
{
    private $viewingsByUser;

    public function init()
    {
        $this->viewingsByUser = Viewings::getByUser(Yii::$app->user->id);
    }

    public function run()
    {
        return $this->render('myViewings/myViewings', [
            'viewingsByUser' => $this->viewingsByUser
        ]);
    }
}