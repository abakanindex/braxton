<?php

namespace app\modules\calendar\controllers;

use app\components\Notification;
use app\models\Company;
use app\models\Contacts;
use app\models\SaleSearch;
use app\models\RentalsSearch;
use app\models\TaskManager;
use app\models\TaskManagerSearch;
use app\models\Viewings;
use app\modules\lead\models\LeadsSearch;
use app\models\ContactsSearch as RealContactsSearch;
use app\models\User;
use app\models\UserProfile;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use edofre\fullcalendar\models\Event;
use app\modules\calendar\models\Event as RealEvent;
use app\modules\calendar\models\EventSearch;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `calendar` module
 */
class MainController extends Controller
{

     /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index'],
                'rules' => [
                    [
                        'allow'       => true,
                        'actions'     => ['index'],
                        'permissions' => ['calendarView'],
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
        $contact = new Contacts();
        $contact->scenario = Contacts::SCENARIO_EVENT;
        return $this->render('index', [
            'contact' => $contact,
        ]);
    }


    public function actionEvents($start, $end)
    {
        $startTimestamp = date_format(date_create($start), 'U');
        $endTimestamp = date_format(date_create($end), 'U');

        $eventRecords = RealEvent::find()->andWhere(['>=', 'start', $startTimestamp])->andWhere(['<', 'end', $endTimestamp])->all();
        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events[] = new Event([
                'id' => $eventRecord->id,
                'title' => UserProfile::findOne($eventRecord->owner->id)->first_name,
                'start' => $eventRecord->getFormatedStartTime(),
                'end' => $eventRecord->getFormatedEndTime(),
            ]);
        }

        $tasks =  TaskManagerSearch::getQueryByCompanyRolesGroups()->all();

        foreach ($tasks as $task) {
            if (is_numeric($task->deadline)) {
                $formattedDeadlineTime = $task->getFormattedDeadlineTime($task->deadline);
                $events[] = new Event([
                    'id' => $task->id,
                    'title' => $task->title,
                    'start' => $formattedDeadlineTime,
                    'end' => $formattedDeadlineTime,
                    'editable' => false,
                    'backgroundColor' => 'lightgreen',
                    'className' => 'tasks',
                ]);
            }
        }

        $viewings =  Viewings::getViewings();

        foreach ($viewings as $viewing) {
            if ($viewing->date) {
                $formattedDateTime = $viewing->getFormattedDateTime($viewing->date);
                $events[] = new Event([
                    'id' => $viewing->id,
                    'title' => Viewings::getTypes()[$viewing->type] . ', ref: ' . $viewing->ref,
                    'start' => $formattedDateTime,
                    'end' => $formattedDateTime,
                    'editable' => false,
                    'backgroundColor' => 'lightblue',
                    'className' => 'viewings',
                ]);
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $events;
    }

    public function actionEvent($id = null, $date = null)
    {
        if ($id === null) {
            $model = new RealEvent();
            if ($date != null) {
                $model->displayStart = $date . ' 8:00';
                $model->displayEnd = $date . ' 8:15';
                $model->repeatEndMode = RealEvent::REPEAT_END_MODE_ON;
                $model->repeatType = RealEvent::REPEAT_TYPE_NONE;
            }
        } else {
            $model = RealEvent::find()->where(['id' => $id])->with('eventGuest')->one();
            $model->displayStart = date("Y-m-d H:i", $model->start);
            $model->displayEnd = date("Y-m-d H:i", $model->end);
            $model->eventContactsIds = $model->getContactsIdsString();
            $model->repeatEndMode = RealEvent::REPEAT_END_MODE_ON;
            $model->repeatType = RealEvent::REPEAT_TYPE_NONE;
        }
        $model->scenario = RealEvent::SCENARIO_CHANGE_EVENT;
        $model->owner_id = Yii::$app->user->id;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->start = strtotime($model->displayStart);
            $model->end = strtotime($model->displayEnd);
            $model->contactsIds = Yii::$app->request->post('Event')['contactsIds'];
            $model->leadsIds = Yii::$app->request->post('Event')['leadsIds'];
            $model->salesIds = Yii::$app->request->post('Event')['salesIds'];
            $model->rentalsIds = Yii::$app->request->post('Event')['rentalsIds'];
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = 'error';
            $actionType = '';
            $events = [];
            if ($model->isNewRecord) {
                if ($model->save()) {
                    $result = 'success';
                    $actionType = 'save';
                    $events = $model->repeatEvents();
                }
            } else {
                if ($model->update()) {
                    $result = 'success';
                    $actionType = 'update';
                    $events = $model->repeatEvents();
                } elseif (Json::encode($model->getErrors() == '[]')) //doesn't updates when no data was changed
                {
                    $result = 'success';
                    $actionType = 'update';
                    $events = $model->repeatEvents();
                }
            }
            return [
                'result' => $result,
                'actionType' => $actionType,
                'events' => $events,
                'actionType' => $actionType
            ];
        } else {
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

            return $this->renderAjax('_event', [
                'model' => $model,
                'salesSearchModel'     => $salesSearchModel,
                'salesDataProvider'    => $salesDataProvider,
                'rentalsSearchModel'   => $rentalsSearchModel,
                'rentalsDataProvider'  => $rentalsDataProvider,
                'leadsSearchModel'     => $leadsSearchModel,
                'leadsDataProvider'    => $leadsDataProvider,
                'contactsSearchModel'  => $contactsSearchModel,
                'contactsDataProvider' => $contactsDataProvider,
            ]);
        }
    }

    public function actionValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new RealEvent;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->start = strtotime($model->displayStart);
            $model->end = strtotime($model->displayEnd);
            $model->created_at = time();
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionDeleteEvent($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = RealEvent::findOne($id);
        if ($model->delete()) {
            Notification::deleteAll(['user_id' => Yii::$app->user->id, 'key' => Notification::KEY_EVENT_REMINDER, 'key_id' => $id]);
            $result = 'success';
        } else {
            $result = 'error';
        }
        return ['result' => $result];
    }

    public function actionCreateContact()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Contacts;
        $model->scenario = Contacts::SCENARIO_EVENT;
        $companyId = Company::getCompanyIdBySubdomain();
        if (empty($companyId))
            $companyId = 0;
        $model->company_id = $companyId;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return ['result' => 'success', 'email' => $model->work_email, 'id' => $model->id];
            } else return ['result' => 'error'];
        } else
            return ['result' => 'error'];
    }

    public function actionValidateContact()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Contacts;
        $model->scenario = Contacts::SCENARIO_EVENT;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return ActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function actionGuests()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $companyId = Company::getCompanyIdBySubdomain();
        if (empty($companyId))
            $companyId = 0;
        $contacts = ArrayHelper::toArray(Contacts::find()
            ->where(['company_id' => $companyId])
           // ->andWhere(['not', ['Work_Email' => (new Expression('NULL'))]])
            ->all(), [
            'app\models\Contacts' => [
                'id',
                'work_email',
                'First_Name',
                'Last_Name',
            ],
        ]);
        $contacts = array_map(function($contact) {
            return array(
                'id' => $contact['id'],
                'email' => $contact['work_email'],
                'First_Name' => $contact['First_Name'],
                'Last_Name' => $contact['Last_Name']
            );
        }, $contacts);
        return $contacts;
    }

    public function actionEventsList(string $date) : string
    {
        $eventsQuery = RealEvent::find()
            ->select(['event.id', 'event.start', 'event.end', 'event.title', 'event.description',
                'user.username AS username'
            ])
            ->leftJoin('user', 'user.id = event.owner_id')
            ->where([
                'DATE(FROM_UNIXTIME(event.start))' => date('Y-m-d', strtotime($date . ' +1 day')),
                'user.company_id' => Company::getCompanyIdBySubdomain(),
            ])
            ->orderBy(['event.start' => SORT_DESC]);
        $eventsProvider = new ActiveDataProvider([
            'query' => $eventsQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $eventsQuery = TaskManager::find()
            ->select(['t.id', 't.deadline', 't.title', 't.description',
                'u.username AS username'
            ])
            ->from(TaskManager::tableName() . ' t')
            ->leftJoin(User::tableName() . ' AS u', 'u.id = t.owner_id')
            ->where([
                'DATE(FROM_UNIXTIME(t.deadline))' => date('Y-m-d', strtotime($date . ' +1 day')),
                't.company_id' => Company::getCompanyIdBySubdomain(),
            ])
            ->orderBy(['t.deadline' => SORT_DESC]);
        $taskManagerProvider = new ActiveDataProvider([
            'query' => $eventsQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $eventsQuery = Viewings::find()
            ->select(['v.id', 'v.date', 'v.note', 'v.ref', 'v.listing_ref', 'v.type', 'v.type_listing_ref',
                'u.username AS username'
            ])
            ->from(Viewings::tableName() . ' v')
            ->leftJoin(User::tableName() . ' AS u', 'u.id = v.created_by')
            ->where([
                'DATE(v.date)' => date('Y-m-d', strtotime($date . ' +1 day')),
            ])
            ->orderBy(['v.date' => SORT_DESC]);
        $viewingsProvider = new ActiveDataProvider([
            'query' => $eventsQuery,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->renderAjax('@app/components/widgets/views/calendarDashboard/partials/events-tab', [
            'eventsProvider'      => $eventsProvider,
            'taskManagerProvider' => $taskManagerProvider,
            'viewingsProvider'    => $viewingsProvider,
        ]);
    }

    public function actionViewing()
    {
        $model = Viewings::findOne(Yii::$app->request->post()['id']);
        $model->ref = $model->getLink();
        $model->listing_ref = $model->getLinkListingRef();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->toArray();
    }
}
