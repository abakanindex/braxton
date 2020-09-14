<?php

namespace app\controllers;

use app\models\Rentals;
use app\models\Sale;
use yii\web\{Controller, NotFoundHttpException};
use Yii;

class PreviewController extends Controller
{

    /**
     * Preview for rentals, sales
     * @param $ref
     */
    public function actionSlug($slug)
    {
        $this->layout = "@app/views/layouts/main-preview";

        $flagSale = true;
        $model = Sale::getByRef($slug);

        if (!$model) {
            $model = Rentals::getByRef($slug);
            $flagSale = false;
        }

        if (!$model)
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        return $this->render('view', [
            'model' => $model,
            'flagSale' => $flagSale
        ]);
    }

}
