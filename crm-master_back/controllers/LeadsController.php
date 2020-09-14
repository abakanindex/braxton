<?php

namespace app\controllers;

use app\modules\lead\models\PropertyRequirementSearch;
use kartik\mpdf\Pdf;
use app\classes\GridPanel;
use app\classes\LeadsImport;
use app\models\Company;
use app\models\DocumentsGenerated;
use app\models\GridColumns;
use app\models\Locations;
use app\models\ref\Ref;
use app\models\Rentals;
use app\models\RentalsSearch;
use app\models\Sale;
use app\models\SaleSearch;
use app\models\TaskManager;
use app\models\User;
use app\models\UserSearch;
use app\models\UserViewing;
use app\models\reference_books\ContactSource;
use app\modules\lead\models\LeadSource;
use app\modules\lead\models\LeadsSearch;
use app\modules\lead\models\PropertyRequirement;
use app\modules\lead_viewing\models\LeadViewing;
use DateTime;
use Yii;
use app\models\Leads;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\{ArrayHelper, Url, Json, FileHelper};
use app\models\statusHistory\StatusHistory;
use app\models\statusHistory\ArchiveHistory;
use app\components\widgets\ChangeStatusWidget;
use app\classes\existrecord\ExistRecordModel;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use app\modules\admin\models\OwnerManageGroup;

/**
 * LeadsController implements the CRUD actions for Leads model.
 */
class LeadsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
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
                        'permissions' => ['leadsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['leadsСreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['leadsUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['leadsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['leadsDelete'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }

    public function actionImport()
    {
        $leadImport = new LeadsImport();
        $leadImport->import();

        return 'Saved';
    }

    public function actionSaveLeadProperty()
    {
        $limit = 500;
        $total = Leads::find()->count();
        $iter  = ceil($total / $limit);

        for($i = 0; $i < $iter; $i++) {
            $leads = Leads::find()->limit($limit)->offset($i * $limit)->all();

            foreach($leads as $l) {
                $prR = new PropertyRequirement();
                $prR->min_beds = ceil($l->min_beds);
                $prR->max_beds = $l->max_beds;
                $prR->min_price = $l->min_price;
                $prR->max_price = $l->max_price;
                $prR->min_area = $l->min_area;
                $prR->max_area = $l->max_area;
                $prR->category_id = $l->category_id;
                $prR->emirate = $l->emirate;
                $prR->location = $l->location;
                $prR->sub_location = $l->sub_location;
                $prR->company_id = $l->company_id;
                $prR->lead_id = $l->id;
                $prR->unit_type = $l->unit_type;
                $prR->unit = $l->unit_number;
                $prR->save();

                if ($prR->getErrors()) {
                    print_r($prR->getErrors());
                }
            }
        }
        return 'Saved';
    }

    /**
     * Export lead data to pdf
     */
    public function actionExportToPdf()
    {
        $this->layout = "@app/views/layouts/generate-docs";
        Yii::$app->response->format = Response::FORMAT_JSON;
        $postData = Yii::$app->request->post();
        $items    = json_decode($postData['items']);

        if (!Yii::$app->user->can('Admin')) {
            return [
                'msg' => Yii::t('app', 'Only for admins')
            ];
        }

        $fileName   = 'Leads_' . uniqid(true) . ".pdf";
        $pathUpload = Yii::getAlias('@webroot') . '/files/generated/pdf/';
        DocumentsGenerated::generatePdf(
            $this->render('/pdf/leads', [
                'leads' => Leads::find()
                    ->where(['in', 'id', $items])
                    ->with('subStatus')
                    ->with('typeOne')
                    ->with('contactSource')
                    ->all()
            ]),
            $pathUpload,
            $fileName
        );

        return [
            'url' => Url::to(['documents/download-pdf', 'name' => $fileName])
        ];
    }

    /**
     * Export lead data to xls
     */
    public function actionExportToXls()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $postData = Yii::$app->request->post();
        $items    = json_decode($postData['items']);

        if (!Yii::$app->user->can('Admin')) {
            return [
                'msg' => Yii::t('app', 'Only for admins')
            ];
        }

        $pathUpload = Yii::getAlias('@webroot') . '/files/generated/xls/';
        $fileName   = 'Leads_' . uniqid(true) . '.xlsx';
        DocumentsGenerated::generateXls(
            $pathUpload,
            $fileName,
            Leads::find()
            ->where(['in', 'id', $items])
            ->with('subStatus')
            ->with('typeOne')
            ->with('contactSource'),
            [
                [
                    'attribute' => 'reference'
                ],
                [
                    'attribute' => 'origin',
                    'value'     => function($model) {
                            return $model->getOrigin();
                        }
                ],
                [
                    'attribute' => 'last_name'
                ],
                [
                    'attribute' => 'first_name'
                ],
                [
                    'attribute' => 'email'
                ],
                [
                    'attribute' => 'mobile_number'
                ],
                [
                    'attribute' => 'source',
                    'value'     => function($model) {
                            return $model->contactSource->source;
                        }
                ],
                [
                    'attribute' => 'type_id',
                    'value'     => function($model) {
                            return $model->typeOne->title;
                        }
                ],
                [
                    'attribute' => 'status',
                    'value'     => function($model) {
                            return $model->getStatus();
                        }
                ],
                [
                    'attribute' => 'sub_status_id',
                    'value'     => function($model) {
                            return $model->subStatus->title;
                        }
                ],
                [
                    'attribute' => 'priority',
                    'value'     => function($model) {
                            return $model->getPriority();
                        }
                ],
            ]
        );

        return [
            'url' => Url::to(['documents/download-xls', 'name' => $fileName])
        ];
    }

    /**
     * Lists all Leads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $queryParams              = Yii::$app->request->queryParams;
        $model                    = new Leads();
        $searchModel              = new LeadsSearch();
        $leadViewing              = new LeadViewing();
        $firstRecord              = $model->getFirstRecordModel();
        $dataProvider             = $searchModel->search(Yii::$app->request->queryParams);
        $leadsArchiveSearch       = new LeadsSearch();
        $leadsArchiveDataProvider = $leadsArchiveSearch->search(Yii::$app->request->queryParams, Leads::STATUS_CLOSED);
        $leadViewing->lead_id     = $firstRecord->id;

        $propertyRequirementDataProvider = new ActiveDataProvider([
            'query'      => PropertyRequirement::find()->where(['lead_id' => $firstRecord->id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $userColumns     = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));
        $emirates                 = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation              = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $locationsCurrent         = Locations::getByParentId($model->emirate);
        $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent      = [];
        $locationsAll             = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $propReqSearch            = new PropertyRequirementSearch();
        $propertyReqGridProvider  = $propReqSearch->search(Yii::$app->request->queryParams);
        $locationsSearch          = ArrayHelper::map(Locations::getByParentId($queryParams['PropertyRequirementSearch']['emirate']), 'id', 'name');
        $idsLocation              = (!empty($queryParams['PropertyRequirementSearch']['location'])) ? [$queryParams['PropertyRequirementSearch']['location']] : [];
        $subLocationsSearch       = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');
        $emiratesDropDown         = ArrayHelper::map($emirates, 'id', 'name');

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->reference),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $prReq           = PropertyRequirement::getForLead($firstRecord->id);
        $salesExactMatch = $rentalsExactMatch =[];

        foreach($prReq as $pr) {
            $salesExactMatch = array_merge($salesExactMatch, Sale::getMatchWithLead($pr, true, Yii::$app->user->id, $firstRecord->emirate, $firstRecord->location));
            $rentalsExactMatch = array_merge($rentalsExactMatch, Rentals::getMatchWithLead($pr, true, Yii::$app->user->id, $firstRecord->emirate, $firstRecord->location));
        }

        return $this->render('index', [
            'searchModel'                     => $searchModel,
            'dataProvider'                    => $dataProvider,
            'firstRecord'                     => $firstRecord,
            'model'                           => $firstRecord,
            'attributesDetailView'            => $firstRecord->getAttributesForDetailView(),
            'leadViewing'                     => $leadViewing,
            'propertyRequirementDataProvider' => $propertyRequirementDataProvider,
            'leadsArchiveSearch'              => $leadsArchiveSearch,
            'leadsArchiveDataProvider'        => $leadsArchiveDataProvider,
            'existRecord'                     => (new ExistRecordModel())->getExistRecordModel('app\models\Leads'),
            'columnsGrid'                     => $columnsGrid,
            'userColumns'                     => $userColumns,
            'filteredColumns'                 => $filteredColumns,
            'usersDataProvider'               => $usersDataProvider,
            'taskManagerDataProvider'         => $taskManagerDataProvider,
            'historyProperty'                 => (new ArchiveHistory($firstRecord))->outputArchiveStatus(),
            'emirates'                        => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                       => $locations,
            'subLocations'                    => $subLocation,
            'locationsAll'                    => $locationsAll,
            'locationsCurrent'                => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'             => $subLocationsCurrent,
            'salesMatchProperties'            => $salesExactMatch,
            'rentalsMatchProperties'          => $rentalsExactMatch,
            'source'                          => ArrayHelper::map(ContactSource::find()->all(), 'id', 'source'),
            'propertyReqGridProvider'         => $propertyReqGridProvider,
            'propReqSearch'                   => $propReqSearch,
            'locationsSearch'                 => $locationsSearch,
            'subLocationsSearch'              => $subLocationsSearch,
            'emiratesDropDown'                => $emiratesDropDown,
            'isEmptyPropReqSearch'            => empty($queryParams['PropertyRequirementSearch'])
        ]);
    }

    public function actionGetByRef()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $ref      = $postData['ref'];
        $lead     = Leads::findOne(['reference' => $ref]);

        return $this->asJson($lead);
    }

    public function actionAdvancedSearch()
    {
        $this->layout            = false;
        $queryParams             = Yii::$app->request->queryParams;
        $model                   = new Leads();
        $userColumns             = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns         = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $searchModel  = new LeadsSearch();
        $dataProvider = $searchModel->search($queryParams);
        $urlView      = 'leads/view';

        return $this->render('_gridTable', [
            'dataProvider'     => $dataProvider,
            'searchModel'      => $searchModel,
            'model'            => $model,
            'urlView'          => $urlView,
            'filteredColumns'  => $filteredColumns
        ]);
    }

    public function actionMatchingSendBrochure()
    {
        $this->layout = "@app/views/layouts/generate-docs";
        $request = Yii::$app->request;
        $postData = $request->post();
        $email    = $postData['email'];

        if ($request->isPost) {
            $refs = json_decode($postData['items']);

            foreach($refs as $ref) {
                $model = Rentals::findOne(['ref' => $ref]);

                if (!$model) {
                    $model = Sale::findOne(['ref' => $ref]);
                    $type = Yii::t('app', 'Sale');
                } else {
                    $type = Yii::t('app', 'Rental');
                }

                $content = $this->render('/pdf/brochure', [
                    'model'        => $model,
                    'type'         => $type,
                    'user'         => User::findOne(Yii::$app->user->id),
                    'agentDetails' => ''
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

                $fileName   = "Brochure_" . $model->ref . "_" . uniqid() . ".pdf";
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

                    foreach($toZip as $tZ) {
                        unlink($tZ['path'] . $tZ['name']);
                    }

                    DocumentsGenerated::add($zipName, Yii::getAlias('@web') . '/files/generated/archive/', Yii::$app->user->id);

                    Yii::$app->mailer->compose()
                        ->setFrom('no-reply@' . $_SERVER['SERVER_NAME'])
                        ->setTo($email)
                        ->setSubject(Yii::t('app', 'Pdf brochure'))
                        ->setHtmlBody("")
                        ->attach(Yii::getAlias('@webroot') . '/files/generated/archive/' . $zipName)
                        ->send();

                    unlink(Yii::getAlias('@webroot') . '/files/generated/archive/' . $zipName);
                }
            }
        }

        $res = [
            'msg' => Yii::t('app', 'Brochure send')
        ];

        return $this->asJson($res);
    }

    public function actionMatchingSendLinks()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $baseUrl = str_replace('/web', '', Url::base(true));
        $isSendByEmail = $isSendBySms = false;

        if ($request->isPost) {
            $refs         = json_decode($postData['items']);
            $email        = $postData['email'];
            $byEmail      = $postData['byEmail'];
            $bySms        = $postData['bySms'];
            $previewLinks = [];

            foreach($refs as $r) {
                $url = $baseUrl . Yii::$app->getUrlManager()->createUrl(['preview/' . $r]);
                array_push($previewLinks, "<a href='$url'>" . $r . "</a>");
            }

            if ($byEmail && $email) {
                Yii::$app->mailer->compose()
                    ->setFrom('no-reply@' . $_SERVER['SERVER_NAME'])
                    ->setTo($email)
                    ->setSubject(Yii::t('app', 'Preview links'))
                    ->setHtmlBody(implode(';', $previewLinks))
                    ->send();

                $isSendByEmail = true;
            }

            if ($bySms) {
                $isSendBySms = true;
            }
        }

        $res = [
            'isSendBySms'    => $isSendBySms,
            'isSendByEmail'  => $isSendByEmail,
            'msgSendBySms'   => ($isSendBySms) ? Yii::t('app', 'Send by sms - success') : Yii::t('app', 'Send by sms - unsuccess'),
            'msgSendByEmail' => ($isSendByEmail) ? Yii::t('app', 'Send by email - success') : Yii::t('app', 'Send by email - unsuccess')
        ];

        return $this->asJson($res);
    }

    /**
     * @return string
     * match properties - change type(exact or similar)
     */
    public function actionChangeMatchProperties($id)
    {

        $model           = new Leads();
        $lead            = $model->getFirstRecordModel($id);
        $prReq           = PropertyRequirement::getForLead($id);
        $salesItems      = $rentalsItems = [];
        $request         = Yii::$app->request;
        $postData        = $request->post();
        $type            = $postData['type'];

        if ($type == 1) {
            foreach($prReq as $pr) {
                $salesItems   = array_merge($salesItems, Sale::getMatchWithLead($pr, true, Yii::$app->user->id, $lead->emirate, $lead->location));
                $rentalsItems = array_merge($rentalsItems, Rentals::getMatchWithLead($pr, true, Yii::$app->user->id, $lead->emirate, $lead->location));
            }
        } else {
            foreach($prReq as $pr) {
                $salesItems   = array_merge($salesItems, Sale::getMatchWithLead($pr, false, Yii::$app->user->id, $lead->emirate, $lead->location));
                $rentalsItems = array_merge($rentalsItems, Rentals::getMatchWithLead($pr, false, Yii::$app->user->id, $lead->emirate, $lead->location));
            }
        }


        return $this->render('_matchProperties', [
            'salesMatchProperties'   => $salesItems,
            'rentalsMatchProperties' => $rentalsItems
        ]);
    }

    /**
     * render grid panel for current items
     * @return mixed
     */
    public function actionGridPanelCurrent()
    {
        $this->layout = false;

        $model           = new Leads();
        $searchModel     = new LeadsSearch();
        $firstRecord     = $model->getFirstRecordModel();
        $userColumns     = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->reference),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('@app/views/leads/_gridPanel', [
            'flagListing'         => GridPanel::STATUS_CURRENT_LISTING,
            'filteredColumns'     => $filteredColumns,
            'userColumns'         => $userColumns,
            'columnsGrid'         => $columnsGrid,
            'model'               => $firstRecord,
            'urlSaveColumnFilter' => Url::to(['lead/save-column-filter']),
            'usersDataProvider'   => $usersDataProvider,
            'taskManagerDataProvider' => $taskManagerDataProvider,
            'searchModel'             => $searchModel,
            'advancedSearchPath'      => '@app/views/leads/_search'
        ]);
    }

    /**
     * render grid panel for archive items
     * @return mixed
     */
    public function actionGridPanelArchive()
    {
        $this->layout = false;

        $model              = new Leads();
        $leadsArchiveSearch = new LeadsSearch();
        $firstRecord        = $model->getFirstRecordModel();
        $userColumns        = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns    = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->reference),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('@app/views/leads/_gridPanel', [
            'flagListing'         => GridPanel::STATUS_ARCHIVE_LISTING,
            'filteredColumns'     => $filteredColumns,
            'userColumns'         => $userColumns,
            'columnsGrid'         => $columnsGrid,
            'model'               => $firstRecord,
            'urlSaveColumnFilter' => Url::to(['lead/save-column-filter']),
            'usersDataProvider'   => $usersDataProvider,
            'taskManagerDataProvider' => $taskManagerDataProvider,
            'searchModel'             => $leadsArchiveSearch,
            'advancedSearchPath'      => '@app/views/leads/_search'
        ]);
    }

    /**
     * unarchive selected items
     */
    public function actionUnarchive()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $items    = JSON::decode($postData['items']);

        $queryParams              = Yii::$app->request->queryParams;
        $model                    = new Leads();
        $firstRecord              = $model->getFirstRecordModel();
        $searchModel              = new LeadsSearch();
        $leadViewing              = new LeadViewing();
        $dataProvider             = $searchModel->search(Yii::$app->request->queryParams);
        $leadsArchiveSearch       = new LeadsSearch();
        $leadsArchiveDataProvider = $leadsArchiveSearch->search(Yii::$app->request->queryParams, Leads::STATUS_CLOSED);
        $leadViewing->lead_id     = $firstRecord->id;

        $propertyRequirementDataProvider = new ActiveDataProvider([
            'query'      => PropertyRequirement::find()->where(['lead_id' => $firstRecord->id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $userColumns     = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));
        $emirates                 = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation              = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $locationsCurrent         = Locations::getByParentId($model->emirate);
        $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent      = [];
        $locationsAll             = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $propReqSearch            = new PropertyRequirementSearch();
        $propertyReqGridProvider  = $propReqSearch->search(Yii::$app->request->queryParams);
        $locationsSearch          = ArrayHelper::map(Locations::getByParentId($queryParams['PropertyRequirementSearch']['emirate']), 'id', 'name');
        $idsLocation              = (!empty($queryParams['PropertyRequirementSearch']['location'])) ? [$queryParams['PropertyRequirementSearch']['location']] : [];
        $subLocationsSearch       = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');
        $emiratesDropDown         = ArrayHelper::map($emirates, 'id', 'name');

        if ($request->isPost) {
            foreach($items as $i) {
                $rec         = Leads::findOne($i);
                $rec->status = Leads::STATUS_OPEN;
                $rec->save(false);
            }
        }

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($firstRecord->reference),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $prReq           = PropertyRequirement::getForLead($firstRecord->id);
        $salesExactMatch = $rentalsExactMatch =[];

        foreach($prReq as $pr) {
            $salesExactMatch = array_merge($salesExactMatch, Sale::getMatchWithLead($pr, true, Yii::$app->user->id, $firstRecord->emirate, $firstRecord->location));
            $rentalsExactMatch = array_merge($rentalsExactMatch, Rentals::getMatchWithLead($pr, true, Yii::$app->user->id, $firstRecord->emirate, $firstRecord->location));
        }

        return $this->render('index', [
            'searchModel'                     => $searchModel,
            'dataProvider'                    => $dataProvider,
            'firstRecord'                     => $firstRecord,
            'model'                           => $firstRecord,
            'attributesDetailView'            => $firstRecord->getAttributesForDetailView(),
            'leadViewing'                     => $leadViewing,
            'propertyRequirementDataProvider' => $propertyRequirementDataProvider,
            'leadsArchiveSearch'              => $leadsArchiveSearch,
            'leadsArchiveDataProvider'        => $leadsArchiveDataProvider,
            'existRecord'                     => (new ExistRecordModel())->getExistRecordModel('app\models\Leads'),
            'columnsGrid'                     => $columnsGrid,
            'userColumns'                     => $userColumns,
            'filteredColumns'                 => $filteredColumns,
            'usersDataProvider'               => $usersDataProvider,
            'taskManagerDataProvider'         => $taskManagerDataProvider,
            'emirates'                        => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                       => $locations,
            'subLocations'                    => $subLocation,
            'locationsAll'                    => $locationsAll,
            'locationsCurrent'                => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'             => $subLocationsCurrent,
            'salesMatchProperties'            => $salesExactMatch,
            'rentalsMatchProperties'          => $rentalsExactMatch,
            'source'                          => ArrayHelper::map(ContactSource::find()->all(), 'id', 'source'),
            'propertyReqGridProvider'         => $propertyReqGridProvider,
            'propReqSearch'                   => $propReqSearch,
            'locationsSearch'                 => $locationsSearch,
            'subLocationsSearch'              => $subLocationsSearch,
            'emiratesDropDown'                => $emiratesDropDown,
            'isEmptyPropReqSearch'            => empty($queryParams['PropertyRequirementSearch'])
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
            GridColumns::removeForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id);
            foreach($postData['columnChecked'] as $v) {
                GridColumns::add($v, GridColumns::TYPE_LEAD, Yii::$app->user->id);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Leads model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $queryParams              = Yii::$app->request->queryParams;
        $model                    = (new Leads())->getFirstRecordModel($id);
        $leadViewing              = new LeadViewing();
        $searchModel              = new LeadsSearch();
        $dataProvider             = $searchModel->search(Yii::$app->request->queryParams);
        $leadsArchiveSearch       = new LeadsSearch();
        $leadsArchiveDataProvider = $leadsArchiveSearch->search(Yii::$app->request->queryParams, Leads::STATUS_CLOSED);

        $propertyRequirementDataProvider = new ActiveDataProvider([
            'query'      => PropertyRequirement::find()->where(['lead_id' => $model->id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        /*$archive = new ArchiveHistory($lead);
        $modelHistory = $archive->outputArchiveStatus();*/
        $userColumns     = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));
        $emirates                 = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation              = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $locationsCurrent         = Locations::getByParentId($model->emirate);
        $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent      = [];
        $locationsAll             = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $propReqSearch            = new PropertyRequirementSearch();
        $propertyReqGridProvider  = $propReqSearch->search(Yii::$app->request->queryParams);
        $locationsSearch          = ArrayHelper::map(Locations::getByParentId($queryParams['PropertyRequirementSearch']['emirate']), 'id', 'name');
        $idsLocation              = (!empty($queryParams['PropertyRequirementSearch']['location'])) ? [$queryParams['PropertyRequirementSearch']['location']] : [];
        $subLocationsSearch       = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');
        $emiratesDropDown         = ArrayHelper::map($emirates, 'id', 'name');

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->reference),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $prReq           = PropertyRequirement::getForLead($model->id);
        $salesExactMatch = $rentalsExactMatch =[];

        foreach($prReq as $pr) {
            $salesExactMatch = array_merge($salesExactMatch, Sale::getMatchWithLead($pr, true, Yii::$app->user->id, $model->emirate, $model->location));
            $rentalsExactMatch = array_merge($rentalsExactMatch, Rentals::getMatchWithLead($pr, true, Yii::$app->user->id, $model->emirate, $model->location));
        }

        return $this->render('index', [
            'searchModel'                     => $searchModel,
            'dataProvider'                    => $dataProvider,
            'model'                           => $model,
            'firstRecord'                     => $model,
            'attributesDetailView'            => $model->getAttributesForDetailView(),
            'leadViewing'                     => $leadViewing,
            'propertyRequirementDataProvider' => $propertyRequirementDataProvider,
            'leadsArchiveSearch'              => $leadsArchiveSearch,
            'leadsArchiveDataProvider'        => $leadsArchiveDataProvider,
            'existRecord'                     => (new ExistRecordModel())->getExistRecordModel('app\models\Leads'),
            'historyProperty'                 => (new ArchiveHistory($model))->outputArchiveStatus(),
            'columnsGrid'                     => $columnsGrid,
            'userColumns'                     => $userColumns,
            'filteredColumns'                 => $filteredColumns,
            'usersDataProvider'               => $usersDataProvider,
            'taskManagerDataProvider'         => $taskManagerDataProvider,
            'emirates'                        => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                       => $locations,
            'subLocations'                    => $subLocation,
            'locationsAll'                    => $locationsAll,
            'locationsCurrent'                => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'             => $subLocationsCurrent,
            'salesMatchProperties'            => $salesExactMatch,
            'rentalsMatchProperties'          => $rentalsExactMatch,
            'source'                          => ArrayHelper::map(ContactSource::find()->all(), 'id', 'source'),
            'propertyReqGridProvider'         => $propertyReqGridProvider,
            'propReqSearch'                   => $propReqSearch,
            'locationsSearch'                 => $locationsSearch,
            'subLocationsSearch'              => $subLocationsSearch,
            'emiratesDropDown'                => $emiratesDropDown,
            'isEmptyPropReqSearch'            => empty($queryParams['PropertyRequirementSearch'])
        ]);
    }

    public function actionSlug($slug)
    {
        $queryParams              = Yii::$app->request->queryParams;
        $model                    = Leads::getBySlug($slug);
        $leadViewing              = new LeadViewing();
        $searchModel              = new LeadsSearch();
        $dataProvider             = $searchModel->search(Yii::$app->request->queryParams);
        $leadsArchiveSearch       = new LeadsSearch();
        $leadsArchiveDataProvider = $leadsArchiveSearch->search(Yii::$app->request->queryParams, Leads::STATUS_CLOSED);

        $propertyRequirementDataProvider = new ActiveDataProvider([
            'query'      => PropertyRequirement::find()->where(['lead_id' => $model->id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        /*$archive = new ArchiveHistory($lead);
        $modelHistory = $archive->outputArchiveStatus();*/
        $userColumns     = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));
        $emirates                 = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation              = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $locationsCurrent         = Locations::getByParentId($model->emirate);
        $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent      = [];
        $locationsAll             = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $propReqSearch            = new PropertyRequirementSearch();
        $propertyReqGridProvider  = $propReqSearch->search(Yii::$app->request->queryParams);
        $locationsSearch          = ArrayHelper::map(Locations::getByParentId($queryParams['PropertyRequirementSearch']['emirate']), 'id', 'name');
        $idsLocation              = (!empty($queryParams['PropertyRequirementSearch']['location'])) ? [$queryParams['PropertyRequirementSearch']['location']] : [];
        $subLocationsSearch       = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');
        $emiratesDropDown         = ArrayHelper::map($emirates, 'id', 'name');

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->reference),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $prReq           = PropertyRequirement::getForLead($model->id);
        $salesExactMatch = $rentalsExactMatch =[];

        foreach($prReq as $pr) {
            $salesExactMatch = array_merge($salesExactMatch, Sale::getMatchWithLead($pr, true, Yii::$app->user->id, $model->emirate, $model->location));
            $rentalsExactMatch = array_merge($rentalsExactMatch, Rentals::getMatchWithLead($pr, true, Yii::$app->user->id, $model->emirate, $model->location));
        }

        return $this->render('index', [
            'searchModel'                     => $searchModel,
            'dataProvider'                    => $dataProvider,
            'model'                           => $model,
            'firstRecord'                     => $model,
            'attributesDetailView'            => $model->getAttributesForDetailView(),
            'leadViewing'                     => $leadViewing,
            'propertyRequirementDataProvider' => $propertyRequirementDataProvider,
            'leadsArchiveSearch'              => $leadsArchiveSearch,
            'leadsArchiveDataProvider'        => $leadsArchiveDataProvider,
            'existRecord'                     => (new ExistRecordModel())->getExistRecordModel('app\models\Leads'),
            'columnsGrid'                     => $columnsGrid,
            'userColumns'                     => $userColumns,
            'filteredColumns'                 => $filteredColumns,
            'usersDataProvider'               => $usersDataProvider,
            'taskManagerDataProvider'         => $taskManagerDataProvider,
            'emirates'                        => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                       => $locations,
            'subLocations'                    => $subLocation,
            'locationsAll'                    => $locationsAll,
            'locationsCurrent'                => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'             => $subLocationsCurrent,
            'salesMatchProperties'            => $salesExactMatch,
            'rentalsMatchProperties'          => $rentalsExactMatch,
            'source'                          => ArrayHelper::map(ContactSource::find()->all(), 'id', 'source'),
            'propertyReqGridProvider'         => $propertyReqGridProvider,
            'propReqSearch'                   => $propReqSearch,
            'locationsSearch'                 => $locationsSearch,
            'subLocationsSearch'              => $subLocationsSearch,
            'emiratesDropDown'                => $emiratesDropDown,
            'isEmptyPropReqSearch'            => empty($queryParams['PropertyRequirementSearch'])
        ]);
    }

    /**
     * Creates a new Leads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $queryParams               = Yii::$app->request->queryParams;
        $model                     = new Leads();
        $searchModel               = new LeadsSearch();
        $leadViewing               = new LeadViewing();
        $dataProvider              = $searchModel->search(Yii::$app->request->queryParams);
        $model->created_by_user_id = Yii::$app->user->id;
        $model->updated_time       = time();
        $companyId                 = Company::getCompanyIdBySubdomain();
        $leadsArchiveSearch        = new LeadsSearch();
        $leadsArchiveDataProvider  = $leadsArchiveSearch->search(Yii::$app->request->queryParams, Leads::STATUS_CLOSED);
        $propertyRequirementDataProvider = null;

        if ($companyId == 'main') {
            $model->company_id = 0;
            $agents            = User::find()->where(['role' => 'Agent'])->all();
        } else {
            $model->company_id = $companyId;
            $agents            = User::find()->where([
                'role'       => 'Agent',
                'company_id' => $model->company_id
            ])->all();
        }

        if ($model->load(Yii::$app->request->post())
            && $model->validate()
            && $model->save()
        ) {
            $model->reference = (new Ref())->getRefCompany($model);

            $propertyRequirement  = new PropertyRequirement();
            $propertyRequirement->load(Yii::$app->request->post());
            $propertyRequirement->lead_id = $model->id;
            if ($propertyRequirement->validate() && $propertyRequirement->save());

            if (!is_numeric($model->enquiry_time)) {
                $time = DateTime::createFromFormat("Y-m-d H:i", $model->enquiry_time);
                if ($time) {
                    $model->enquiry_time = $time->getTimestamp();
                }
                    
            }

            $companyId = Company::getCompanyIdBySubdomain();

            if ($companyId == 'main') {
                $model->company_id = 0;
            } else {
                $model->company_id = $companyId;
            }

            $model->created_at = time();
            $model->save();

            Yii::$app->session->setFlash('success', Yii::t('app', 'Lead was successfully created'));

            if (Leads::find()->where(['id' => $model->id])->exists())
                return $this->redirect(['view', 'id' => $model->id]);
            else
                return $this->redirect(['index']);
        }

        $userColumns     = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username'));
        $emirates                 = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation              = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $locationsCurrent         = Locations::getByParentId($model->emirate);
        $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent      = [];
        $locationsAll             = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $propReqSearch            = new PropertyRequirementSearch();
        $propertyReqGridProvider  = $propReqSearch->search(Yii::$app->request->queryParams);
        $locationsSearch          = ArrayHelper::map(Locations::getByParentId($queryParams['PropertyRequirementSearch']['emirate']), 'id', 'name');
        $idsLocation              = (!empty($queryParams['PropertyRequirementSearch']['location'])) ? [$queryParams['PropertyRequirementSearch']['location']] : [];
        $subLocationsSearch       = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');
        $emiratesDropDown         = ArrayHelper::map($emirates, 'id', 'name');

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => [],
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('index', [
            'searchModel'                     => $searchModel,
            'dataProvider'                    => $dataProvider,
            'firstRecord'                     => $model,
            'model'                           => $model,
            'attributesDetailView'            => $model->getAttributesForDetailView(),
            'leadViewing'                     => $leadViewing,
            'propertyRequirementDataProvider' => $propertyRequirementDataProvider,
            'leadsArchiveSearch'              => $leadsArchiveSearch,
            'leadsArchiveDataProvider'        => $leadsArchiveDataProvider,
            'columnsGrid'                     => $columnsGrid,
            'userColumns'                     => $userColumns,
            'filteredColumns'                 => $filteredColumns,
            'usersDataProvider'               => $usersDataProvider,
            'taskManagerDataProvider'         => $taskManagerDataProvider,
            'emirates'                        => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                       => $locations,
            'subLocations'                    => $subLocation,
            'locationsAll'                    => $locationsAll,
            'locationsCurrent'                => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'             => $subLocationsCurrent,
            'companyAgents'                   => $agents,
            'source'                          => ArrayHelper::map(ContactSource::find()->all(), 'id', 'source'),
            'propertyReqGridProvider'         => $propertyReqGridProvider,
            'propReqSearch'                   => $propReqSearch,
            'locationsSearch'                 => $locationsSearch,
            'subLocationsSearch'              => $subLocationsSearch,
            'emiratesDropDown'                => $emiratesDropDown,
            'isEmptyPropReqSearch'            => empty($queryParams['PropertyRequirementSearch'])
        ]);
    }

    /**
     * Updates an existing Leads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $queryParams              = Yii::$app->request->queryParams;
        $model                    = (new Leads())->getFirstRecordModel($id);
        $leadViewing              = new LeadViewing();
        $searchModel              = new LeadsSearch();
        $dataProvider             = $searchModel->search(Yii::$app->request->queryParams);
        $leadsArchiveSearch       = new LeadsSearch();
        $leadsArchiveDataProvider = $leadsArchiveSearch->search(Yii::$app->request->queryParams, Leads::STATUS_CLOSED);
        $data                     = $model->attributes;
        $oldModel                 = new Leads();
        $oldModel->setAttributes($data);

        $propertyRequirementDataProvider = new ActiveDataProvider([
            'query'      => PropertyRequirement::find()->where(['lead_id' => $model->id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main') {

            $model->company_id = 0;
            $agents            = User::find()->where(['role' => 'Agent'])->all();

        } else {

            $model->company_id = $companyId;
            $agents            = User::find()->where([
                'role'       => 'Agent',
                'company_id' => $model->company_id
            ])->all();
        }

        $userColumns     = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_LEAD, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Leads::getColumns(ArrayHelper::map(User::find()->where(['company_id' => $companyId])->asArray()->all(), 'id', 'username'));
        $emirates                 = Locations::getByType(Locations::TYPE_EMIRATE);
        $locations                = JSON::encode(ArrayHelper::map($emirates, 'id', 'children'));
        $subLocation              = JSON::encode(ArrayHelper::map(Locations::getByType(Locations::TYPE_LOCATION), 'id', 'children'));
        $locationsCurrent         = Locations::getByParentId($model->emirate);
        $subLocationsTemp         = ArrayHelper::map($locationsCurrent, 'id', 'children');
        $subLocationsCurrent      = [];
        $locationsAll             = Locations::getAllLocations();

        foreach($subLocationsTemp as $key => $value) {
            $subLocationsCurrent += ArrayHelper::map($value, 'id', 'name');
        }

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $propReqSearch            = new PropertyRequirementSearch();
        $propertyReqGridProvider  = $propReqSearch->search(Yii::$app->request->queryParams);
        $locationsSearch          = ArrayHelper::map(Locations::getByParentId($queryParams['PropertyRequirementSearch']['emirate']), 'id', 'name');
        $idsLocation              = (!empty($queryParams['PropertyRequirementSearch']['location'])) ? [$queryParams['PropertyRequirementSearch']['location']] : [];
        $subLocationsSearch       = ArrayHelper::map(Locations::getByParentIdInRange($idsLocation), 'id', 'name');
        $emiratesDropDown         = ArrayHelper::map($emirates, 'id', 'name');

        $usersSearchModel  = new UserSearch();
        $usersDataProvider = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;

        $taskManagerDataProvider = new ArrayDataProvider([
            'allModels' => TaskManager::getByListingRef($model->reference),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $prReq           = PropertyRequirement::getForLead($model->id);
        $salesExactMatch = $rentalsExactMatch =[];

        foreach($prReq as $pr) {
            $salesExactMatch = array_merge($salesExactMatch, Sale::getMatchWithLead($pr, true, Yii::$app->user->id, $model->emirate, $model->location));
            $rentalsExactMatch = array_merge($rentalsExactMatch, Rentals::getMatchWithLead($pr, true, Yii::$app->user->id, $model->emirate, $model->location));
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updated_time = time();
            if (!is_numeric($model->enquiry_time)) {
                $time = DateTime::createFromFormat("Y-m-d H:i", $model->enquiry_time);
                if ($time) {
                    $model->enquiry_time = $time->getTimestamp();
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Lead was successfully updated'));

                if (Leads::find()->where(['id' => $model->id])->exists()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('index', [
            'searchModel'                     => $searchModel,
            'dataProvider'                    => $dataProvider,
            'model'                           => $model,
            'firstRecord'                     => $model,
            'attributesDetailView'            => $model->getAttributesForDetailView(),
            'companyAgents'                   => $agents,
            'leadViewing'                     => $leadViewing,
            'propertyRequirementDataProvider' => $propertyRequirementDataProvider,
            'leadsArchiveSearch'              => $leadsArchiveSearch,
            'leadsArchiveDataProvider'        => $leadsArchiveDataProvider,
            'columnsGrid'                     => $columnsGrid,
            'userColumns'                     => $userColumns,
            'filteredColumns'                 => $filteredColumns,
            'usersDataProvider'               => $usersDataProvider,
            'historyProperty'                 => (new ArchiveHistory($model))->outputArchiveStatus(),
            'taskManagerDataProvider'         => $taskManagerDataProvider,
            'emirates'                        => ArrayHelper::map($emirates, 'id', 'name'),
            'locations'                       => $locations,
            'subLocations'                    => $subLocation,
            'locationsAll'                    => $locationsAll,
            'locationsCurrent'                => ArrayHelper::map($locationsCurrent, 'id', 'name'),
            'subLocationsCurrent'             => $subLocationsCurrent,
            'salesMatchProperties'            => $salesExactMatch,
            'rentalsMatchProperties'          => $rentalsExactMatch,
            'source'                          => ArrayHelper::map(ContactSource::find()->all(), 'id', 'source'),
            'propertyReqGridProvider'         => $propertyReqGridProvider,
            'propReqSearch'                   => $propReqSearch,
            'locationsSearch'                 => $locationsSearch,
            'subLocationsSearch'              => $subLocationsSearch,
            'emiratesDropDown'                => $emiratesDropDown,
            'isEmptyPropReqSearch'            => empty($queryParams['PropertyRequirementSearch'])
        ]);
    }

    /**
     * Deletes an existing Leads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Leads::STATUS_CLOSED;
        $model->save(false);

        return $this->redirect(['index']);
    }

    public function actionActivity($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $lead = $this->findModel($id);
        if ($lead->activity == Leads::ACTIVITY_ACTIVE) {
            $lead->activity = Leads::ACTIVITY_NOT_ACTIVE;
            $leadActivityName = 'not_active';
        } else {
            $lead->activity = Leads::ACTIVITY_ACTIVE;
            $leadActivityName = 'active';
        }
        if ($lead->update())
            return ['result' => 'success', 'activity' => $leadActivityName];
        else
            return ['result' => 'error'];
    }

    public function actionSocialMediaContactsBlock()
    {
        return $this->renderPartial('_social_media_contact_input');
    }

    /**
     * Finds the Leads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Leads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Leads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
