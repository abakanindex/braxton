<?php

namespace app\modules\lead_viewing\controllers;

use app\models\Leads;
use app\models\Reminder;
use app\models\Rentals;
use app\models\RentalsSearch;
use app\models\Sale;
use app\models\SaleSearch;
use app\modules\lead_viewing\models\LeadViewing;
use app\modules\lead_viewing\models\LeadViewingProperty;
use app\modules\lead_viewing\models\LeadViewingSearch;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `lead_viewing` module
 */
class MainController extends Controller
{
    public function actionList()
    {
        $searchModel = new LeadViewingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $leadViewingRentalsSearchModel = new RentalsSearch();
        $leadViewingRentalsDataProvider = $leadViewingRentalsSearchModel->search(Yii::$app->request->queryParams);
        $leadViewingRentalsDataProvider->pagination->pageSize = 5;

        $leadViewingSalesSearchModel = new SaleSearch();
        $leadViewingSalesDataProvider = $leadViewingSalesSearchModel->search(Yii::$app->request->queryParams);
        $leadViewingSalesDataProvider->pagination->pageSize = 5;

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'leadViewingSalesSearchModel' => $leadViewingSalesSearchModel,
            'leadViewingSalesDataProvider' => $leadViewingSalesDataProvider,
            'leadViewingRentalsSearchModel' => $leadViewingRentalsSearchModel,
            'leadViewingRentalsDataProvider' => $leadViewingRentalsDataProvider,
        ]);
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $leadId = $request->get('leadId');
        $action = $request->get('action');
        $saleId = $request->get('saleId');
        $rentalsId = $request->get('rentalsId');
        $leadViewing = new LeadViewing();
        if ($leadId) {
            $lead = Leads::findOne($leadId);;
            $leadViewing->lead_id = $lead->id;
            $leadViewing->leadReference = $lead->reference;
            return $this->renderAjax('_modal_form', [
                'leadViewing' => $leadViewing,
                'action' => $action,
            ]);
        } else {
            if ($saleId) {
                $leadViewing->leadViewingSales = $saleId;
                $property = Sale::findOne($saleId);
                $propertyType = LeadViewingProperty::TYPE_SALE;
            } elseif ($rentalsId) {
                $leadViewing->leadViewingRentals = $rentalsId;
                $property = Rentals::findOne($rentalsId);
                $propertyType = LeadViewingProperty::TYPE_RENTALS;
            }
            return $this->renderAjax('_modal_form', [
                'leadViewing' => $leadViewing,
                'property' => $property,
                'propertyType' => $propertyType,
                'action' => $action,
            ]);
        }
    }

    public function actionIndexList($id)
    {
        $leadViewing = LeadViewing::find()->where(['id' => $id])->with(['lead', 'sales', 'rentals'])->one();
        $leadViewing->leadReference = $leadViewing->lead->reference;
        $sales = LeadViewingProperty::find()->where(['lead_viewing_id' => $leadViewing->id, 'type' => LeadViewingProperty::TYPE_SALE])->all();
        $rentals = LeadViewingProperty::find()->where(['lead_viewing_id' => $leadViewing->id, 'type' => LeadViewingProperty::TYPE_RENTALS])->all();
        $salesIds = [];
        foreach ($sales as $sale)
            $salesIds[] = $sale->property_id;
        $leadViewing->leadViewingSales = implode(",", $salesIds);
        $rentalsIds = [];
        foreach ($rentals as $rental)
            $rentalsIds[] = $rental->property_id;
        $leadViewing->leadViewingRentals = implode(",", $rentalsIds);

        $getDate = new \DateTime();
        $getDate->setTimestamp($leadViewing->time);
        $leadViewing->time = $getDate->format('Y-m-d H:i');

        return $this->renderAjax('_modal_form_list', [
            'leadViewing' => $leadViewing,
            'sales' => $sales,
            'rentals' => $rentals,
        ]);
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new LeadViewing();
        $model->scenario = LeadViewing::SCENARIO_CREATE_UPDATE;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->created_at = time();
            if ($model->save()) {
                return ['result' => 'success', 'sale' => $model];
            }
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = LeadViewing::findOne($id);
        $model->scenario = LeadViewing::SCENARIO_CREATE_UPDATE;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return ['result' => 'success', 'sale' => $model];
            }
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionSales()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['keylist'])) {
            $keys = \Yii::$app->request->post('keylist');
            $sales = Sale::findAll(['id' => $keys]);
            return ['result' => 'success', 'sales' => $sales];
        }
        return ['result' => 'error'];
    }

    public function actionGetLeadReference($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $lead = Leads::findOne($id);
        return ['reference' => $lead->reference];
    }

    public function actionRentals()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['keylist'])) {
            $keys = \Yii::$app->request->post('keylist');
            $rentals = Rentals::findAll(['id' => $keys]);
            return ['result' => 'success', 'rentals' => $rentals];
        }
        return ['result' => 'error'];
    }

    public function actionValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new LeadViewing();
        $model->scenario = LeadViewing::SCENARIO_CREATE_UPDATE;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->created_at = time();
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $leadViewing = LeadViewing::findOne($id);
        if ($leadViewing->delete()) {
            Reminder::deleteAll(['user_id' => Yii::$app->user->id, 'key_id' => $leadViewing->id, 'key' => Reminder::KEY_TYPE_LEAD_VIEWING_REPORT]);
            return ['result' => 'success'];
        } else
            return ['result' => 'error'];
    }

    public function actionView($id)
    {
        $leadViewing = LeadViewing::findOne($id);

        $leadViewingRentalsSearchModel = new RentalsSearch();
        $leadViewingRentalsDataProvider = $leadViewingRentalsSearchModel->search(Yii::$app->request->queryParams);
        $leadViewingRentalsDataProvider->pagination->pageSize = 5;

        $leadViewingSalesSearchModel = new SaleSearch();
        $leadViewingSalesDataProvider = $leadViewingSalesSearchModel->search(Yii::$app->request->queryParams);
        $leadViewingSalesDataProvider->pagination->pageSize = 5;

        return $this->render('view', [
            'leadViewing' => $leadViewing,
            'leadViewingSalesSearchModel' => $leadViewingSalesSearchModel,
            'leadViewingSalesDataProvider' => $leadViewingSalesDataProvider,
            'leadViewingRentalsSearchModel' => $leadViewingRentalsSearchModel,
            'leadViewingRentalsDataProvider' => $leadViewingRentalsDataProvider,
        ]);
    }
}
