<?php

namespace app\modules\deals\controllers;

use app\models\Company;
use app\models\Leads;
use app\models\Sale;
use app\models\Rentals;
use app\models\User;
use app\models\GridColumns;
use app\models\UserProfile;
use app\models\UserSearch;
use app\models\SaleSearch;
use app\models\RentalsSearch;
use app\models\LeadsSearch;
use app\models\Locations;
use app\models\TaskManager;
use app\models\ref\Ref;
use app\modules\deals\models\Deals;
use app\modules\deals\models\DealsSearch;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\classes\existrecord\ExistRecordModel;
use app\classes\{CountAddedProducts, TotalNumberOfUsers};
use app\models\reference_books\ContactSource;
use app\models\reference_books\PropertyCategory;

/**
 * Class DealsInternationalController
 * @package app\modules\deals\controllers
 */
class DealsInternationalController extends Controller
{
    public $layout = 'deals-base';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['dealsInternationalView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['dealsInternationalCreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['dealsInternationalUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['dealsInternationalView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['dealsInternationalDelete'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model               = new Deals();
        $firstRecord         = $model->getFirstIntRecordModel();
        $usersSearchModel    = new UserSearch();
        $usersDataProvider   = $usersSearchModel->search(Yii::$app->request->queryParams);

        $salesSearchProvider = new SaleSearch();
        $salesDataProvider   = $salesSearchProvider->search(Yii::$app->request->queryParams);
        $rentalsSearchProvider = new RentalsSearch();
        $rentalsDataProvider   = $rentalsSearchProvider->search(Yii::$app->request->queryParams);
        $listingRefDataProvider = new ArrayDataProvider([
            'allModels' => array_merge($salesDataProvider->getModels(), $rentalsDataProvider->getModels())
        ]);

        $leadRefSearchProvider = new LeadsSearch();
        $leadRefDataProvider   = $leadRefSearchProvider->search(Yii::$app->request->queryParams);
        $source                = ContactSource::find()->all();
        $agents                = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $categories            = PropertyCategory::find()->all();
        $unitModel             = $firstRecord->getUnitModel();
        $emirates              = Locations::getByType(Locations::TYPE_EMIRATE);
        $locationsCurrent      = Locations::getByParentId($unitModel->region_id);
        $locations             = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation           = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->searchInt(Yii::$app->request->queryParams);
        $userColumns           = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $locationsAll          = Locations::getAllLocations();
        $filteredColumns       = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;
        $usersDataProvider->pagination->pageSize = 5;
        $listingRefDataProvider->pagination->pageSize = 5;

        return $this->render('index', [
//            'model'             => $model,
//            'searchModel'       => $searchModel,
            'firstRecord'            => $firstRecord,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'listingRefDataProvider' => $listingRefDataProvider,
            'leadRefDataProvider'    => $leadRefDataProvider,
            'assignedToUser'         => User::findOne($firstRecord->created_by),
            'assignedToBuyer'        => User::findOne($firstRecord->buyer_id),
            'assignedToSeller'       => User::findOne($firstRecord->seller_id),
            'assignedToLead'         => Leads::findOne($firstRecord->lead_id),
            'existRecord'            => (new ExistRecordModel())->getExistRecordModel(Deals::class, 1),
            'disabledAttribute'      => true,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $unitModel,
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locationsCurrent'        => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'locations'               => $locations,
            'subLocations'            => $subLocation,
            'dataProvider'            => $dataProvider,
            'userColumns'             => $userColumns,
            'filteredColumns'         => $filteredColumns,
            'searchModel'             => $searchModel,
        ]);
    }

    /**
     * Creates a new Deals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $emirates                = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations               = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation             = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                   = new Deals();
        $usersSearchModel        = new UserSearch();
        $usersDataProvider       = $usersSearchModel->search(Yii::$app->request->queryParams);

        $salesSearchProvider    = new SaleSearch();
        $salesDataProvider      = $salesSearchProvider->search(Yii::$app->request->queryParams);
        $rentalsSearchProvider  = new RentalsSearch();
        $rentalsDataProvider    = $rentalsSearchProvider->search(Yii::$app->request->queryParams);
        $listingRefDataProvider = new ArrayDataProvider([
            'allModels' => array_merge($salesDataProvider->getModels(), $rentalsDataProvider->getModels())
        ]);

        $leadRefSearchProvider = new LeadsSearch();
        $leadRefDataProvider   = $leadRefSearchProvider->search(Yii::$app->request->queryParams);
        $source                = ContactSource::find()->all();
        $categories            = PropertyCategory::find()->all();
        $agents                = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->searchInt(Yii::$app->request->queryParams);
        $userColumns           = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $locationsAll          = Locations::getAllLocations();
        $filteredColumns = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;
        $usersDataProvider->pagination->pageSize = 5;
        $listingRefDataProvider->pagination->pageSize = 5;

        $formName = ($model->type == Deals::TYPE_RENTAL) ? 'Rentals' : 'Sale';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_by = Yii::$app->user->id;
            $model->created_at = time();
            $model->estimated_date = strtotime(Yii::$app->request->post('Deals')['estimated_date']);
            $model->actual_date = strtotime(Yii::$app->request->post('Deals')['actual_date']);
            $model->is_international = 1;
            $companyId = Company::getCompanyIdBySubdomain();

            if ($companyId == 'main') {
                $model->company_id = 0;
            } else {
                $model->company_id = $companyId;
            }

            (new CountAddedProducts())->addDateProductsInJsone('Deals');
            (new TotalNumberOfUsers())->addDateTopUsersInJsone();

            //Choose unitModel from form.
            //If in form chosen Rentals (in type) and loaded Sales model, then data from form will be saved to Rentals model.
            if (Yii::$app->request->post('Deals')['type']
                && Yii::$app->request->post('Deals')['model_id']
            ) {
                if (Yii::$app->request->post('Deals')['type'] == Deals::TYPE_RENTAL) {
                    $unitModelChosen = Rentals::findOne(Yii::$app->request->post('Deals')['model_id']);
                } else {
                    $unitModelChosen = Sale::findOne(Yii::$app->request->post('Deals')['model_id']);
                }

                if ($unitModelChosen->load(Yii::$app->request->post(), $formName) && $unitModelChosen->validate()) {
                    $unitModelChosen->save();
                }
            } else {
                $model->type = $model->model_id = null;
            }
            //End of Choose unitModel from form.

            if ($model->save()) {
                $model->ref  = (new Ref())->getRefCompany($model);
                $model->save();

                if (Deals::find()->where(['id' => $model->id])->exists())
                    return $this->redirect(['view', 'id' => $model->id]);
                else
                    return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
//            'model'             => $model,
//            'searchModel'       => $searchModel,
            'firstRecord'            => $model,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'listingRefDataProvider' => $listingRefDataProvider,
            'leadRefDataProvider'    => $leadRefDataProvider,
            'assignedToUser'         => User::findOne($model->created_by),
            'assignedToBuyer'        => User::findOne($model->buyer_id),
            'assignedToSeller'       => User::findOne($model->seller_id),
            'assignedToLead'         => Leads::findOne($model->lead_id),
            'disabledAttribute'      => false,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $model->getUnitModel(),
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'               => $locations,
            'subLocations'            => $subLocation,
            'dataProvider'            => $dataProvider,
            'userColumns'             => $userColumns,
            'filteredColumns'         => $filteredColumns,
            'searchModel'             => $searchModel,
        ]);
    }

    /**
     * Displays a single Deals model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model                   = (new Deals())->getFirstIntRecordModel($id);
//        $searchModel       = new DealsSearch();
        $usersSearchModel    = new UserSearch();
        $usersDataProvider   = $usersSearchModel->search(Yii::$app->request->queryParams);

        $salesSearchProvider = new SaleSearch();
        $salesDataProvider   = $salesSearchProvider->search(Yii::$app->request->queryParams);
        $rentalsSearchProvider = new RentalsSearch();
        $rentalsDataProvider   = $rentalsSearchProvider->search(Yii::$app->request->queryParams);
        $listingRefDataProvider = new ArrayDataProvider([
            'allModels' => array_merge($salesDataProvider->getModels(), $rentalsDataProvider->getModels())
        ]);

        $leadRefSearchProvider = new LeadsSearch();
        $leadRefDataProvider = $leadRefSearchProvider->search(Yii::$app->request->queryParams);
        $source = ContactSource::find()->all();
        $agents = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $categories          = PropertyCategory::find()->all();
        $unitModel             = $model->getUnitModel();
        $emirates                = Locations::getByType(Locations::TYPE_EMIRATE);
        $locationsCurrent      = Locations::getByParentId($unitModel->region_id);
        $locations               = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation             = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->searchInt(Yii::$app->request->queryParams);
        $userColumns           = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $locationsAll          = Locations::getAllLocations();
        $filteredColumns       = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;
        $usersDataProvider->pagination->pageSize = 5;
        $listingRefDataProvider->pagination->pageSize = 5;

        return $this->render('index', [
//            'searchModel'       => $searchModel,
            'firstRecord'            => $model,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'listingRefDataProvider' => $listingRefDataProvider,
            'leadRefDataProvider'    => $leadRefDataProvider,
            'assignedToUser'         => User::findOne($model->created_by),
            'assignedToBuyer'        => User::findOne($model->buyer_id),
            'assignedToSeller'       => User::findOne($model->seller_id),
            'assignedToLead'         => Leads::findOne($model->lead_id),
            'existRecord'            => (new ExistRecordModel())->getExistRecordModel(Deals::class, 1),
            'disabledAttribute'      => true,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $unitModel,
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locationsCurrent'       => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'locations'              => $locations,
            'subLocations'           => $subLocation,
            'dataProvider'           => $dataProvider,
            'userColumns'            => $userColumns,
            'filteredColumns'        => $filteredColumns,
            'searchModel'            => $searchModel,
        ]);
    }

    /**
     * Updates an existing deal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model                   = (new Deals())->getFirstIntRecordModel($id);
        $emirates                = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations               = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation             = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $usersSearchModel        = new UserSearch();
        $usersDataProvider       = $usersSearchModel->search(Yii::$app->request->queryParams);

        $salesSearchProvider    = new SaleSearch();
        $salesDataProvider      = $salesSearchProvider->search(Yii::$app->request->queryParams);
        $rentalsSearchProvider  = new RentalsSearch();
        $rentalsDataProvider    = $rentalsSearchProvider->search(Yii::$app->request->queryParams);
        $listingRefDataProvider = new ArrayDataProvider([
            'allModels' => array_merge($salesDataProvider->getModels(), $rentalsDataProvider->getModels())
        ]);

        $leadRefSearchProvider = new LeadsSearch();
        $leadRefDataProvider   = $leadRefSearchProvider->search(Yii::$app->request->queryParams);
        $source                = ContactSource::find()->all();
        $categories            = PropertyCategory::find()->all();
        $agents                = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $unitModel             = $model->getUnitModel();
        $locationsCurrent      = Locations::getByParentId($unitModel->region_id);
        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->searchInt(Yii::$app->request->queryParams);
        $userColumns           = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $locationsAll          = Locations::getAllLocations();
        $filteredColumns = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;
        $usersDataProvider->pagination->pageSize = 5;
        $listingRefDataProvider->pagination->pageSize = 5;

        $formName = ($model->type == Deals::TYPE_RENTAL) ? 'Rentals' : 'Sale';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_by = Yii::$app->user->id;
            $model->created_at = time();
            $model->estimated_date = strtotime(Yii::$app->request->post('Deals')['estimated_date']);
            $model->actual_date = strtotime(Yii::$app->request->post('Deals')['actual_date']);
            $model->is_international = 1;
            $companyId = Company::getCompanyIdBySubdomain();

            if ($companyId == 'main') {
                $model->company_id = 0;
            } else {
                $model->company_id = $companyId;
            }

            (new CountAddedProducts())->addDateProductsInJsone('Deals');
            (new TotalNumberOfUsers())->addDateTopUsersInJsone();

            //Choose unitModel from form.
            //If in form chosen Rentals (in type) and loaded Sales model, then data from form will be saved to Rentals model.
            if (Yii::$app->request->post('Deals')['type']
                && Yii::$app->request->post('Deals')['model_id']
            ) {
                if (Yii::$app->request->post('Deals')['type'] == Deals::TYPE_RENTAL) {
                    $unitModelChosen = Rentals::findOne(Yii::$app->request->post('Deals')['model_id']);
                } else {
                    $unitModelChosen = Sale::findOne(Yii::$app->request->post('Deals')['model_id']);
                }

                if ($unitModelChosen->load(Yii::$app->request->post(), $formName) && $unitModelChosen->validate()) {
                    $unitModelChosen->save();
                }
            } else {
                $model->type = $model->model_id = null;
            }
            //End of Choose unitModel from form.

            if ($model->save()) {
                $model->ref  = (new Ref())->getRefCompany($model);
                $model->save();

                if (Deals::find()->where(['id' => $model->id])->exists())
                    return $this->redirect(['view', 'id' => $model->id]);
                else
                    return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
//            'model'             => $model,
//            'searchModel'       => $searchModel,
            'firstRecord'            => $model,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'listingRefDataProvider' => $listingRefDataProvider,
            'leadRefDataProvider'    => $leadRefDataProvider,
            'assignedToUser'         => User::findOne($model->created_by),
            'assignedToBuyer'        => User::findOne($model->buyer_id),
            'assignedToSeller'       => User::findOne($model->seller_id),
            'assignedToLead'         => Leads::findOne($model->lead_id),
            'disabledAttribute'      => false,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $unitModel,
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locationsCurrent'       => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'locations'               => $locations,
            'subLocations'            => $subLocation,
            'dataProvider'            => $dataProvider,
            'userColumns'             => $userColumns,
            'filteredColumns'         => $filteredColumns,
            'searchModel'             => $searchModel,
        ]);
    }

    /**
     * Deletes an existing Deals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Deals::deleteAll([Deals::primaryKey()[0] => $id]);
        return $this->redirect(['index']);
    }
}