<?php

namespace app\modules\reports\controllers;

use app\models\UserViewing;
use app\modules\reports\models\DashboardReportOrder;
use app\modules\reports\models\Reports;
use app\modules\reports\models\UserReportsSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Dashboard controller for the `reports` module
 */
class DashboardOrderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionSort()
    {
        $sortArr = Yii::$app->request->post('sort');
        DashboardReportOrder::deleteAll(['user_id' => Yii::$app->user->id]);
        $order = 1;
        foreach ($sortArr as $sortItem) {
            $newDashboardReportOrder = new DashboardReportOrder();
            $newDashboardReportOrder->user_id = Yii::$app->user->id;
            $newDashboardReportOrder->order = $order;
            if ($sortItem['type'] == DashboardReportOrder::TYPE_COMMON) {
                $newDashboardReportOrder->report_id = $sortItem['id'];
                $newDashboardReportOrder->type = DashboardReportOrder::TYPE_COMMON;
            } else
                $newDashboardReportOrder->type = DashboardReportOrder::TYPE_AGENT_LEADER_BOARD;
            $newDashboardReportOrder->mode = $sortItem['mode'];
            $newDashboardReportOrder->updated_at = time();
            $newDashboardReportOrder->save();
            $order++;
        }
    }

    public function actionChangeMode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $mode = Yii::$app->request->post('mode');
        $widgetOrderId = Yii::$app->request->post('widgetOrderId');
        $dashboardReportOrder = DashboardReportOrder::findOne($widgetOrderId);
        if ($mode == DashboardReportOrder::MODE_OPENED)
            $dashboardReportOrder->mode = DashboardReportOrder::MODE_CLOSED;
        else
            $dashboardReportOrder->mode = DashboardReportOrder::MODE_OPENED;
        if ($dashboardReportOrder->update()) {
            return ['result' => 'success', 'mode' => $dashboardReportOrder->mode, 'id' => $dashboardReportOrder->id];
        } else {
            return ['result' => 'error'];
        }
    }

    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        DashboardReportOrder::deleteAll(['user_id' => Yii::$app->user->id, 'report_id' => $id]);
        $counts = DashboardReportOrder::find()->where(['user_id' => Yii::$app->user->id])->count();
        $newDashboardReportOrder = new DashboardReportOrder();
        $newDashboardReportOrder->user_id = Yii::$app->user->id;
        $newDashboardReportOrder->order = $counts + 1;
        $newDashboardReportOrder->report_id = $id;
        $newDashboardReportOrder->type = DashboardReportOrder::TYPE_COMMON;
        $newDashboardReportOrder->mode = DashboardReportOrder::MODE_OPENED;
        $newDashboardReportOrder->updated_at = time();
        if ($newDashboardReportOrder->save()) {
            return ['result' => 'success'];
        }

        return ['result' => 'error'];
    }

    public function actionRemoveWidget()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $dashboardReportOrder = DashboardReportOrder::findOne(['user_id' => Yii::$app->user->id, 'report_id' => Yii::$app->request->post('widgetId')]);
        if ($dashboardReportOrder->delete()) {
            return ['result' => 'success'];
        } else {
            return ['result' => 'error'];
        }
    }
}
