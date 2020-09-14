<?php

namespace app\controllers;

use app\models\Contacts;
use app\models\Leads;
use app\models\Reminder;
use app\models\RentalsSearch;
use app\models\SaleSearch;
use app\models\ContactsSearch as RealContactsSearch;
use app\models\UserSearch;
use app\modules\lead\models\LeadsSearch;
use DateTime;
use Yii;
use app\models\TaskManager;
use app\models\TaskManagerSearch;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Sale;
use app\models\Rentals;
use app\models\Company;
use app\classes\existrecord\ExistRecordModel;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * TaskManagerController implements the CRUD actions for TaskManager model.
 */
class TaskManagerController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['taskmanagerView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['create'],
                        'permissions' => ['taskmanagerCreate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['update'],
                        'permissions' => ['taskmanagerUpdate'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['view'],
                        'permissions' => ['taskmanagerView'],
                        'roles'       => ['Owner']
                    ],
                    [
                        'allow'       => true,
                        'actions'     => ['delete'],
                        'permissions' => ['taskmanagerDelete'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all TaskManager models.
     * @return mixed
     */
    public function actionIndex()
    {

        $model        = new TaskManager();
        $searchModel  = new TaskManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $firstRecord  = $model->getFirstRecordModel();       
        $companyId    = Company::getCompanyIdBySubdomain();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->owner_id   = Yii::$app->user->id;
            $deadline = DateTime::createFromFormat("Y-m-d H:i", $model->deadline);
            if ($deadline) {
                $model->deadline = $deadline->getTimestamp();
            }
            if ($model->save()) {
                if ($companyId == '') {
                    $model->company_id = 0;
                } else {
                    $model->company_id = $companyId;
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $usersSearchModel     = new UserSearch();
        $usersDataProvider    = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 4;
        $salesSearchModel     = new SaleSearch();
        $salesDataProvider    = $salesSearchModel->search(Yii::$app->request->queryParams);
        $salesDataProvider->pagination->pageSize = 4;
        $rentalsSearchModel   = new RentalsSearch();
        $rentalsDataProvider  = $rentalsSearchModel->search(Yii::$app->request->queryParams);
        $rentalsDataProvider->pagination->pageSize = 4;
        $leadsSearchModel     = new LeadsSearch();
        $leadsDataProvider    = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider->pagination->pageSize = 4;
        $contactsSearchModel  = new RealContactsSearch();
        $contactsDataProvider = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 4;

        return $this->render('index', [
            'existRecord'          => (new ExistRecordModel())->getExistRecordModel('app\models\TaskManager'),
            'firstRecord'          => $firstRecord,
            'searchModel'          => $searchModel,
            'dataProvider'         => $dataProvider,
            'model'                => $model->getFirstRecordModel(),
            'usersSearchModel'     => $usersSearchModel,
            'usersDataProvider'    => $usersDataProvider,
            'salesSearchModel'     => $salesSearchModel,
            'salesDataProvider'    => $salesDataProvider,
            'rentalsSearchModel'   => $rentalsSearchModel,
            'rentalsDataProvider'  => $rentalsDataProvider,
            'leadsSearchModel'     => $leadsSearchModel,
            'leadsDataProvider'    => $leadsDataProvider,
            'contactsSearchModel'  => $contactsSearchModel,
            'contactsDataProvider' => $contactsDataProvider,
            'disabled'             => true
        ]);

    }

    /**
     * Displays a single TaskManager model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $reminder = Reminder::findOne(['key_id' => $model->id, 'key' => Reminder::KEY_TYPE_TASKMANAGER, 'user_id' => Yii::$app->user->id]);

        $model        = new TaskManager();
        $searchModel  = new TaskManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $firstRecord  = $model->getFirstRecordModel($id);       
        $companyId    = Company::getCompanyIdBySubdomain();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->owner_id   = Yii::$app->user->id;
            $deadline = DateTime::createFromFormat("Y-m-d H:i", $model->deadline);
            if ($deadline) {
                $model->deadline = $deadline->getTimestamp();
            }
            if ($model->save()) {
                if ($companyId == '') {
                    $model->company_id = 0;
                } else {
                    $model->company_id = $companyId;
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $usersSearchModel     = new UserSearch();
        $usersDataProvider    = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 4;
        $salesSearchModel     = new SaleSearch();
        $salesDataProvider    = $salesSearchModel->search(Yii::$app->request->queryParams);
        $salesDataProvider->pagination->pageSize = 4;
        $rentalsSearchModel   = new RentalsSearch();
        $rentalsDataProvider  = $rentalsSearchModel->search(Yii::$app->request->queryParams);
        $rentalsDataProvider->pagination->pageSize = 4;
        $leadsSearchModel     = new LeadsSearch();
        $leadsDataProvider    = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider->pagination->pageSize = 4;
        $contactsSearchModel  = new RealContactsSearch();
        $contactsDataProvider = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 4;

        return $this->render('index', [
            'existRecord'          => (new ExistRecordModel())->getExistRecordModel('app\models\TaskManager'),
            'firstRecord'          => $firstRecord,
            'searchModel'          => $searchModel,
            'dataProvider'         => $dataProvider,
            'model'                => $model->getFirstRecordModel($id),
            'usersSearchModel'     => $usersSearchModel,
            'usersDataProvider'    => $usersDataProvider,
            'salesSearchModel'     => $salesSearchModel,
            'salesDataProvider'    => $salesDataProvider,
            'rentalsSearchModel'   => $rentalsSearchModel,
            'rentalsDataProvider'  => $rentalsDataProvider,
            'leadsSearchModel'     => $leadsSearchModel,
            'leadsDataProvider'    => $leadsDataProvider,
            'contactsSearchModel'  => $contactsSearchModel,
            'contactsDataProvider' => $contactsDataProvider,
            'reminder'             => $reminder,
            'disabled'             => true
        ]);
    }

    /**
     * Creates a new TaskManager model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model        = new TaskManager();
        $searchModel  = new TaskManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $firstRecord  = $model->getFirstRecordModel();       
        $companyId    = Company::getCompanyIdBySubdomain();

        if ($model->load(Yii::$app->request->post())) {
            $externalForm      = Yii::$app->request->post('externalForm');
            $model->created_at = time();
            $model->owner_id   = Yii::$app->user->id;
            $deadline = DateTime::createFromFormat("Y-m-d H:i", $model->deadline);
            if ($deadline) {
                $model->deadline = $deadline->getTimestamp();
            }
            if ($model->save()) {
                if ($companyId == '') {
                    $model->company_id = 0;
                } else {
                    $model->company_id = $companyId;
                }
                $model->save();

                if ($externalForm) {
                    Yii::$app->response->format = Response::FORMAT_JSON;

                    return ['result' => 'success'];
                } else {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        $usersSearchModel     = new UserSearch();
        $usersDataProvider    = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 4;
        $salesSearchModel     = new SaleSearch();
        $salesDataProvider    = $salesSearchModel->search(Yii::$app->request->queryParams);
        $salesDataProvider->pagination->pageSize = 4;
        $rentalsSearchModel   = new RentalsSearch();
        $rentalsDataProvider  = $rentalsSearchModel->search(Yii::$app->request->queryParams);
        $rentalsDataProvider->pagination->pageSize = 4;
        $leadsSearchModel     = new LeadsSearch();
        $leadsDataProvider    = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider->pagination->pageSize = 4;
        $contactsSearchModel  = new RealContactsSearch();
        $contactsDataProvider = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 4;

        return $this->render('index', [
            'existRecord'          => (new ExistRecordModel())->getExistRecordModel('app\models\TaskManager'),
            'firstRecord'          => $firstRecord,
            'searchModel'          => $searchModel,
            'dataProvider'         => $dataProvider,
            'model'                => $model,
            'usersSearchModel'     => $usersSearchModel,
            'usersDataProvider'    => $usersDataProvider,
            'salesSearchModel'     => $salesSearchModel,
            'salesDataProvider'    => $salesDataProvider,
            'rentalsSearchModel'   => $rentalsSearchModel,
            'rentalsDataProvider'  => $rentalsDataProvider,
            'leadsSearchModel'     => $leadsSearchModel,
            'leadsDataProvider'    => $leadsDataProvider,
            'contactsSearchModel'  => $contactsSearchModel,
            'contactsDataProvider' => $contactsDataProvider,
            'disabled'             => false
        ]);
    }

    /**
     * Updates an existing TaskManager model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model        = $this->findModel($id);
        $reminder = Reminder::findOne(['key_id' => $model->id, 'key' => Reminder::KEY_TYPE_TASKMANAGER, 'user_id' => Yii::$app->user->id]);
        $searchModel  = new TaskManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $firstRecord  = $model->getFirstRecordModel($id);       
        $companyId    = Company::getCompanyIdBySubdomain();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                if ($companyId == '') {
                    $model->company_id = 0;
                } else {
                    $model->company_id = $companyId;
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $usersSearchModel     = new UserSearch();
        $usersDataProvider    = $usersSearchModel->search(Yii::$app->request->queryParams);
        $usersDataProvider->pagination->pageSize = 4;
        $salesSearchModel     = new SaleSearch();
        $salesDataProvider    = $salesSearchModel->search(Yii::$app->request->queryParams);
        $salesDataProvider->pagination->pageSize = 4;
        $rentalsSearchModel   = new RentalsSearch();
        $rentalsDataProvider  = $rentalsSearchModel->search(Yii::$app->request->queryParams);
        $rentalsDataProvider->pagination->pageSize = 4;
        $leadsSearchModel     = new LeadsSearch();
        $leadsDataProvider    = $leadsSearchModel->search(Yii::$app->request->queryParams);
        $leadsDataProvider->pagination->pageSize = 4;
        $contactsSearchModel  = new RealContactsSearch();
        $contactsDataProvider = $contactsSearchModel->search(Yii::$app->request->queryParams);
        $contactsDataProvider->pagination->pageSize = 4;

        return $this->render('index', [
            'existRecord'          => (new ExistRecordModel())->getExistRecordModel('app\models\TaskManager'),
            'firstRecord'          => $firstRecord,
            'searchModel'          => $searchModel,
            'dataProvider'         => $dataProvider,
            'model'                => $model,
            'usersSearchModel'     => $usersSearchModel,
            'usersDataProvider'    => $usersDataProvider,
            'salesSearchModel'     => $salesSearchModel,
            'salesDataProvider'    => $salesDataProvider,
            'rentalsSearchModel'   => $rentalsSearchModel,
            'rentalsDataProvider'  => $rentalsDataProvider,
            'leadsSearchModel'     => $leadsSearchModel,
            'leadsDataProvider'    => $leadsDataProvider,
            'contactsSearchModel'  => $contactsSearchModel,
            'contactsDataProvider' => $contactsDataProvider,
            'reminder'             => $reminder,
            'disabled'             => false
        ]);
    }

    /**
     * Deletes an existing TaskManager model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['result' => 'success'];
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionGetSaleItem()
    {
        $saleIds = Yii::$app->request->post('saleIds');
        $saleIds = json_decode($saleIds, true);
        $sales = Sale::findAll(['id' => $saleIds]);
        return $this->renderPartial('_choosed_sale_item', [
            'sales' => $sales
        ]);
    }

    public function actionGetRentalItem()
    {
        $rentalIds = Yii::$app->request->post('rentalIds');
        $rentalIds = json_decode($rentalIds, true);
        $rentals = Rentals::findAll(['id' => $rentalIds]);
        return $this->renderPartial('_choosed_rental_item', [
            'rentals' => $rentals
        ]);
    }

    public function actionGetResponsibleItem()
    {
        $responsibleIds = Yii::$app->request->post('responsiblesIds');
        $responsibleIds = json_decode($responsibleIds, true);
        $responsibles = User::findAll(['id' => $responsibleIds]);
        return $this->renderPartial('_choosed_responsible_item', [
            'responsibles' => $responsibles
        ]);
    }

    public function actionGetLeadItem()
    {
        $leadIds = Yii::$app->request->post('leadIds');
        $leadIds = json_decode($leadIds, true);
        $leads = Leads::findAll(['id' => $leadIds]);
        return $this->renderPartial('_choosed_lead_item', [
            'leads' => $leads
        ]);
    }

    public function actionGetContactItem()
    {
        $contactsIds = Yii::$app->request->post('contactIds');
        $contactsIds = json_decode($contactsIds, true);
        $contacts = Contacts::findAll(['id' => $contactsIds]);
        return $this->renderPartial('_choosed_contact_item', [
            'contacts' => $contacts
        ]);
    }

    /**
     * Finds the TaskManager model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskManager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskManager::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
