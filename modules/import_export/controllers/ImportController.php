<?php

namespace app\modules\import_export\controllers;

use Yii;
use yii\web\Controller;
use app\modules\import_export\models\ImportXML;
use yii\web\UploadedFile;

/**
 * Default controller for the `ImportExport` module
 */
class ImportController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //$this->layout = 'main-login';
        $model = new ImportXML;

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
