<?php
namespace app\modules\rentals\controllers;

use app\classes\GridPanel;
use yii\data\{ArrayDataProvider, ActiveDataProvider};
use app\models\FeatureListing;
use app\models\PortalListing;
use kartik\mpdf\Pdf;

use app\models\{
    User,
    UserSearch,
    Contacts,
    ContactsSearch,
    Locations,
    GridColumns,
    Leads,
    LeadsSearch,
    TaskManager,
    DocumentsGenerated
};
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\{ArrayHelper, Json, Url, FileHelper};
use yii\web\{
    UploadedFile,
    NotFoundHttpException,
    Controller,
    Response
};
use app\models\{
    RentalsSearch,
    Rentals,
    Company,
    Gallery
};
use app\models\agent\Agent;
use app\models\owner\Owner;
use app\models\ref\Ref;
use app\models\uploadfile\UploadForm;
use app\models\reference_books\{
    PropertyCategory,
    ContactSource,
    Portals,
    Features
};
use app\classes\existrecord\ExistRecordModel;
use app\models\statusHistory\ArchiveHistory;
use app\classes\CountAddedProducts;
use yii\filters\AccessControl;

/**
 * RentalsController implements the CRUD actions for Rentals model.
 */
class RentalsController extends Controller
{
    /**
     * {@inheritdoc}
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
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['rentalsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['rentalsCreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['rentalsUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['rentalsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['rentalsDelete'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Rentals models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams        = Yii::$app->request->queryParams;
        $locationsSearch    = ArrayHelper::map(Locations::getByParentId($queryParams['RentalsSearch']['region_id']), 'id', 'name');
        $idsLocation        = (!empty($queryParams['RentalsSearch']['area_location_id'])) ? [$queryParams['RentalsSearch']['area_location_id']] : [];
        $subLocationsSearch = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');

        $companyId           = Company::getCompanyIdBySubdomain();
        $locationDropDown    = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_LOCATION), 'id', 'name');
        $subLocationDropDown = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_SUB_LOCATION), 'id', 'name');
        $locationsAll        = Locations::getAllLocations();
        $rentals             = Rentals::getRentals($companyId);
        $categories          = PropertyCategory::getCategories();
        $source              = ContactSource::getContactSources();
        $portalsItems        = Portals::getPortals();
        $featuresItems       = Features::getFeatures();

        $emirates                   = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                  = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation                = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                      = new Rentals();
        $searchModel                = new RentalsSearch();
        $agentUser                  = new Agent();
        $owner                      = new Owner();
        $modelImg                   = new UploadForm();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);
        $firstRecord                = $model->getFirstRecordModel();

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);

        $leadsSearchModel  = new LeadsSearch();
        $myLeadsDataProvider = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $myLeadsDataProvider->pagination->pageSize = 5;

        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 5;
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $locationsCurrent         = Locations::getByParentId($firstRecord->emirate);
        $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent      = [];

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        return $this->render('index', [
            'rentalsArchiveSearch'       => $rentalsArchiveSearch,
            'rentalsArchiveDataProvider' => $rentalsArchiveDataProvider,
            'rentalsPendingSearch'       => $rentalsPendingSearch,
            'rentalsPendingDataProvider' => $rentalsPendingDataProvider,
            'model'                      => $model,
            'firstRecord'                => $firstRecord,
            'searchModel'                => $searchModel,
            'advancedSearch'             => new RentalsSearch(),
            'dataProvider'               => $dataProvider,
            'historyProperty'            => (new ArchiveHistory($firstRecord))->outputArchiveStatus(),
            'modelImg'                   => $modelImg->getPathToImagesByRef($model->getFirstRecordModel()),
            'agentUser'                  => $agentUser->getAgentUserCompany(),
            'owner'                      => $owner->getOwnerCompany(),
            'category'                   => ArrayHelper::map($categories, 'id', 'title'),
            'source'                     => ArrayHelper::map($source, 'id', 'source'),
            'portalsItems'               => ArrayHelper::map($portalsItems, 'id', 'portals'),
            'featuresItems'              => ArrayHelper::map($featuresItems, 'id', 'features'),
            'disabledAttribute'          => true,
            'existRecord'                => (new ExistRecordModel())->getExistRecordModel('app\models\Rentals'),
            'assignedToUser'             => User::findOne($firstRecord->agent_id),
            'usersSearchModel'           => $usersSearchModel,
            'usersDataProvider'          => $usersDataProvider,
            'contactsSearchModel'        => $contactsSearchModel,
            'contactsDataProvider'       => $contactsDataProvider,
            'ownerRecord'                => Contacts::findOne($firstRecord->landlord_id),
            'emirates'                   => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                  => $locations,
            'subLocations'               => $subLocation,
            'locationsAll'               => $locationsAll,
            'rentals'                    => $rentals,
            'columnsGrid'                => $columnsGrid,
            'userColumns'                => $userColumns,
            'filteredColumns'            => $filteredColumns,
            'leadsDataProvider'          => $leadsDataProvider,
            'taskManagerDataProvider'    => $taskManagerDataProvider,
            'locationDropDown'        => $locationDropDown,
            'subLocationDropDown'     => $subLocationDropDown,
            'locationsCurrent'           => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'        => $subLocationsCurrent,
            'myLeadsDataProvider'     => $myLeadsDataProvider,
            'leadsSearchModel'        => $leadsSearchModel,
            'locationsSearch'         => $locationsSearch,
            'subLocationsSearch'      => $subLocationsSearch
        ]);
    }

    public function actionAdvancedSearch()
    {
        $this->layout            = false;
        $queryParams             = Yii::$app->request->queryParams;
        $model                   = new Rentals();
        $userColumns             = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $searchModel             = new RentalsSearch();
        $dataProvider            = $searchModel->search($queryParams);
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $searchModel  = new RentalsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $urlView      = 'rentals/view';

        return $this->render('_gridTable', [
            'dataProvider'     => $dataProvider,
            'searchModel'      => $searchModel,
            'model'            => $model,
            'urlView'          => $urlView,
            'filteredColumns'  => $filteredColumns
        ]);
    }

    /**
     * render grid panel for pending items
     * @return mixed
     */
    public function actionGridPanelPending()
    {
        $this->layout = false;

        $emirates    = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations   = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                      = new Rentals();
        $searchModel                = new RentalsSearch();
        $agentUser                  = new Agent();
        $owner                      = new Owner();
        $modelImg                   = new UploadForm();
        $categories                 = PropertyCategory::getCategories();
        $source                     = ContactSource::getContactSources();
        $portalsItems               = Portals::getPortals();
        $featuresItems              = Features::getFeatures();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);
        $firstRecord                = $model->getFirstRecordModel();
        $usersSearchModel           = new UserSearch();
        $usersDataProvider          = $usersSearchModel->search(Yii::$app->request->queryParams);
        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $contactsDataProvider->pagination->pageSize = 5;
        $usersDataProvider->pagination->pageSize = 5;

        return $this->render('@app/views/parts/_gridPanelSaleRental', [
            'flagListing'        => GridPanel::STATUS_PENDING_LISTING,
            'emirates'           => $emirates,
            'locations'          => $locations,
            'subLocations'       => $subLocation,
            'source'             => $source,
            'portalsItems'       => $portalsItems,
            'featuresItems'      => $featuresItems,
            'agentUser'          => $agentUser,
            'owner'              => $owner,
            'category'           => ArrayHelper::map($categories, 'id', 'title'),
            'searchModel'        => $rentalsPendingSearch,
            'advancedSearch'     => new RentalsSearch(),
            'advancedSearchPath' => '/views/rentals/_search',
            'columnsGrid'        => $columnsGrid,
            'model'              => $firstRecord,
            'urlSaveColumnFilter'=> Url::toRoute(['/rentals/rentals/save-column-filter']),
            'userColumns'        => $userColumns,
            'leadsDataProvider'  => $leadsDataProvider,
            'usersDataProvider'  => $usersDataProvider,
            'taskManagerDataProvider' => $taskManagerDataProvider
        ]);
    }

    /**
     * render grid panel for current items
     * @return mixed
     */
    public function actionGridPanelCurrent()
    {
        $this->layout = false;

        $emirates    = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations   = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                      = new Rentals();
        $searchModel                = new RentalsSearch();
        $agentUser                  = new Agent();
        $owner                      = new Owner();
        $modelImg                   = new UploadForm();
        $categories                 = PropertyCategory::getCategories();
        $source                     = ContactSource::getContactSources();
        $portalsItems               = Portals::getPortals();
        $featuresItems              = Features::getFeatures();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);
        $firstRecord                = $model->getFirstRecordModel();
        $usersSearchModel           = new UserSearch();
        $usersDataProvider          = $usersSearchModel->search(Yii::$app->request->queryParams);
        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $contactsDataProvider->pagination->pageSize = 5;
        $usersDataProvider->pagination->pageSize = 5;

        return $this->render('@app/views/parts/_gridPanelSaleRental', [
            'flagListing'        => GridPanel::STATUS_CURRENT_LISTING,
            'emirates'           => $emirates,
            'locations'          => $locations,
            'subLocations'       => $subLocation,
            'source'             => $source,
            'portalsItems'       => $portalsItems,
            'featuresItems'      => $featuresItems,
            'agentUser'          => $agentUser,
            'owner'              => $owner,
            'category'           => ArrayHelper::map($categories, 'id', 'title'),
            'searchModel'        => $searchModel,
            'advancedSearch'     => new RentalsSearch(),
            'advancedSearchPath' => '/views/rentals/_search',
            'columnsGrid'        => $columnsGrid,
            'model'              => $model,
            'urlSaveColumnFilter'=> Url::toRoute(['/rentals/rentals/save-column-filter']),
            'userColumns'        => $userColumns,
            'leadsDataProvider'  => $leadsDataProvider,
            'usersDataProvider'  => $usersDataProvider,
            'taskManagerDataProvider' => $taskManagerDataProvider
        ]);
    }

    /**
     * render grid panel for archive items
     * @return mixed
     */
    public function actionGridPanelArchive()
    {
        $this->layout = false;

        $emirates    = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations   = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                      = new Rentals();
        $searchModel                = new RentalsSearch();
        $agentUser                  = new Agent();
        $owner                      = new Owner();
        $modelImg                   = new UploadForm();
        $categories                 = PropertyCategory::getCategories();
        $source                     = ContactSource::getContactSources();
        $portalsItems               = Portals::getPortals();
        $featuresItems              = Features::getFeatures();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);
        $firstRecord                = $model->getFirstRecordModel();
        $usersSearchModel           = new UserSearch();
        $usersDataProvider          = $usersSearchModel->search(Yii::$app->request->queryParams);
        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $contactsDataProvider->pagination->pageSize = 5;
        $usersDataProvider->pagination->pageSize = 5;

        return $this->render('@app/views/parts/_gridPanelSaleRental', [
            'flagListing'        => GridPanel::STATUS_ARCHIVE_LISTING,
            'emirates'           => $emirates,
            'locations'          => $locations,
            'subLocations'       => $subLocation,
            'source'             => $source,
            'portalsItems'       => $portalsItems,
            'featuresItems'      => $featuresItems,
            'agentUser'          => $agentUser,
            'owner'              => $owner,
            'category'           => ArrayHelper::map($categories, 'id', 'title'),
            'searchModel'        => $rentalsArchiveSearch,
            'advancedSearch'     => new RentalsSearch(),
            'advancedSearchPath' => '/views/rentals/_search',
            'columnsGrid'        => $columnsGrid,
            'model'              => $model,
            'urlSaveColumnFilter'=> Url::toRoute(['/rentals/rentals/save-column-filter']),
            'userColumns'        => $userColumns,
            'leadsDataProvider'  => $leadsDataProvider,
            'usersDataProvider'  => $usersDataProvider,
            'taskManagerDataProvider' => $taskManagerDataProvider
        ]);
    }

    /**
     * Displays a single Rentals model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $queryParams        = Yii::$app->request->queryParams;
        $locationsSearch    = ArrayHelper::map(Locations::getByParentId($queryParams['RentalsSearch']['region_id']), 'id', 'name');
        $idsLocation        = (!empty($queryParams['RentalsSearch']['area_location_id'])) ? [$queryParams['RentalsSearch']['area_location_id']] : [];
        $subLocationsSearch = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');

        $companyId           = Company::getCompanyIdBySubdomain();
        $locationDropDown    = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_LOCATION), 'id', 'name');
        $subLocationDropDown = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_SUB_LOCATION), 'id', 'name');
        $locationsAll        = Locations::getAllLocations();
        $rentals             = Rentals::getRentals($companyId);
        $categories          = PropertyCategory::getCategories();
        $source              = ContactSource::getContactSources();
        $portalsItems        = Portals::getPortals();
        $featuresItems       = Features::getFeatures();

        $emirates                   = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                  = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation                = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                      = (new Rentals())->getFirstRecordModel($id);
        $searchModel                = new RentalsSearch();
        $agentUser                  = new Agent();
        $owner                      = new Owner();
        $modelImg                   = new UploadForm();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);

        $leadsSearchModel  = new LeadsSearch();
        $myLeadsDataProvider = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $myLeadsDataProvider->pagination->pageSize = 5;

        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 5;
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $locationsCurrent = Locations::getByParentId($model->region_id);
        $subLocationsTemp = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent = [];

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        return $this->render('index', [
            'rentalsArchiveSearch'       => $rentalsArchiveSearch,
            'rentalsArchiveDataProvider' => $rentalsArchiveDataProvider,
            'rentalsPendingSearch'       => $rentalsPendingSearch,
            'rentalsPendingDataProvider' => $rentalsPendingDataProvider,
            'searchModel'                => $searchModel,
            'advancedSearch'             => new RentalsSearch(),
            'dataProvider'               => $dataProvider,
            'firstRecord'                => $model,
            'modelImg'                   => $modelImg->getPathToImagesByRef($model),
            'agentUser'                  => $agentUser->getAgentUserCompany(),
            'owner'                      => $owner->getOwnerCompany(),
            'category'                   => ArrayHelper::map($categories, 'id', 'title'),
            'source'                     => ArrayHelper::map($source, 'id', 'source'),
            'portalsItems'               => ArrayHelper::map($portalsItems, 'id', 'portals'),
            'featuresItems'              => ArrayHelper::map($featuresItems, 'id', 'features'),
            'disabledAttribute'          => true,
            'existRecord'                => (new ExistRecordModel())->getExistRecordModel('app\models\Rentals'),
            'historyProperty'            => (new ArchiveHistory($model))->outputArchiveStatus(),
            'assignedToUser'             => User::findOne($model->agent_id),
            'usersSearchModel'           => $usersSearchModel,
            'usersDataProvider'          => $usersDataProvider,
            'contactsSearchModel'        => $contactsSearchModel,
            'contactsDataProvider'       => $contactsDataProvider,
            'ownerRecord'                => Contacts::findOne($model->landlord_id),
            'emirates'                   => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                  => $locations,
            'subLocations'               => $subLocation,
            'locationsCurrent'           => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'        => $subLocationsCurrent,
            'locationsAll'               => $locationsAll,
            'rentals'                    => $rentals,
            'columnsGrid'                => $columnsGrid,
            'userColumns'                => $userColumns,
            'filteredColumns'            => $filteredColumns,
            'leadsDataProvider'          => $leadsDataProvider,
            'taskManagerDataProvider'    => $taskManagerDataProvider,
            'locationDropDown'        => $locationDropDown,
            'subLocationDropDown'     => $subLocationDropDown,
            'myLeadsDataProvider'     => $myLeadsDataProvider,
            'leadsSearchModel'        => $leadsSearchModel,
            'locationsSearch'         => $locationsSearch,
            'subLocationsSearch'      => $subLocationsSearch
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
            GridColumns::removeForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id);
            foreach($postData['columnChecked'] as $v) {
                GridColumns::add($v, GridColumns::TYPE_RENTAL, Yii::$app->user->id);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * bulk update for selected records
     */
    public function actionBulkUpdate()
    {
        $postData    = Yii::$app->request->post();
        $items       = JSON::decode($postData['items']);
        $attribute   = $postData['attribute'];
        $newValue    = $postData['newValue'];
        $emirate     = $postData['emirate'];
        $location    = $postData['location'];
        $subLocation = $postData['subLocation'];
        $page        = $postData['page'];

        foreach($items as $i) {
            $rec       = Rentals::findOne($i);

            if ($attribute == "region_id") {
                $rec->region_id            = $emirate;
                $rec->area_location_id     = $location;
                $rec->sub_area_location_id = $subLocation;
            } else {
                $rec->{$attribute} = $newValue;
            }
            $rec->save();
        }

        return $this->redirect(['index', 'page' => $page]);
    }

    /*
     * generate brochure
     */
    public function actionGenerateBrochure()
    {
        $this->layout = "@app/views/layouts/generate-docs";

        $request      = Yii::$app->request;
        $postData     = $request->post();
        $items        = JSON::decode($postData['items']);
        $flagListing  = $postData['flagListing'];
        $agentDetails = $postData['agentDetails'];
        $toZip        = [];

        if ($request->isAjax) {
            $allModels = Rentals::findAll($items);

            foreach($allModels as $m) {
                $content = $this->render('/pdf/brochure', [
                    'model'        => $m,
                    'type'         => Yii::t('app', 'Rent'),
                    'user'         => User::findOne(Yii::$app->user->id),
                    'agentDetails' => $agentDetails
                ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_CORE,
                    // A4 paper format
                    'format' => Pdf::FORMAT_A4,
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_LANDSCAPE,
                    // stream to browser inline
                    'destination' => Pdf::DEST_DOWNLOAD,//DEST_BROWSER
                    // your html content input
                    //'content' => $content,
                    // format content from your own css file if needed or use the
                    // enhanced bootstrap css built by Krajee for mPDF formatting
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                    // any css to be embedded if required
                    'cssInline' => '',
                    // set mPDF properties on the fly
                    'options' => ['title' => ''],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader'=>[''],
                        'SetFooter'=>['{PAGENO}'],
                    ]
                ]);

                $fileName   = "Brochure_" . $m->ref . "_" . uniqid() . ".pdf";
                $pathUpload = Yii::getAlias('@webroot') . '/files/generated/pdf/';
                FileHelper::createDirectory($pathUpload);

                $mpdf = $pdf->api;
                $mpdf->WriteHTML($content);
                $mpdf->Output($pathUpload . $fileName, 'F');
                $toZip[] = array(
                    'path' => $pathUpload,
                    'name' => $fileName
                );
            }

            if (count($toZip) > 0) {
                $zip        = new \ZipArchive();
                $zipName   = uniqid() . ".zip";
                $zipUpload = Yii::getAlias('@webroot') . '/files/generated/archive/';
                FileHelper::createDirectory($zipUpload);

                if ($zip->open($zipUpload . $zipName, \ZipArchive::CREATE) === TRUE) {
                    foreach($toZip as $tZ) {
                        $zip->addFile($tZ['path'] . $tZ['name'], $tZ['name']);
                    }

                    $zip->close();

                    DocumentsGenerated::add($zipName, Yii::getAlias('@web') . '/files/generated/archive/', Yii::$app->user->id);

                    foreach($toZip as $tZ) {
                        unlink($tZ['path'] . $tZ['name']);
                    }
                }
            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'url' => Url::toRoute(['/documents/download-pdf-zip', 'name' => $zipName])
            ];
        }
    }

    /*
     * generate a3 poster
     */
    public function actionGeneratePoster()
    {
        $this->layout = "@app/views/layouts/generate-docs";

        $request      = Yii::$app->request;
        $postData     = $request->post();
        $items        = JSON::decode($postData['items']);
        $flagListing  = $postData['flagListing'];
        $agentDetails = $postData['agentDetails'];
        $toZip        = [];

        if ($request->isAjax) {
            $allModels = Rentals::findAll($items);

            foreach($allModels as $m) {
                $content = $this->render('/pdf/poster', [
                    'model'        => $m,
                    'type'         => Yii::t('app', 'Rent'),
                    'user'         => User::findOne(Yii::$app->user->id),
                    'agentDetails' => $agentDetails
                ]);

                $pdf = new Pdf([
                    // set to use core fonts only
                    'mode' => Pdf::MODE_CORE,
                    // A4 paper format
                    'format' => Pdf::FORMAT_A3,
                    // portrait orientation
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    // stream to browser inline
                    'destination' => Pdf::DEST_DOWNLOAD,//DEST_BROWSER
                    // your html content input
                    //'content' => $content,
                    // format content from your own css file if needed or use the
                    // enhanced bootstrap css built by Krajee for mPDF formatting
                    'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                    // any css to be embedded if required
                    'cssInline' => '',
                    // set mPDF properties on the fly
                    'options' => ['title' => ''],
                    // call mPDF methods on the fly
                    'methods' => [
                        'SetHeader'=>[''],
                        'SetFooter'=>['{PAGENO}'],
                    ]
                ]);

                $fileName   = "Poster_" . $m->ref . "_" . uniqid() . ".pdf";
                $pathUpload = Yii::getAlias('@webroot') . '/files/generated/pdf/';
                FileHelper::createDirectory($pathUpload);

                $mpdf = $pdf->api;
                $mpdf->WriteHTML($content);
                $mpdf->Output($pathUpload . $fileName, 'F');
                $toZip[] = array(
                    'path' => $pathUpload,
                    'name' => $fileName
                );
            }

            if (count($toZip) > 0) {
                $zip        = new \ZipArchive();
                $zipName   = uniqid() . ".zip";
                $zipUpload = Yii::getAlias('@webroot') . '/files/generated/archive/';
                FileHelper::createDirectory($zipUpload);

                if ($zip->open($zipUpload . $zipName, \ZipArchive::CREATE) === TRUE) {
                    foreach($toZip as $tZ) {
                        $zip->addFile($tZ['path'] . $tZ['name'], $tZ['name']);
                    }

                    $zip->close();

                    DocumentsGenerated::add($zipName, Yii::getAlias('@web') . '/files/generated/archive/', Yii::$app->user->id);

                    foreach($toZip as $tZ) {
                        unlink($tZ['path'] . $tZ['name']);
                    }
                }
            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'url' => Url::toRoute(['/documents/download-pdf-zip', 'name' => $zipName])
            ];
        }
    }

    /**
     * return owners list for selected listings
     */
    public function actionGetListOwners()
    {
        $this->layout = false;
        $request      = Yii::$app->request;
        $postData     = $request->post();
        $items        = json_decode($postData['items']);

        $provider = new ArrayDataProvider([
            'allModels'  => Rentals::getNotEmptyOwner($items),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        echo $this->render('@app/views/grid-view/_gridListingOwner', [
            'provider' => $provider
        ]);
    }

    /**
     * @return array
     * generate pdf file - table view
     */
    public function actionGeneratePdfTable()
    {
        $this->layout = "@app/views/layouts/generate-docs";

        $request     = Yii::$app->request;
        $postData    = $request->post();
        $items       = JSON::decode($postData['items']);
        $flagListing = $postData['flagListing'];

        if ($request->isAjax) {
            $allModels = Rentals::findAll($items);

            $content = $this->render('/pdf/table', [
                'listDataProvider' => new ArrayDataProvider([
                        'allModels' => $allModels
                    ]),
                'type'             => Yii::t('app', 'Rental')
            ]);

            $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_DOWNLOAD,//DEST_BROWSER
                // your html content input
                //'content' => $content,
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                // any css to be embedded if required
                'cssInline' => '',
                // set mPDF properties on the fly
                'options' => ['title' => ''],
                // call mPDF methods on the fly
                'methods' => [
                    'SetHeader'=>[''],
                    'SetFooter'=>['{PAGENO}'],
                ]
            ]);

            $fileName   = uniqid() . ".pdf";
            $pathUpload = Yii::getAlias('@webroot') . '/files/generated/pdf/';
            FileHelper::createDirectory($pathUpload);

            $mpdf = $pdf->api;
            $mpdf->WriteHTML($content);
            $mpdf->Output($pathUpload . $fileName, 'F');

            DocumentsGenerated::add($fileName, Yii::getAlias('@web') . '/files/generated/pdf/', Yii::$app->user->id);

            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'url' => Url::toRoute(['/documents/download-pdf', 'name' => $fileName])
            ];
//            $response = Yii::$app->response;
//            $response->format = Response::FORMAT_RAW;
//            $headers = Yii::$app->response->headers;
//            $headers->add('Content-Type', 'application/pdf');
//            return $pdf->render();
        }
    }

    /**
     * this method delete entry img in db Gallery
     *
     * @return void
     */
    public function actionDropImg() {

        $modelGallery = Gallery::find()->where([
            'path' => Yii::$app->request->post('url')
        ])->one();

        unlink('../' . Yii::$app->request->post('url'));

        $modelGallery->delete();

    }

    /**
     * unarchive selected items
     */
    public function actionUnarchive()
    {
        $queryParams        = Yii::$app->request->queryParams;
        $locationsSearch    = ArrayHelper::map(Locations::getByParentId($queryParams['RentalsSearch']['region_id']), 'id', 'name');
        $idsLocation        = (!empty($queryParams['RentalsSearch']['area_location_id'])) ? [$queryParams['RentalsSearch']['area_location_id']] : [];
        $subLocationsSearch = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');

        $request  = Yii::$app->request;
        $postData = $request->post();
        $items    = JSON::decode($postData['items']);

        if ($request->isPost) {
            foreach($items as $i) {
                $rec         = Rentals::findOne($i);
                $rec->status = Rentals::STATUS_PUBLISHED;
                $rec->save();
            }
        }

        $companyId           = Company::getCompanyIdBySubdomain();
        $locationDropDown    = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_LOCATION), 'id', 'name');
        $subLocationDropDown = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_SUB_LOCATION), 'id', 'name');
        $locationsAll        = Locations::getAllLocations();
        $rentals             = Rentals::getRentals($companyId);
        $categories          = PropertyCategory::getCategories();
        $source              = ContactSource::getContactSources();
        $portalsItems        = Portals::getPortals();
        $featuresItems       = Features::getFeatures();

        $emirates    = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations   = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                      = new Rentals();
        $searchModel                = new RentalsSearch();
        $agentUser                  = new Agent();
        $owner                      = new Owner();
        $modelImg                   = new UploadForm();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);
        $firstRecord                = $model->getFirstRecordModel();
        $usersSearchModel           = new UserSearch();
        $usersDataProvider          = $usersSearchModel->search(Yii::$app->request->queryParams);
        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $contactsDataProvider->pagination->pageSize = 5;
        $usersDataProvider->pagination->pageSize = 5;

        $leadsSearchModel  = new LeadsSearch();
        $myLeadsDataProvider = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $myLeadsDataProvider->pagination->pageSize = 5;

        return $this->render('index', [
            'rentalsArchiveSearch'       => $rentalsArchiveSearch,
            'rentalsArchiveDataProvider' => $rentalsArchiveDataProvider,
            'rentalsPendingSearch'       => $rentalsPendingSearch,
            'rentalsPendingDataProvider' => $rentalsPendingDataProvider,
            'model'                      => $model,
            'firstRecord'                => $firstRecord,
            'searchModel'                => $searchModel,
            'advancedSearch'             => new RentalsSearch(),
            'dataProvider'               => $dataProvider,
            'modelImg'                   => $modelImg->getPathToImagesByRef($model->getFirstRecordModel()),
            'agentUser'                  => $agentUser->getAgentUserCompany(),
            'owner'                      => $owner->getOwnerCompany(),
            'category'                   => ArrayHelper::map($categories, 'id', 'title'),
            'source'                     => ArrayHelper::map($source, 'id', 'source'),
            'portalsItems'               => ArrayHelper::map($portalsItems, 'id', 'portals'),
            'featuresItems'              => ArrayHelper::map($featuresItems, 'id', 'features'),
            'disabledAttribute'          => true,
            'existRecord'                => (new ExistRecordModel())->getExistRecordModel('app\models\Rentals'),
            'assignedToUser'             => User::findOne($firstRecord->agent_id),
            'usersSearchModel'           => $usersSearchModel,
            'usersDataProvider'          => $usersDataProvider,
            'contactsSearchModel'        => $contactsSearchModel,
            'contactsDataProvider'       => $contactsDataProvider,
            'ownerRecord'                => Contacts::findOne($firstRecord->landlord_id),
            'emirates'                   => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                  => $locations,
            'subLocations'               => $subLocation,
            'locationsAll'               => $locationsAll,
            'rentals'                    => $rentals,
            'columnsGrid'                => $columnsGrid,
            'userColumns'                => $userColumns,
            'filteredColumns'            => $filteredColumns,
            'leadsDataProvider'          => $leadsDataProvider,
            'taskManagerDataProvider'    => $taskManagerDataProvider,
            'locationDropDown'        => $locationDropDown,
            'subLocationDropDown'     => $subLocationDropDown,
            'myLeadsDataProvider'     => $myLeadsDataProvider,
            'leadsSearchModel'        => $leadsSearchModel,
            'locationsSearch'         => $locationsSearch,
            'subLocationsSearch'      => $subLocationsSearch
        ]);
    }

    /**
     * Set status published to selected records
     */
    public function actionMakePublished()
    {
        $postData    = Yii::$app->request->post();
        $items       = JSON::decode($postData['items']);
        $flagListing = $postData['flagListing'];

        foreach($items as $i) {
            $rec = Rentals::findOne($i);
            $rec->status = Rentals::STATUS_PUBLISHED;
            $rec->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Set status unpublished to selected records
     */
    public function actionMakeUnpublished()
    {
        $postData    = Yii::$app->request->post();
        $items       = JSON::decode($postData['items']);
        $flagListing = $postData['flagListing'];

        foreach($items as $i) {
            $rec = Rentals::findOne($i);
            $rec->status = Rentals::STATUS_UNPUBLISHED;
            $rec->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Creates a new Rentals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $queryParams        = Yii::$app->request->queryParams;
        $locationsSearch    = ArrayHelper::map(Locations::getByParentId($queryParams['RentalsSearch']['region_id']), 'id', 'name');
        $idsLocation        = (!empty($queryParams['RentalsSearch']['area_location_id'])) ? [$queryParams['RentalsSearch']['area_location_id']] : [];
        $subLocationsSearch = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');

        $companyId           = Company::getCompanyIdBySubdomain();
        $locationDropDown    = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_LOCATION), 'id', 'name');
        $subLocationDropDown = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_SUB_LOCATION), 'id', 'name');
        $locationsAll        = Locations::getAllLocations();
        $rentals             = Rentals::getRentals($companyId);
        $categories          = PropertyCategory::getCategories();
        $source              = ContactSource::getContactSources();
        $portalsItems        = Portals::getPortals();
        $featuresItems       = Features::getFeatures();

        $emirates      = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations     = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation   = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model         = new Rentals();
        $agentUser     = new Agent();
        $owner         = new Owner();
        $modelImg      = new UploadForm();
        $searchModel   = new RentalsSearch();
        $dataProvider  = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);

        $leadsSearchModel  = new LeadsSearch();
        $myLeadsDataProvider = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $myLeadsDataProvider->pagination->pageSize = 5;

        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 5;
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {
            $portals   = $model->portals;
            $features  = $model->features;
            $model->portals  = "";
            $model->features = "";

            $modelImg->imageFiles = UploadedFile::getInstances($modelImg, 'imageFiles');

            $ownerData = $owner->getNameOwnerById($model);
            $model->dateadded = $model->dateupdated = date('Y-m-d H:i:s');
            $model->owner_mobile = $ownerData['personal_mobile'];
            $model->owner_email  = $ownerData['personal_email'];

            if ($companyId == 'main') {
                $model->company_id = 0;
            } else {
                $model->company_id = $companyId;
            }

            (new CountAddedProducts())->addDateProductsInJsone('Rental');

            if ($model->save()) {
                $modelImg->uploadImagesCompany($model);
                $model->ref  = (new Ref())->getRefCompany($model);
                if ($model->save()) {
                    if (!empty($portals) or !empty($features)) {
                        foreach($portals as $pItem) {
                            $portalListing            = new PortalListing();
                            $portalListing->ref       = $model->ref;
                            $portalListing->portal_id = $pItem;
                            $portalListing->type      = PortalListing::TYPE_RENTAL;
                            $portalListing->save();
                        }

                        foreach($features as $fItem) {
                            $featureListing            = new FeatureListing();
                            $featureListing->ref       = $model->ref;
                            $featureListing->feature_id = $fItem;
                            $featureListing->type       = FeatureListing::TYPE_RENTAL;
                            $featureListing->save();
                        }
                    }
                }

                Yii::$app->session->setFlash('alerts', 'Rental created');

                if (Rentals::find()->where(['id' => $model->id])->exists())
                    return $this->redirect(['view', 'id' => $model->id]);
                else
                    return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'rentalsArchiveSearch'       => $rentalsArchiveSearch,
            'rentalsArchiveDataProvider' => $rentalsArchiveDataProvider,
            'rentalsPendingSearch'       => $rentalsPendingSearch,
            'rentalsPendingDataProvider' => $rentalsPendingDataProvider,
            'searchModel'   => $searchModel,
            'advancedSearch'=> new RentalsSearch(),
            'dataProvider'  => $dataProvider,
            'firstRecord'   => $model,
            'model'         => $model,
            'modelImg'      => $modelImg,
            'agentUser'     => $agentUser->getAgentUserCompany(),
            'owner'         => $owner->getOwnerCompany(),
            'category'      => ArrayHelper::map($categories, 'id', 'title'),
            'source'        => ArrayHelper::map($source, 'id', 'source'),
            'portalsItems'  => ArrayHelper::map($portalsItems, 'id', 'portals'),
            'featuresItems' => ArrayHelper::map($featuresItems, 'id', 'features'),
            'modelImgPrew'  => false,
            'assignedToUser'     => User::findOne($model->agent_id),
            'usersSearchModel'   => $usersSearchModel,
            'usersDataProvider'  => $usersDataProvider,
            'contactsSearchModel'        => $contactsSearchModel,
            'contactsDataProvider'       => $contactsDataProvider,
            'ownerRecord'                => Contacts::findOne($model->landlord_id),
            'emirates'                   => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                  => $locations,
            'subLocations'               => $subLocation,
            'locationsAll'               => $locationsAll,
            'rentals'                    => $rentals,
            'columnsGrid'                => $columnsGrid,
            'userColumns'                => $userColumns,
            'filteredColumns'            => $filteredColumns,
            'leadsDataProvider'          => $leadsDataProvider,
            'taskManagerDataProvider'    => $taskManagerDataProvider,
            'locationDropDown'        => $locationDropDown,
            'subLocationDropDown'     => $subLocationDropDown,
            'myLeadsDataProvider'     => $myLeadsDataProvider,
            'leadsSearchModel'        => $leadsSearchModel,
            'locationsSearch'         => $locationsSearch,
            'subLocationsSearch'      => $subLocationsSearch
        ]);
    }

    /**
     * make sale model archive
     * @param $id
     */
    public function actionArchive($id)
    {
        $queryParams        = Yii::$app->request->queryParams;
        $locationsSearch    = ArrayHelper::map(Locations::getByParentId($queryParams['RentalsSearch']['region_id']), 'id', 'name');
        $idsLocation        = (!empty($queryParams['RentalsSearch']['area_location_id'])) ? [$queryParams['RentalsSearch']['area_location_id']] : [];
        $subLocationsSearch = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');

        $companyId           = Company::getCompanyIdBySubdomain();
        $locationDropDown    = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_LOCATION), 'id', 'name');
        $subLocationDropDown = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_SUB_LOCATION), 'id', 'name');
        $locationsAll        = Locations::getAllLocations();
        $rentals             = Rentals::getRentals($companyId);
        $categories          = PropertyCategory::getCategories();
        $source              = ContactSource::getContactSources();
        $portalsItems        = Portals::getPortals();
        $featuresItems       = Features::getFeatures();

        $model             = $this->findModel($id);
        $model->status = Rentals::STATUS_UNPUBLISHED;
        $model->save();

        $emirates          = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations         = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation       = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $searchModel       = new RentalsSearch();
        $agentUser         = new Agent();
        $owner             = new Owner();
        $modelImg          = new UploadForm();
        $dataProvider      = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);
        $usersSearchModel           = new UserSearch();
        $usersDataProvider          = $usersSearchModel->search(Yii::$app->request->queryParams);
        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $contactsDataProvider->pagination->pageSize = 5;
        $usersDataProvider->pagination->pageSize = 5;

        $leadsSearchModel  = new LeadsSearch();
        $myLeadsDataProvider = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $myLeadsDataProvider->pagination->pageSize = 5;

        $locationsCurrent = Locations::getByParentId($model->region_id);
        $subLocationsTemp = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent = [];

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        return $this->render('index', [
            'rentalsArchiveSearch'       => $rentalsArchiveSearch,
            'rentalsArchiveDataProvider' => $rentalsArchiveDataProvider,
            'rentalsPendingSearch'       => $rentalsPendingSearch,
            'rentalsPendingDataProvider' => $rentalsPendingDataProvider,
            'searchModel'        => $searchModel,
            'advancedSearch'     => new RentalsSearch(),
            'dataProvider'       => $dataProvider,
            'firstRecord'        => $model,
            'modelImg'           => $modelImg->getPathToImagesByRef($model),
            'agentUser'          => $agentUser->getAgentUserCompany(),
            'owner'              => $owner->getOwnerCompany(),
            'category'           => ArrayHelper::map($categories, 'id', 'title'),
            'source'             => ArrayHelper::map($source, 'id', 'source'),
            'portalsItems'       => ArrayHelper::map($portalsItems, 'id', 'portals'),
            'featuresItems'      => ArrayHelper::map($featuresItems, 'id', 'features'),
            'assignedToUser'     => User::findOne($model->agent_id),
            'usersSearchModel'   => $usersSearchModel,
            'usersDataProvider'  => $usersDataProvider,
            'contactsSearchModel'        => $contactsSearchModel,
            'contactsDataProvider'       => $contactsDataProvider,
            'ownerRecord'                => Contacts::findOne($model->landlord_id),
            'emirates'                   => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                  => $locations,
            'subLocations'               => $subLocation,
            'locationsCurrent'           => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'        => $subLocationsCurrent,
            'locationsAll'               => $locationsAll,
            'rentals'                    => $rentals,
            'columnsGrid'                => $columnsGrid,
            'userColumns'                => $userColumns,
            'filteredColumns'            => $filteredColumns,
            'leadsDataProvider'          => $leadsDataProvider,
            'taskManagerDataProvider'    => $taskManagerDataProvider,
            'locationDropDown'        => $locationDropDown,
            'subLocationDropDown'     => $subLocationDropDown,
            'myLeadsDataProvider'     => $myLeadsDataProvider,
            'leadsSearchModel'        => $leadsSearchModel,
            'locationsSearch'         => $locationsSearch,
            'subLocationsSearch'      => $subLocationsSearch
        ]);
    }

    /**
     * Updates an existing Rentals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $queryParams        = Yii::$app->request->queryParams;
        $locationsSearch    = ArrayHelper::map(Locations::getByParentId($queryParams['RentalsSearch']['region_id']), 'id', 'name');
        $idsLocation        = (!empty($queryParams['RentalsSearch']['area_location_id'])) ? [$queryParams['RentalsSearch']['area_location_id']] : [];
        $subLocationsSearch = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');

        $companyId           = Company::getCompanyIdBySubdomain();
        $locationDropDown    = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_LOCATION), 'id', 'name');
        $subLocationDropDown = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_SUB_LOCATION), 'id', 'name');
        $locationsAll        = Locations::getAllLocations();
        $rentals             = Rentals::getRentals($companyId);
        $categories          = PropertyCategory::getCategories();
        $source              = ContactSource::getContactSources();
        $portalsItems        = Portals::getPortals();
        $featuresItems       = Features::getFeatures();

        $emirates          = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations         = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation       = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model             = $this->findModel($id);
        $searchModel       = new RentalsSearch();
        $agentUser         = new Agent();
        $owner             = new Owner();
        $modelImg          = new UploadForm();
        $dataProvider      = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);

        $leadsSearchModel  = new LeadsSearch();
        $myLeadsDataProvider = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $myLeadsDataProvider->pagination->pageSize = 5;

        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 5;
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $locationsCurrent = Locations::getByParentId($model->region_id);
        $subLocationsTemp = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent = [];

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }


        if ($model->load(Yii::$app->request->post())) {
            $portals   = $model->portals;
            $features  = $model->features;
            $model->portals  = "";
            $model->features = "";

            $modelImg->imageFiles = UploadedFile::getInstances($modelImg, 'imageFiles');
            $ownerData            = $owner->getNameOwnerById($model);
            $model->dateupdated = date('Y-m-d H:i:s');
            $model->owner_mobile = $ownerData['personal_mobile'];
            $model->owner_email  = $ownerData['personal_email'];

            if ($model->save()) {
                $modelImg->uploadImagesCompany($model);
                if(Yii::$app->request->post("checimg")) {
                    $modelImg->putWatermark($model, Yii::$app->request->post("checimg"));
                }
                PortalListing::deleteByRef($model->ref);
                FeatureListing::deleteByRef($model->ref);
                if (!empty($portals) or !empty($features)) {
                    foreach($portals as $pItem) {
                        $portalListing            = new PortalListing();
                        $portalListing->ref       = $model->ref;
                        $portalListing->portal_id = $pItem;
                        $portalListing->type      = PortalListing::TYPE_RENTAL;
                        $portalListing->save();
                    }

                    foreach($features as $fItem) {
                        $featureListing            = new FeatureListing();
                        $featureListing->ref       = $model->ref;
                        $featureListing->feature_id = $fItem;
                        $featureListing->type       = FeatureListing::TYPE_RENTAL;
                        $featureListing->save();
                    }
                }
            }

            Yii::$app->session->setFlash('alerts', 'Rental updated');

            if (Rentals::find()->where(['id' => $model->id])->exists())
                return $this->redirect(['view', 'id' => $model->id]);
            else
                return $this->redirect(['index']);
        }

        return $this->render('index', [
            'rentalsArchiveSearch'       => $rentalsArchiveSearch,
            'rentalsArchiveDataProvider' => $rentalsArchiveDataProvider,
            'rentalsPendingSearch'       => $rentalsPendingSearch,
            'rentalsPendingDataProvider' => $rentalsPendingDataProvider,
            'searchModel'                => $searchModel,
            'advancedSearch'             => new RentalsSearch(),
            'dataProvider'               => $dataProvider,
            'historyProperty'            => (new ArchiveHistory($model))->outputArchiveStatus(),
            'firstRecord'                => $model,
            'modelImg'                   => $modelImg,
            'modelImgPrew'               => $modelImg->getPathToImagesByRef($model),
            'agentUser'                  => $agentUser->getAgentUserCompany(),
            'owner'                      => $owner->getOwnerCompany(),
            'category'                   => ArrayHelper::map($categories, 'id', 'title'),
            'source'                     => ArrayHelper::map($source, 'id', 'source'),
            'portalsItems'               => ArrayHelper::map($portalsItems, 'id', 'portals'),
            'featuresItems'              => ArrayHelper::map($featuresItems, 'id', 'features'),
            'assignedToUser'             => User::findOne($model->agent_id),
            'usersSearchModel'           => $usersSearchModel,
            'usersDataProvider'          => $usersDataProvider,
            'contactsSearchModel'        => $contactsSearchModel,
            'contactsDataProvider'       => $contactsDataProvider,
            'ownerRecord'                => Contacts::findOne($model->landlord_id),
            'emirates'                   => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                  => $locations,
            'subLocations'               => $subLocation,
            'locationsCurrent'           => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'        => $subLocationsCurrent,
            'locationsAll'               => $locationsAll,
            'rentals'                    => $rentals,
            'columnsGrid'                => $columnsGrid,
            'userColumns'                => $userColumns,
            'filteredColumns'            => $filteredColumns,
            'leadsDataProvider'          => $leadsDataProvider,
            'taskManagerDataProvider'    => $taskManagerDataProvider,
            'locationDropDown'           => $locationDropDown,
            'subLocationDropDown'        => $subLocationDropDown,
            'myLeadsDataProvider'     => $myLeadsDataProvider,
            'leadsSearchModel'        => $leadsSearchModel,
            'locationsSearch'         => $locationsSearch,
            'subLocationsSearch'      => $subLocationsSearch
        ]);
    }

    /**
     * Deletes an existing Rentals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Rentals::STATUS_UNPUBLISHED;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionSlug($slug)
    {
        $queryParams        = Yii::$app->request->queryParams;
        $locationsSearch    = ArrayHelper::map(Locations::getByParentId($queryParams['RentalsSearch']['region_id']), 'id', 'name');
        $idsLocation        = (!empty($queryParams['RentalsSearch']['area_location_id'])) ? [$queryParams['RentalsSearch']['area_location_id']] : [];
        $subLocationsSearch = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');

        $companyId           = Company::getCompanyIdBySubdomain();
        $locationDropDown    = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_LOCATION), 'id', 'name');
        $subLocationDropDown = ArrayHelper::map(Locations::getLocationByType(Locations::TYPE_SUB_LOCATION), 'id', 'name');
        $locationsAll        = Locations::getAllLocations();
        $rentals             = Rentals::getRentals($companyId);
        $categories          = PropertyCategory::getCategories();
        $source              = ContactSource::getContactSources();
        $portalsItems        = Portals::getPortals();
        $featuresItems       = Features::getFeatures();

        $emirates                   = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                  = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation                = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $model                      = Rentals::getBySlug($slug);
        $searchModel                = new RentalsSearch();
        $agentUser                  = new Agent();
        $owner                      = new Owner();
        $modelImg                   = new UploadForm();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $rentalsArchiveSearch       = new RentalsSearch();
        $rentalsArchiveDataProvider = $rentalsArchiveSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_UNPUBLISHED);
        $rentalsPendingSearch       = new RentalsSearch();
        $rentalsPendingDataProvider = $rentalsPendingSearch->search(Yii::$app->request->queryParams, Rentals::STATUS_PENDING);
        $usersSearchModel           = new UserSearch();
        $usersDataProvider          = $usersSearchModel->search(Yii::$app->request->queryParams);
        $contactsSearchModel        = new ContactsSearch();
        $contactsDataProvider       = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider          = new ArrayDataProvider([
            'allModels' => Leads::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $taskManagerDataProvider    = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->ref),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $userColumns                = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_RENTAL, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Rentals::getColumns($dataProvider);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $contactsDataProvider->pagination->pageSize = 5;
        $usersDataProvider->pagination->pageSize = 5;

        $leadsSearchModel  = new LeadsSearch();
        $myLeadsDataProvider = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $myLeadsDataProvider->pagination->pageSize = 5;

        $locationsCurrent = Locations::getByParentId($model->region_id);
        $subLocationsTemp = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent = [];

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        return $this->render('index', [
            'rentalsArchiveSearch'       => $rentalsArchiveSearch,
            'rentalsArchiveDataProvider' => $rentalsArchiveDataProvider,
            'rentalsPendingSearch'       => $rentalsPendingSearch,
            'rentalsPendingDataProvider' => $rentalsPendingDataProvider,
            'searchModel'                => $searchModel,
            'advancedSearch'             => new RentalsSearch(),
            'dataProvider'               => $dataProvider,
            'firstRecord'                => $model,
            'modelImg'                   => $modelImg->getPathToImagesByRef($model),
            'agentUser'                  => $agentUser->getAgentUserCompany(),
            'owner'                      => $owner->getOwnerCompany(),
            'category'                   => ArrayHelper::map($categories, 'id', 'title'),
            'source'                     => ArrayHelper::map($source, 'id', 'source'),
            'portalsItems'               => ArrayHelper::map($portalsItems, 'id', 'portals'),
            'featuresItems'              => ArrayHelper::map($featuresItems, 'id', 'features'),
            'disabledAttribute'          => true,
            'existRecord'                => (new ExistRecordModel())->getExistRecordModel('app\models\Rentals'),
            'historyProperty'            => (new ArchiveHistory($model))->outputArchiveStatus(),
            'assignedToUser'             => User::findOne($model->agent_id),
            'usersSearchModel'           => $usersSearchModel,
            'usersDataProvider'          => $usersDataProvider,
            'contactsSearchModel'        => $contactsSearchModel,
            'contactsDataProvider'       => $contactsDataProvider,
            'ownerRecord'                => Contacts::findOne($model->landlord_id),
            'emirates'                   => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                  => $locations,
            'subLocations'               => $subLocation,
            'locationsCurrent'           => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'        => $subLocationsCurrent,
            'locationsAll'               => $locationsAll,
            'rentals'                    => $rentals,
            'columnsGrid'                => $columnsGrid,
            'userColumns'                => $userColumns,
            'filteredColumns'            => $filteredColumns,
            'leadsDataProvider'          => $leadsDataProvider,
            'taskManagerDataProvider'    => $taskManagerDataProvider,
            'locationDropDown'        => $locationDropDown,
            'subLocationDropDown'     => $subLocationDropDown,
            'myLeadsDataProvider'     => $myLeadsDataProvider,
            'leadsSearchModel'        => $leadsSearchModel,
            'locationsSearch'         => $locationsSearch,
            'subLocationsSearch'      => $subLocationsSearch
        ]);
    }


    /**
     * Finds the Rentals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rentals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rentals::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}