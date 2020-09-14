<?php

namespace app\modules\lead\controllers;

use app\models\Company;
use app\models\Leads;
use app\models\Rentals;
use app\models\RentalsSearch;
use app\models\Sale;
use app\models\SaleSearch;
use app\models\Locations;
use Yii;
use app\modules\lead\models\PropertyRequirement;
use app\modules\lead\models\PropertyRequirementSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\{ArrayHelper, Url, Json};

/**
 * PropertyRequirementController implements the CRUD actions for PropertyRequirement model.
 */
class PropertyRequirementController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all PropertyRequirement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PropertyRequirementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PropertyRequirement model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new PropertyRequirement();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    /**
     * Creates a new PropertyRequirement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($leadId = false)
    {
        $postData       = Yii::$app->request->post();
        $model          = new PropertyRequirement();
        $model->lead_id = $leadId;
        $companyId      = Company::getCompanyIdBySubdomain();
        $emirates       = Locations::getByType(Locations::TYPE_EMIRATE);
        $listingRef     = $postData['listingRef'];

        if (!$leadId) {
            $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'id' => 'lead-form',
                    'class' => 'form-horizontal',
                    'data-pjax' => true
                ]
            ]);
            ActiveForm::end();
            $viewToRender = '_formForCreateLead';
        } else
            $viewToRender = '_form';

        if ($companyId == 'main')
            $model->company_id = 0;
        else
            $model->company_id = $companyId;
        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => true, 'action'=> 'create', 'id' => $model->id];
                } else return ['success' => false];
            } else {
                if ($listingRef) {
                    $listing = (Rentals::findOne(['ref' => $listingRef])) ? Rentals::findOne(['ref' => $listingRef]) : Sale::findOne(['ref' => $listingRef]);
                    $model->category_id  = $listing->category_id;
                    $model->emirate      = $listing->region_id;
                    $model->location     = $listing->area_location_id;
                    $model->sub_location = $listing->sub_area_location_id;
                    $model->min_beds     = $listing->beds;
                    $model->min_baths    = $listing->baths;
                    $model->unit         = $listing->unit;
                    $model->unit_type    = $listing->unit_type;
                    $model->min_price    = $listing->price;

                    $locationsCurrent    = ArrayHelper::map(Locations::getByParentId($listing->region_id), 'id', 'name');
                    $idsLocation         = (!empty($listing->area_location_id)) ? [$listing->area_location_id] : [];
                    $subLocationsCurrent = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');
                }

                return $this->renderAjax('create', [
                    'model'               => $model,
                    'emirates'            => ArrayHelper::map($emirates, 'id', 'name'),
                    'locationsCurrent'    => $locationsCurrent,
                    'subLocationsCurrent' => $subLocationsCurrent,
                    'viewToRender'        => $viewToRender,
                    'form'                => $form
                ]);
            }
        }
    }

    /**
     * Updates an existing PropertyRequirement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $od
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => true, 'action'=> 'update', 'id' => $model->id];
                } else return ['success' => false];
            } else {
                $emirates                 = Locations::getByType(Locations::TYPE_EMIRATE);
                $locationsCurrent         = Locations::getByParentId($model->emirate);
                $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
                $subLocationsCurrent      = [];

                foreach($subLocationsTemp as $key => $value) {
                    $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
                }

                return $this->renderAjax('update', [
                    'model'               => $model,
                    'locationsCurrent'    => ArrayHelper::map($locationsCurrent, 'id', 'name'),
                    'subLocationsCurrent' => $subLocationsCurrent,
                    'emirates'            => ArrayHelper::map($emirates, 'id', 'name')
                ]);
            }
        }
    }

    /**
     * returns requirements list
     * @param integer $leadId
     * @return mixed
     */
    public function actionList($leadId)
    {
        $propertyRequirementDataProvider = new ActiveDataProvider([
            'query'      => PropertyRequirement::find()->where(['lead_id' => $leadId])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->renderAjax('list', [
            'propertyRequirementDataProvider' => $propertyRequirementDataProvider,
        ]);
    }

    /**
     * returns requirements item
     * @param integer $id
     * @return mixed
     */
    public function actionItem($id)
    {
        $model = $this->findModel($id);

        return $this->renderAjax('_property_requirement_list', [
            'model' => $model,
            'update' => true,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionMatchingSalesList()
    {
        $searchModel = new SaleSearch();
        $request = Yii::$app->request;
        if ($request->get('all_requirements')) {
            $dataProviders = $searchModel->searchAllPropertyRequirements($request->get('propertyRequirementLeadId'));
            return $this->renderAjax('_all_matching_sales', [
                'dataProviders' => $dataProviders,
            ]);
        } else {
            $dataProvider = $searchModel->search($request->queryParams);
            $dataProvider->pagination->pageSize = 10;
            return $this->renderAjax('_matching_sales', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function actionMatchingRentalsList()
    {
        $searchModel = new RentalsSearch();
        $request = Yii::$app->request;
        if ($request->get('all_requirements')) {
            $dataProviders = $searchModel->searchAllPropertyRequirements($request->get('propertyRequirementLeadId'));
            return $this->renderAjax('_all_matching_rentals', [
                'dataProviders' => $dataProviders,
            ]);
        } else {
            $dataProvider = $searchModel->search($request->queryParams);
            $dataProvider->pagination->pageSize = 10;
            return $this->renderAjax('_matching_rentals', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Deletes an existing PropertyRequirement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->delete()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true];
        }
    }

    /**
     * Finds the PropertyRequirement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropertyRequirement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropertyRequirement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
