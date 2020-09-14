<?php

namespace app\modules\reports\controllers;

use app\models\Leads;
use app\models\Rentals;
use app\models\Sale;
use app\models\TaskManager;
use app\models\UserViewing;
use app\modules\reports\models\Reports;
use app\modules\reports\models\search\ReportsWidgetChartSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class ReportWidgetController extends Controller
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

    public function actionTasksPriorityCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = TaskManager::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from . ' +1 day');
            $endDate = strtotime($report->date_to . ' +1 day');
            $query->where(['>=', 'created_at', $startDate]);
            $query->andWhere(['<=', 'created_at', $endDate]);
        } 
        $query->select(["COUNT(`id`) AS number", 'priority']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['priority']);
        $data = $query->asArray()->all();
        $tasksWithPriorities = [];
        foreach ($data as $task) {
            $taskWithPriorities = [];
            $taskWithPriorities['priority'] = TaskManager::findPriority($task['priority']);
            $taskWithPriorities['number'] = $task['number'];
            $tasksWithPriorities[] = $taskWithPriorities;
        }
        return $tasksWithPriorities;
    }

    public function actionRentalsViewingCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Rentals::find();
        $query->select(["COUNT(user_viewing.id) AS number", 'ref']);
        $query->join('LEFT JOIN', 'user_viewing', 'user_viewing.model_id = rentals.id AND user_viewing.type = ' . UserViewing::TYPE_RENTAL);
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from . ' +1 day');
            $endDate = strtotime($report->date_to . ' +1 day');
            $query->where(['>=', 'user_viewing.created_at', $startDate]);
            $query->andWhere(['<=', 'user_viewing.created_at', $endDate]);
        }
        $query->andWhere(['IS NOT', 'user_viewing.id', null]);
        $query->groupBy(['rentals.id']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionSalesViewingCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Sale::find();
        $query->select(["COUNT(user_viewing.id) AS number", 'ref']);
        $query->join('LEFT JOIN', 'user_viewing', 'user_viewing.model_id = sale.id AND user_viewing.type = ' . UserViewing::TYPE_SALE);
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'user_viewing.created_at', $startDate]);
            $query->andWhere(['<=', 'user_viewing.created_at', $endDate]);
        }
        $query->andWhere(['IS NOT', 'user_viewing.id', null]);
        $query->groupBy(['sale.id']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionRentalsStatusCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Rentals::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'rented_at', $startDate]);
            $query->andWhere(['<=', 'rented_at', $endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'status']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['status']);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionSalesStatusCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Sale::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'rented_at', $startDate]);
            $query->andWhere(['<=', 'rented_at', $endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'status']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['status']);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionRentalsLocationCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Rentals::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'rented_at', $startDate]);
            $query->andWhere(['<=', 'rented_at', $endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'location']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['location']);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionSalesLocationCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Sale::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'rented_at', $startDate]);
            $query->andWhere(['<=', 'rented_at', $endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'location']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['location']);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionSalesCategoryCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Sale::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'rented_at', $startDate]);
            $query->andWhere(['<=', 'rented_at', $endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'category']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['category']);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionRentalsCategoryCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Rentals::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'rented_at', $startDate]);
            $query->andWhere(['<=', 'rented_at', $endDate]);
        }
        $query->select(["COUNT(`id`) AS number", 'category']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['category']);
        $data = $query->asArray()->all();
        return $data;
    }

    public function actionLeadsStatusCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Leads::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'UNIX_TIMESTAMP(date_time_start)', $startDate]);
            $query->andWhere(['<=', 'UNIX_TIMESTAMP(date_time_start)', $endDate]);
        }
        $query->select(["COUNT(`status`) AS number", 'status']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['status']);
        $leads = $query->asArray()->all();
        return $leads;
    }

    public function actionLeadsTypeCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Leads::find();
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'UNIX_TIMESTAMP(date_time_start)', $startDate]);
            $query->andWhere(['<=', 'UNIX_TIMESTAMP(date_time_start)', $endDate]);
        }
        $query->select(["COUNT(`lead_type`) AS number", 'lead_type']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $query->groupBy(['lead_type']);
        $leads = $query->asArray()->all();
        $leadsWithTypes = [];
        foreach ($leads as $lead) {
            $leadWithType = [];
            $leadWithType['type'] = Leads::findType($lead['lead_type']);
            $leadWithType['number'] = $lead['number'];
            $leadsWithTypes[] = $leadWithType;
        }
        return $leadsWithTypes;
    }

    public function actionLeadsViewingCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $query = Leads::find();
        $query->select(["COUNT(user_viewing.id) AS number", 'agent']);
        $query->join('LEFT JOIN', 'user_viewing', 'user_viewing.model_id = leads.id AND user_viewing.type = ' . UserViewing::TYPE_LEAD);
        if ($report->date_type == Reports::DATE_TYPE_TIME) {
            $startDate = strtotime($report->date_from);
            $endDate = strtotime($report->date_to);
            $query->where(['>=', 'user_viewing.created_at', $startDate]);
            $query->andWhere(['<=', 'user_viewing.created_at', $endDate]);
        }
        $query->andWhere(['IS NOT', 'user_viewing.id', null]);
        $query->groupBy(['leads.id']);
        $query->orderBy([
            'number' => SORT_DESC,
        ]);
        $leads = $query->asArray()->all();
        return $leads;
    }

    public function actionCharts($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $report = Reports::find()->where(['url_id' => $id])->one();
        $reportWidgetChartSearch = new ReportsWidgetChartSearch();
        $data = $reportWidgetChartSearch->getReportData(Yii::$app->request->queryParams, $report);
        return $data;
    }
}
