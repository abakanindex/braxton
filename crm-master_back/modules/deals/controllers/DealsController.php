<?php

namespace app\modules\deals\controllers;

use app\models\Company;
use app\models\Contacts;
use app\models\Leads;
use app\modules\lead\models\LeadType;
use app\modules\lead\models\LeadSubStatus;
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
 * Class DealsController
 * @package app\modules\deals\controllers
 */
class DealsController extends Controller
{
    /**
     * @var string
     */
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
                        'permissions' => ['dealsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['dealsCreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['dealsUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['dealsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['dealsDelete'],
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
        $firstRecord         = $model->getFirstRecordModel();
        $usersSearchModel    = new UserSearch();
        $usersDataProvider   = $usersSearchModel->search(Yii::$app->request->queryParams);
        $source                = ContactSource::find()->all();
        $agents                = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $categories            = PropertyCategory::find()->all();
        $unitModel             = $firstRecord->getUnitModel();
        $emirates              = Locations::getByType(Locations::TYPE_EMIRATE);
        $locationsCurrent      = Locations::getByParentId($unitModel->region_id);
        $subLocationsTemp      = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent   = [];
        $locationsAll          = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        $locations             = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation           = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->search(Yii::$app->request->queryParams);
        $userColumns           = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns       = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;

        return $this->render('index', [
            'firstRecord'            => $firstRecord,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'assignedToUser'         => User::findOne($firstRecord->created_by),
            'assignedToAgent1'       => User::findOne($model->agent_1),
            'assignedToAgent2'       => User::findOne($model->agent_2),
            'assignedToAgent3'       => User::findOne($model->agent_3),
            'assignedToLead'         => Leads::findOne($firstRecord->lead_id),
            'existRecord'            => (new ExistRecordModel())->getExistRecordModel(Deals::class, 0),
            'disabledAttribute'      => true,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $unitModel,
            'assignedToSeller'       => $unitModel->owner,
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locationsCurrent'       => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'    => $subLocationsCurrent,
            'locations'              => $locations,
            'subLocations'           => $subLocation,
            'dataProvider'           => $dataProvider,
            'userColumns'            => $userColumns,
            'filteredColumns'        => $filteredColumns,
            'searchModel'            => $searchModel,
            'columnsGrid'            => $columnsGrid,
            'leadModel'              => $firstRecord->getLeadModel(),
        ]);
    }

    /**
     * Creates a new Deals model.
     *
     * @return string|Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $locationsAll          = Locations::getAllLocations();
        $emirates              = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations             = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation           = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                 = new Deals();
        $model->created_by     = Yii::$app->user->id;
        $usersSearchModel      = new UserSearch();
        $unitModel             = $model->getUnitModel();
        $usersDataProvider     = $usersSearchModel->search(Yii::$app->request->queryParams);
        $saleSearchModel       = new SaleSearch();
        $saleDataProvider      = $saleSearchModel->search(Yii::$app->request->queryParams);
        $rentalSearchModel     = new RentalsSearch();
        $rentalDataProvider    = $rentalSearchModel->search(Yii::$app->request->queryParams);
        $leadModel             = $model->getLeadModel();
        $leadRefSearchModel    = new LeadsSearch();
        $leadRefDataProvider   = $leadRefSearchModel->search(Yii::$app->request->queryParams);
        $leadTypes             = LeadType::find()->all();
        $leadSubStatuses       = LeadSubStatus::find()->all();
        $source                = ContactSource::find()->all();
        $categories            = PropertyCategory::find()->all();
        $agents                = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->search(Yii::$app->request->queryParams);
        $userColumns           = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;
        $usersDataProvider->pagination->pageSize = 5;
        $saleDataProvider->pagination->pageSize = 10;
        $rentalDataProvider->pagination->pageSize = 10;
        $leadRefDataProvider->pagination->pageSize = 10;

        $formName = ($model->type == Deals::TYPE_RENTAL) ? 'Rentals' : 'Sale';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_by = Yii::$app->user->id;
            $now = time();
            $model->created_at = $now;

            $estimatedDate = strtotime(Yii::$app->request->post('Deals')['estimated_date']);
            $model->estimated_date = $estimatedDate ? $estimatedDate : $now;

            $actualDate = strtotime(Yii::$app->request->post('Deals')['actual_date']);
            $model->actual_date = $actualDate ? $actualDate : $now;

            $model->is_international = 0;
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

            //Choose leadModel from form.
            if (!empty(Yii::$app->request->post('Leads'))) {
                $leadModel = $model->getLeadModel();
                if ($leadModel->load(Yii::$app->request->post(), 'Leads')) {
                    $leadModel->save(false);
                }
            }
            //End of Choose leadModel from form.

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
            'firstRecord'            => $model,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'saleSearchModel'        => $saleSearchModel,
            'saleDataProvider'       => $saleDataProvider,
            'rentalSearchModel'      => $rentalSearchModel,
            'rentalDataProvider'     => $rentalDataProvider,
            'leadRefSearchModel'     => $leadRefSearchModel,
            'leadRefDataProvider'    => $leadRefDataProvider,
            'assignedToUser'         => User::findOne($model->created_by),
            'assignedToAgent1'       => User::findOne($model->agent_1),
            'assignedToAgent2'       => User::findOne($model->agent_2),
            'assignedToAgent3'       => User::findOne($model->agent_3),
            'assignedToLead'         => Leads::findOne($model->lead_id),
            'disabledAttribute'      => false,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $unitModel,
            'assignedToSeller'       => $unitModel->owner,
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'              => $locations,
            'subLocations'           => $subLocation,
            'dataProvider'           => $dataProvider,
            'userColumns'            => $userColumns,
            'filteredColumns'        => $filteredColumns,
            'searchModel'            => $searchModel,
            'typeRental'             => Deals::TYPE_RENTAL,
            'typeSales'              => Deals::TYPE_SALES,
            'leadStatuses'           => Leads::getStatuses(),
            'leadTypes'              => ArrayHelper::map($leadTypes, 'id', 'title'),
            'leadSubStatuses'        => ArrayHelper::map($leadSubStatuses, 'id', 'title'),
            'columnsGrid'            => $columnsGrid,
            'leadModel'              => $leadModel,
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
        $model               = (new Deals())->getFirstRecordModel($id);
        $usersSearchModel    = new UserSearch();
        $usersDataProvider   = $usersSearchModel->search(Yii::$app->request->queryParams);
        $source              = ContactSource::find()->all();
        $agents              = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $categories          = PropertyCategory::find()->all();
        $unitModel           = $model->getUnitModel();
        $emirates            = Locations::getByType(Locations::TYPE_EMIRATE);
        $locationsCurrent    = Locations::getByParentId($unitModel->region_id);
        $subLocationsTemp    = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent = [];
        $locationsAll        = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        $locations           = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation         = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $searchModel         = new DealsSearch();
        $dataProvider        = $searchModel->search(Yii::$app->request->queryParams);
        $userColumns         = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns     = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;

        return $this->render('index', [
            'firstRecord'            => $model,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'assignedToUser'         => User::findOne($model->created_by),
            'assignedToAgent1'       => User::findOne($model->agent_1),
            'assignedToAgent2'       => User::findOne($model->agent_2),
            'assignedToAgent3'       => User::findOne($model->agent_3),
            'assignedToLead'         => Leads::findOne($model->lead_id),
            'existRecord'            => (new ExistRecordModel())->getExistRecordModel(Deals::class, 0),
            'disabledAttribute'      => true,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $unitModel,
            'assignedToSeller'       => $unitModel->owner,
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locationsCurrent'       => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'    => $subLocationsCurrent,
            'locations'              => $locations,
            'subLocations'           => $subLocation,
            'dataProvider'           => $dataProvider,
            'userColumns'            => $userColumns,
            'filteredColumns'        => $filteredColumns,
            'searchModel'            => $searchModel,
            'columnsGrid'            => $columnsGrid,
            'leadModel'              => $model->getLeadModel(),
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
        $model                   = (new Deals())->getFirstRecordModel($id);
        $emirates                = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations               = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation             = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $usersSearchModel        = new UserSearch();
        $usersDataProvider       = $usersSearchModel->search(Yii::$app->request->queryParams);

        $saleSearchModel         = new SaleSearch();
        $saleDataProvider        = $saleSearchModel->search(Yii::$app->request->queryParams);
        $rentalSearchModel       = new RentalsSearch();
        $rentalDataProvider      = $rentalSearchModel->search(Yii::$app->request->queryParams);

        $leadModel               = $model->getLeadModel();
        $leadRefSearchModel      = new LeadsSearch();
        $leadRefDataProvider     = $leadRefSearchModel->search(Yii::$app->request->queryParams);
        $leadTypes               = LeadType::find()->all();
        $leadSubStatuses         = LeadSubStatus::find()->all();
        $source                  = ContactSource::find()->all();
        $categories              = PropertyCategory::find()->all();
        $agents                  = ArrayHelper::map($usersDataProvider->getModels(), 'id', 'username');
        $unitModel               = $model->getUnitModel();
        $locationsCurrent        = Locations::getByParentId($unitModel->region_id);
        $subLocationsTemp        = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent     = [];
        $locationsAll            = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->search(Yii::$app->request->queryParams);
        $userColumns           = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Deals::getColumns($dataProvider);

        foreach ($columnsGrid as $k => $column) {
            if (!in_array($k, $userColumns)) {
                unset($filteredColumns[$k]);
            }
        }

        $dataProvider->pagination->pageSize = 20;
        $usersDataProvider->pagination->pageSize = 5;
        $saleDataProvider->pagination->pageSize = 10;
        $rentalDataProvider->pagination->pageSize = 10;
        $leadRefDataProvider->pagination->pageSize = 10;

        $formName = ($model->type == Deals::TYPE_RENTAL) ? 'Rentals' : 'Sale';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_by = Yii::$app->user->id;

            $now = time();
//            $model->created_at = $now;

            $estimatedDate = strtotime(Yii::$app->request->post('Deals')['estimated_date']);
            $model->estimated_date = $estimatedDate ? $estimatedDate : $now;

            $actualDate = strtotime(Yii::$app->request->post('Deals')['actual_date']);
            $model->actual_date = $actualDate ? $actualDate : $now;

            $model->is_international = 0;
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

            //Choose leadModel from form.
            if (!empty(Yii::$app->request->post('Leads'))) {
                $leadModel = $model->getLeadModel();
                if ($leadModel->load(Yii::$app->request->post(), 'Leads')) {
                    $leadModel->save(false);
                }
            }
            //End of Choose leadModel from form.

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
            'firstRecord'            => $model,
            'usersSearchModel'       => $usersSearchModel,
            'usersDataProvider'      => $usersDataProvider,
            'saleSearchModel'        => $saleSearchModel,
            'saleDataProvider'       => $saleDataProvider,
            'rentalSearchModel'      => $rentalSearchModel,
            'rentalDataProvider'     => $rentalDataProvider,
            'leadRefSearchModel'     => $leadRefSearchModel,
            'leadRefDataProvider'    => $leadRefDataProvider,
            'assignedToUser'         => User::findOne($model->created_by),
            'assignedToAgent1'       => User::findOne($model->agent_1),
            'assignedToAgent2'       => User::findOne($model->agent_2),
            'assignedToAgent3'       => User::findOne($model->agent_3),
            'assignedToLead'         => Leads::findOne($model->lead_id),
            'disabledAttribute'      => false,
            'source'                 => ArrayHelper::map($source, 'id', 'source'),
            'agents'                 => $agents,
            'unitModel'              => $unitModel,
            'assignedToSeller'       => $unitModel->owner,
            'category'               => ArrayHelper::map($categories, 'id', 'title'),
            'locationsAll'           => $locationsAll,
            'emirates'               => ArrayHelper::map($emirates, 'id', 'name'),
            'locationsCurrent'       => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'    => $subLocationsCurrent,
            'locations'              => $locations,
            'subLocations'           => $subLocation,
            'dataProvider'           => $dataProvider,
            'userColumns'            => $userColumns,
            'filteredColumns'        => $filteredColumns,
            'searchModel'            => $searchModel,
            'typeRental'             => Deals::TYPE_RENTAL,
            'typeSales'              => Deals::TYPE_SALES,
            'leadStatuses'           => Leads::getStatuses(),
            'leadTypes'              => ArrayHelper::map($leadTypes, 'id', 'title'),
            'leadSubStatuses'        => ArrayHelper::map($leadSubStatuses, 'id', 'title'),
            'columnsGrid'            => $columnsGrid,
            'leadModel'              => $leadModel,
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

    public function actionListingModel()
    {
        $data['success'] = false;
        $model = null;

        if (Yii::$app->request->get('type') == Deals::TYPE_SALES) {
            $model = Sale::find()->where(['id' => Yii::$app->request->get('id')])->one();
        } elseif (Yii::$app->request->get('type') == Deals::TYPE_RENTAL) {
            $model = Rentals::find()->where(['id' => Yii::$app->request->get('id')])->one();
        }

        $location = Locations::getById($model->area_location_id);
        $subLocation = Locations::getById($model->sub_area_location_id);

        $owner = $model->owner;
        $model = $model->toArray();
        $model['owner'] = $owner->first_name . ' ' . $owner->last_name;

        $data['success'] = true;
        $data['model'] = $model;
        $data['model']['location']['id'] = $location->id;
        $data['model']['location']['name'] = $location->name;
        $data['model']['subLocation']['id'] = $subLocation->id;
        $data['model']['subLocation']['name'] = $subLocation->name;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    public function actionLeadModel()
    {
        $data['success'] = false;

        $model = Leads::find()->where(['id' => Yii::$app->request->get('id')])->one();
        $user = $model->createdByUser;
        $model = $model->toArray();
        $model['username'] = $user->username;

        $data['success'] = true;
        $data['model'] = $model;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $data;
    }

    public function actionAdvancedSearch()
    {
        $this->layout            = false;
        $model                   = new Deals();
        $userColumns             = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns         = $columnsGrid = Deals::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $searchModel           = new DealsSearch();
        $dataProvider          = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('partials/gridTable', [
            'dataProvider'     => $dataProvider,
            'searchModel'      => $searchModel,
            'model'            => $model,
            'urlView'          => 'deals/deals/view',
            'filteredColumns'  => $filteredColumns
        ]);
    }

    /**
     * Save user selected columns for grid
     */
    public function actionSaveColumnFilter()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();

        if ($request->isPost) {
            GridColumns::removeForSection(GridColumns::TYPE_DEAL, Yii::$app->user->id);
            foreach($postData['columnChecked'] as $v) {
                GridColumns::add($v, GridColumns::TYPE_DEAL, Yii::$app->user->id);
            }
        }

        return $this->redirect(['index']);
    }
}
