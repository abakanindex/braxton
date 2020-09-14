<?php

namespace app\controllers;

use app\components\Notification;
use app\models\RentalsSearch;
use app\models\Sale;
use app\models\SaleSearch;
use app\models\ContactsSearch as RealContactsSearch;
use app\models\TaskManager;
use app\models\TaskManagerSearch;
use app\modules\calendar\models\EventSearch;
use app\modules\lead\models\LeadsSearch;
use app\modules\lead_viewing\LeadViewing;
use app\modules\lead_viewing\models\LeadViewingSearch;
use app\modules\reports\models\ReportsSearch;
use DateTime;
use Yii;
use app\models\Reminder;
use app\models\ReminderSearch;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;

/**
 * RemiderController implements the CRUD actions for Reminder model.
 */
class ReminderController extends Controller
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
                'only'  => ['index'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['myremindersView'],
                        'roles'       => ['Owner']
                    ],
                ],
            ],
        ];
    }

    public function actionModalForm()
    {
        $reminder = new Reminder();
        $reminder->created_at = time();
        return $this->renderAjax('_modal_form', [
            'reminder' => $reminder
        ]);
    }

    public function actionValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Reminder;
        $model->user_id = Yii::$app->user->id;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    /**
     * Lists all Reminder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReminderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reminder model.
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

    /**
     * Creates a new Reminder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Reminder;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $remindAtTime = '';
            if ($model->remind_at_time) {
                $remindAtTime = DateTime::createFromFormat("Y-m-d H:i", $model->remind_at_time);
                if (!(empty($remindAtTime)))
                    $model->remind_at_time = $remindAtTime->getTimestamp();
            }
            if ($model->save()) {
                return [
                    'result' => 'success',
                    'id' => $model->id,
                    'intervalType' => $model->getIntervalType($model->interval_type),
                    'intervalTime' => $model->time,
                    'description' => $model->description,
                    'status' => $model->getStatus(),
                    'notification_time' => $remindAtTime
                ];
            } else return ['result' => 'error'];
        } else
            return ['result' => 'error'];
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Reminder::findOne($id);
        $oldRemindAtTime = $model->remind_at_time;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            var_dump(Yii::$app->request->post());
            $model->user_id = Yii::$app->user->id;
            $remindAtTime = '';
            if ($model->remind_at_time) {
                $remindAtTime = DateTime::createFromFormat("Y-m-d H:i", $model->remind_at_time);
                if (!(empty($remindAtTime)))
                    $model->remind_at_time = $remindAtTime->getTimestamp();
                if ($oldRemindAtTime != $model->remind_at_time)
                    $model->remind_at_time_result = Reminder::REMIND_AT_TIME_WAITING;
            }
            if ($model->update()) {
                return [
                    'result' => 'success',
                    'id' => $model->id,
                    'intervalType' => $model->getIntervalType($model->interval_type),
                    'intervalTime' => $model->time,
                    'description' => $model->description,
                    'status' => $model->getStatus(),
                    'notification_time' => $remindAtTime
                ];
            } else return ['result' => 'error'];
        } else
            return ['result' => 'error'];
    }

    public function actionTableUpdate($id)
    {
        if (Yii::$app->request->post('hasEditable')) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = $this->findModel(Yii::$app->request->post('editableKey'));

            $out = [
                'output' => '',
                'message' => '',
            ];

            $posted = current($_POST[$model->formName()]);
            $post[$model->formName()] = $posted;
            Yii::info('processed post:' . print_r($posted, true));

            if ($model->load($post)) {
                if (!$model->save()) {
                    $out = [
                        'output' => '',
                        'message' => reset($model->firstErrors),
                    ];
                }
                Yii::info('editable returns:' . print_r($out, true));
                return $out;
            }
        }
    }

    public function actionChangeStatus($id, $status)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Reminder::findOne($id);
        $model->status = $status;
        if ($model->update())
            return ['result' => 'success'];
        else
            return ['result' => 'error'];
    }

    /**
     * Deletes an existing Reminder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $reminder = $this->findModel($id);
        $reminderKey = $reminder->key;
        $reminderKeyId = $reminder->key_id;
        if ($reminder->delete()) {
            Notification::deleteAll(['user_id' => Yii::$app->user->id, 'key' => $reminderKey, 'key_id' => $reminderKeyId]);
            return ['result' => 'success', 'id' => $id];
        } else
            return ['result' => 'error'];
    }

    /**
     * Finds the Reminder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reminder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reminder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @param string $key
     * @return string
     */
    public function actionGridviews()
    {
        $key = Yii::$app->getRequest()->getQueryParam('key');
        switch ($key) {
            case Reminder::KEY_TYPE_SALE:
                $searchModel = new SaleSearch();
                $view = 'sales';
                break;
            case Reminder::KEY_TYPE_RENTALS:
                $searchModel = new RentalsSearch();
                $view = 'rentals';
                break;
            case Reminder::KEY_TYPE_CONTACTS:
                $searchModel = new RealContactsSearch();
                $view = 'contacts';
                break;
            case Reminder::KEY_TYPE_LEAD:
                $searchModel = new LeadsSearch();
                $view = 'leads';
                break;
            case Reminder::KEY_TYPE_EVENT:
                $searchModel = new EventSearch();
                $view = 'events';
                break;
            case Reminder::KEY_TYPE_TASKMANAGER:
                $searchModel = new TaskManagerSearch();
                $view = 'tasks';
                break;
            case Reminder::KEY_TYPE_LEAD_VIEWING_REPORT:
                $searchModel = new ReportsSearch();
                $view = 'reports';
                break;
            case Reminder::KEY_TYPE_LEAD_CONTACT:
                $searchModel = new LeadViewingSearch();
                $view = 'lead_contacts';
                break;
        }  //print_r(Yii::$app->request->queryParams); die();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;
        return $this->renderAjax('gridviews/' . $view, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

}
