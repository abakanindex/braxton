<?php

namespace app\modules\lead_viewing\controllers;

use app\modules\lead_viewing\models\LeadViewing;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ReportController extends Controller
{

    public function actionUpdate($id)
    {
        $model = LeadViewing::findOne($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->scenario = LeadViewing::SCENARIO_REPORT;
            $model->time = date('Y-m-d H:i', $model->time);
            if ($model->save()) {
                return ['result' => 'success', 'sale' => $model];
            }
            return ActiveForm::validate($model);
            Yii::$app->end();
        } else return $this->renderAjax('_report_modal_form', [
            'model' => $model,
        ]);
    }

    public function actionValidate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = LeadViewing::findOne($id);
        $model->scenario = LeadViewing::SCENARIO_REPORT;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->time = date('Y-m-d H:i', $model->time);
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }
}
