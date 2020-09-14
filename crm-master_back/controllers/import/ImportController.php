<?php

namespace app\import\Controllers;

use app\models\ImportXML;
use Yii;
use yii\web\UploadedFile;

class ImportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new ImportXML();

        if (Yii::$app->request->isPost) {
            $model->xmlFile = UploadedFile::getInstance($model, 'xmlFile');
            if ($model->uploadXmlFile()) {
                $model->success = true;
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}

