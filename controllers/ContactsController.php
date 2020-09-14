<?php

namespace app\controllers;

use app\classes\GridPanel;
use app\models\admin\dataselect\ContactSource;
use app\models\admin\dataselect\Nationalities;
use app\models\admin\dataselect\Religion;
use app\models\admin\dataselect\Title;
use app\models\agent\Agent;
use app\models\Document;
use app\models\GridColumns;
use app\models\Language;
use app\models\LeadsSearch;
use app\models\Note;
use app\models\Rentals;
use app\models\Sale;
use app\models\User;
use app\models\UserSearch;
use app\models\Viewings;
use Yii;
use app\models\Contacts;
use app\models\ContactsSearch;
use app\models\ref\Ref;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use app\models\Company;
use app\components\widgets\ChangeStatusWidget;
use app\models\statusHistory\ArchiveHistory;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * ContactsController implements the CRUD actions for Contacts model.
 */
class ContactsController extends Controller
{
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
                    'searchHandler' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['contactsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['contactsCreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['contactsUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['contactsView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['contactsDelete'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Contacts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Contacts();

        $firstRecord = reset($dataProvider->getModels());

        if ($firstRecord) {
            return $this->actionView($firstRecord->id);
        } else {
            $data = $this->getData($searchModel, $dataProvider, $model, false, false, false, false, true, true, array(), true);

            return $this->render('index', $data);
        }
    }

    /**
     * get contact by ref
     */
    public function actionGetByRef()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $ref      = $postData['ref'];
        $contact  = Contacts::findOne(['ref' => $ref]);

        return $this->asJson($contact);
    }

    /**
     * render grid panel for current items
     * @return mixed
     */
    public function actionGridPanelCurrent()
    {
        $this->layout = false;

        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $firstRecord = reset($dataProvider->getModels());
        $model = ($firstRecord) ? $firstRecord : new Contacts();

        $data = $this->getData($searchModel, $dataProvider, $model, false, false, false, false, true, true, array(), true);

        return $this->render('@app/views/contacts/_gridPanel', array_merge($data, [
            'flagListing'         => GridPanel::STATUS_CURRENT_LISTING,
            'urlSaveColumnFilter' => Url::to(['contact/save-column-filter'])
        ]));
    }

    /**
     * render grid panel for archive items
     * @return mixed
     */
    public function actionGridPanelArchive()
    {
        $this->layout = false;

        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Contacts::STATUS_UNPUBLISHED);
        $firstRecord = reset($dataProvider->getModels());
        $model = ($firstRecord) ? $firstRecord : new Contacts();

        $data = $this->getData($searchModel, $dataProvider, $model, false, false, false, false, true, true, array(), true);

        return $this->render('@app/views/contacts/_gridPanel', array_merge($data, [
            'flagListing'         => GridPanel::STATUS_ARCHIVE_LISTING,
            'urlSaveColumnFilter' => Url::to(['contact/save-column-filter'])
        ]));
    }

    /**
     * unarchive selected items
     */
    public function actionUnarchive()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();
        $items    = JSON::decode($postData['items']);

        if ($request->isPost) {
            foreach($items as $i) {
                $rec             = Contacts::findOne($i);
                $rec->status     = Contacts::STATUS_PUBLISHED;
                $rec->save();
            }
        }

        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $firstRecord = reset($dataProvider->getModels());
        $model = ($firstRecord) ? $firstRecord : new Contacts();

        $data = $this->getData($searchModel, $dataProvider, $model, false, false, false, false, true, true, array(), true);

        return $this->render('index', $data);
    }

    /**
     * Save user selected columns for grid
     */
    public function actionSaveColumnFilter()
    {
        $request  = Yii::$app->request;
        $postData = $request->post();

        if ($request->isPost) {
            GridColumns::removeForSection(GridColumns::TYPE_CONTACT, Yii::$app->user->id);
            foreach($postData['columnChecked'] as $v) {
                GridColumns::add($v, GridColumns::TYPE_CONTACT, Yii::$app->user->id);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Contacts archive model.
     * @param $id
     * @return mixed
     */
    public function actionViewArchive($id)
    {
        $searchModel            = new ContactsSearch();
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        $model                  = $this->findModel($id);
        $data                   = $this->getData($searchModel, $dataProvider, $model, false, false, false, false, true, false, array(), true);

        return $this->render('index', $data);
    }

    /**
     * Displays a single Contacts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel            = new ContactsSearch();
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        $model                  = $this->findModel($id);
        $data                   = $this->getData($searchModel, $dataProvider, $model, true, true, false, false, true, false, array(), true);

        return $this->render('index', $data);
    }

    /**
     * Creates a new Contacts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contacts();
        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $additionalData['urlForm'] = Url::to(['create']);

        $model->created_by = Yii::$app->user->id;
        if (Yii::$app->request->isPost
            && $model->load(Yii::$app->request->post())
            && $model->validate()
        ) {
            $companyId = Company::getCompanyIdBySubdomain();

            if ($companyId == 'main') {
                $model->company_id = 0;
            } else {
                $model->company_id = $companyId;
            }

            if ($model->save()) {
                $model->ref  = (new Ref())->getRefCompany($model);
                $model->save();
            }
            Yii::$app->session->setFlash('alerts', 'Contact created');
            $data = $this->getData($searchModel, $dataProvider, $model, true, true, false, false, true, false, $additionalData, true);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $additionalData['urlCancel'] = Url::to(['index']);
            $data = $this->getData($searchModel, $dataProvider, $model, false, false, true, true, false, false, $additionalData, false);
        }

        return $this->render('index', $data);
    }

    /**
     * Updates an existing Contacts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $additionalData['urlForm'] = Url::to(['update', 'id' => $model->id]);

        if ($request->isPost && $model->load($request->post()) && $model->validate()) {
            $model->save();

            Yii::$app->session->setFlash('alerts', 'Contact updated');
            $data = $this->getData($searchModel, $dataProvider, $model, true, true, false, false, true, false, $additionalData, true);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $additionalData['urlCancel'] = Url::to(['view', 'id' => $model->id]);
            $data                        = $this->getData($searchModel, $dataProvider, $model, false, true, true, true, false, false, $additionalData, false);
        }

        return $this->render('index', $data);
    }

    /**
     * Deletes an existing Contacts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Contacts::STATUS_UNPUBLISHED;
        $model->save();

        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $firstRecord = reset($dataProvider->getModels());

        if ($firstRecord) {
            $this->actionView($firstRecord->id);
        } else {
            $this->actionIndex();
        }
    }

    /**
     * Finds the Contacts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contacts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contacts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    protected function getData($searchModel, $dataProvider, $model, $btnEdit, $btnDelete, $btnCancel, $btnSave, $btnAdd, $flagFirstRecord,
                               $additionalData = array(), $disabledFormElement = false)
    {
        $contactsArchiveSearch                   = new ContactsSearch();
        $contactsArchiveDataProvider             = $contactsArchiveSearch->search(Yii::$app->request->queryParams, Contacts::STATUS_UNPUBLISHED);
        $agentUser                               = new Agent();
        $usersSearchModel                        = new UserSearch();
        $usersDataProvider                       = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 5;
        $genderList = array(
            'Other'  => Yii::t('app', 'Other'),
            'Male'   => Yii::t('app', 'Male'),
            'Female' => Yii::t('app', 'Female')
        );
        $nationModel = new Nationalities();
        $religions = ArrayHelper::map(Religion::find()->all(), 'id', 'religions');
        $religionModel = new Religion();
        $sources = ArrayHelper::map(ContactSource::find()->all(), 'id', 'source');
        $contactSourceModel = new ContactSource();
        $contactType = Contacts::$contactType;
        $nationalities = ArrayHelper::map(Nationalities::find()->all(), 'id', 'national');

        $userColumns                             = ArrayHelper::map(GridColumns::getForSection(GridColumns::TYPE_CONTACT, Yii::$app->user->id), 'name', 'name');
        $filteredColumns = $columnsGrid = Contacts::getColumns($dataProvider, $searchModel, $genderList, $nationalities, $nationModel, $religions, $religionModel,
            $sources, $contactSourceModel, $contactType);

        foreach ($columnsGrid as $cK => $cV) {
            if (!in_array($cK, $userColumns)) {
                unset($filteredColumns[$cK]);
            }
        }

        $rentalsForContactDataProvider = new ActiveDataProvider([
            'query' => Rentals::getByLandlord($model->id),
            'pagination' => [
                'pageSize' => 1000,
            ]
        ]);
        $salesForContactDataProvider = new ActiveDataProvider([
            'query' => Sale::getByLandlord($model->id),
            'pagination' => [
                'pageSize' => 1000
            ]
        ]);

        return array_merge($additionalData, [
            'rentalsForContactDataProvider' => $rentalsForContactDataProvider,
            'salesForContactDataProvider' => $salesForContactDataProvider,
            'assignedToUser' => User::findOne($model->assigned_to),
            'usersSearchModel' => $usersSearchModel,
            'usersDataProvider' => $usersDataProvider,
            'contactsArchiveSearch' => $contactsArchiveSearch,
            'contactsArchiveDataProvider' => $contactsArchiveDataProvider,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'noteModel' => new Note(),
            'documentModel' => new Document(),
            'viewingModel' => new Viewings(),
            'nationModel' => $nationModel,
            'religionModel' => $religionModel,
            'contactSourceModel' => $contactSourceModel,
            'titleModel' => new Title(),
            'nationalities' => $nationalities,
            'languages' => ArrayHelper::map(Language::getAll(), 'id', 'name'),
            'titles' => ArrayHelper::map(Title::find()->all(), 'id', 'titles'),
            'religions' => $religions,
            'sources' => $sources,
            'agents' => $agentUser->getAgentUserCompany(),
            'contactType' => $contactType,
            'genderList' => $genderList,
            'btnEdit' => $btnEdit,
            'btnDelete' => $btnDelete,
            'btnCancel' => $btnCancel,
            'btnSave' => $btnSave,
            'btnAdd' => $btnAdd,
            'historyProperty' => (new ArchiveHistory($model))->outputArchiveStatus(),
            'columnsGrid'             => $columnsGrid,
            'userColumns'             => $userColumns,
            'filteredColumns'         => $filteredColumns,
            'disabledFormElement'     => $disabledFormElement
        ]);
    }

    public function actionSearchHandler()
    {
        if (Yii::$app->request->isAjax) {
            $text = trim(Yii::$app->request->post('text'));
            $models = Contacts::searchByName($text);
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ['success' => true, 'models' => $models];
        }
        return null;
    }
}
