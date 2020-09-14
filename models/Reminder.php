<?php

namespace app\models;

use app\modules\calendar\models\Event;
use app\modules\lead\Lead;
use app\modules\lead_viewing\models\LeadViewing;
use app\models\ReminderUser;
use app\modules\notifications\models\Notification;
use codeonyii\yii2validators\AtLeastValidator;
use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "reminder".
 *
 * @property int $id
 * @property int $time
 * @property int $key
 * @property int $key_id
 * @property int $interval_type
 * @property int $created_at
 * @property int $user_id
 * @property int $send_type
 * @property int $status
 * @property int $notification_created_at
 * @property int $seconds_interval
 * @property int $notification_time_from
 * @property int $remind_at_time
 * @property int $remind_at_time_result
 *
 * @property ReminderUser[] $reminderUsers
 */
class Reminder extends \yii\db\ActiveRecord
{
    // KEY_TYPE constants values must be equal to app\components\Notification key events constants values
    const KEY_TYPE_SALE = 'sale_reminder';
    const KEY_TYPE_RENTALS = 'rentals_reminder';
    const KEY_TYPE_CONTACTS = 'contact_reminder';
    const KEY_TYPE_LEAD = 'lead_reminder';
    const KEY_TYPE_EVENT = 'event_reminder';
    const KEY_TYPE_TASKMANAGER = 'task_reminder';
    const KEY_TYPE_LEAD_VIEWING_REPORT = 'lead_viewing_report';
    const KEY_TYPE_LEAD_CONTACT = 'lead_contact';
    const KEY_TYPE_OPEN_LEAD = 'lead_open';
    const KEY_TYPE_VIEWING_REPORT = 'viewing_report';

    const INTERVAL_TYPE_MINUTES = 1;
    const INTERVAL_TYPE_HOURS = 2;
    const INTERVAL_TYPE_DAYS = 3;
    const INTERVAL_TYPE_WEEKS = 4;

    const SEND_TYPE_WEBSITE = 1;
    const SEND_TYPE_EMAIL = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    const REMIND_AT_TIME_SUCCESS = 1;
    const REMIND_AT_TIME_WAITING = 0;

    const SCENARIO_PERSONAL_ASSISTANT = 'personal-assistant';

    public $timeOrIntervalError;
    public $users;

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->time)
                $this->seconds_interval = self::getSecondsIntervalType($this->interval_type);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Undocumented function
     *
     * @param $insert
     * @param $changedAttributes
     * @return void
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        ReminderUser::deleteAll(['reminder_id' => $this->id]);
        $usersDecodedText = html_entity_decode($this->users);
        $users = json_decode($usersDecodedText);

        foreach ($users as $user) {
            if (!empty($user)) {
                $userModel = new ReminderUser();
                $userModel->reminder_id = $this->id;
                $userModel->user_id = $user;
                $userModel->save();
            }
        }
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return [
            self::KEY_TYPE_SALE => Yii::t('app', 'Sale'),
            self::KEY_TYPE_RENTALS => Yii::t('app', 'Rental'),
            self::KEY_TYPE_CONTACTS => Yii::t('app', 'Contact'),
            self::KEY_TYPE_LEAD => Yii::t('app', 'Lead'),
            self::KEY_TYPE_EVENT => Yii::t('app', 'Event'),
            self::KEY_TYPE_TASKMANAGER => Yii::t('app', 'Task'),
            self::KEY_TYPE_LEAD_CONTACT => Yii::t('app', 'Contact Lead'),
            self::KEY_TYPE_OPEN_LEAD => Yii::t('app', 'Open lead'),
            self::KEY_TYPE_VIEWING_REPORT => Yii::t('app', 'Viewing report'),
        ];
    }

    // used in reminders gridview
    public function getNotificationTitle()
    {
        switch ($this->key) {
            case self::KEY_TYPE_SALE:
                $ref = Sale::findOne($this->key_id)->ref;
                return Yii::t('app', 'You have a sale {ref}', [
                    'ref' => $ref
                ]);
            case self::KEY_TYPE_RENTALS:
                $ref = Rentals::findOne($this->key_id)->ref;
                return Yii::t('app', 'You have a rentals {ref}', [
                    'ref' => $ref
                ]);
            case self::KEY_TYPE_CONTACTS:
                $contact = Contacts::findOne($this->key_id);
                return Yii::t('app', 'You have a contact {first_name} {last_name}', [
                    'first_name' => $contact->first_name,
                    'last_name' => $contact->last_name
                ]);
            case self::KEY_TYPE_LEAD:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'You have a lead {reference}', [
                    'reference' => $reference,
                ]);
            case self::KEY_TYPE_EVENT:
                $event = Event::findOne($this->key_id);
                $formatedStart = date("Y-m-d H:i", $event->start);
                return Yii::t('app', 'You have an event {start}', [
                    'start' => $formatedStart
                ]);
            case self::KEY_TYPE_TASKMANAGER:
                return Yii::t('app', 'You have a task');
            case self::KEY_TYPE_LEAD_VIEWING_REPORT:
                $reference = LeadViewing::findOne($this->key_id)->lead->reference;
                return Yii::t('app', 'You have a lead viewing {reference}', [
                    'reference' => $reference,
                ]);
            case self::KEY_TYPE_LEAD_CONTACT:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'You have not contacted the {reference} lead within 24 hours', [
                    'reference' => $reference,
                ]);
            case self::KEY_TYPE_OPEN_LEAD:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'Agent has not contacted the {reference} lead within 72 hours', [
                    'reference' => $reference,
                ]);
        }
    }

    public function getEmailNotificationDescription()
    {
        if ($this->description)
            return $this->description;
        switch ($this->key) {
            case self::KEY_TYPE_SALE:
                $ref = Sale::findOne($this->key_id)->ref;
                return Yii::t('app', 'You have a sale {ref}', [
                        'ref' => $ref
                    ]) . '. ' . Url::to(['/sale/view', 'id' => $this->key_id], true);
            case self::KEY_TYPE_RENTALS:
                $ref = Rentals::findOne($this->key_id)->ref;
                return Yii::t('app', 'You have a rentals {ref}', [
                        'ref' => $ref
                    ]) . '. ' . Url::to(['/rentals/view', 'id' => $this->key_id], true);
            case self::KEY_TYPE_CONTACTS:
                $contact = Contacts::findOne($this->key_id);
                return Yii::t('app', 'You have a contact {first_name} {last_name}', [
                        'first_name' => $contact->first_name,
                        'last_name' => $contact->last_name
                    ]) . '. ' . Url::to(['/contacts/view', 'id' => $this->key_id], true);
            case self::KEY_TYPE_LEAD:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'You have a lead {reference}', [
                        'reference' => $reference,
                    ]) . '. ' . Url::to(['/leads/' . $reference], true);
            case self::KEY_TYPE_EVENT:
                $event = Event::findOne($this->key_id);
                $formatedStart = date("Y-m-d H:i", $event->start);
                return Yii::t('app', 'You have an event {start}', [
                    'start' => $formatedStart
                ]);
            case self::KEY_TYPE_LEAD_CONTACT:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'You have not contacted the {reference} lead within 24 hours', [
                        'reference' => $reference,
                    ]) . '. ' . Url::to(['/leads/view', 'id' => $this->key_id], true);
            case self::KEY_TYPE_OPEN_LEAD:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'Agent have not contacted the {reference} lead within 72 hours', [
                    'reference' => $reference,
                ]) . '. ' . Url::to(['/leads/view', 'id' => $this->key_id], true);
        }
    }

    public function getLink()
    {
        switch ($this->key) {
            case self::KEY_TYPE_SALE:
                return Html::a(FA::icon('link'), ['sale/view', 'id' => $this->key_id], ['class' => 'btn btn-default']);
            case self::KEY_TYPE_RENTALS:
                return Html::a(FA::icon('link'), ['rentals/view', 'id' => $this->key_id], ['class' => 'btn btn-default']);
            case self::KEY_TYPE_CONTACTS:
                return Html::a(Yii::t('app', 'Contact'), ['contacts/view', 'id' => $this->key_id]);
            case self::KEY_TYPE_LEAD:
                $lead = Leads::findOne($this->key_id);
                return Html::a($lead->reference, ['leads/' . $lead->reference]);
            case self::KEY_TYPE_EVENT:
                return '';
            case self::KEY_TYPE_TASKMANAGER:
                return Html::a(Yii::t('app', 'Task'), ['/task-manager/view', 'id' => $this->key_id]);
            case self::KEY_TYPE_LEAD_VIEWING_REPORT:
                $leadViewing = LeadViewing::findOne($this->key_id);
                return Html::a($leadViewing->lead->reference, ['/leads/' . $leadViewing->lead->reference]);
            case self::KEY_TYPE_LEAD_CONTACT:
                $lead = Leads::findOne($this->key_id);
                return Html::a($lead->reference, ['leads/' . $lead->reference]);
            case self::KEY_TYPE_OPEN_LEAD:
                $lead = Leads::findOne($this->key_id);
                return Html::a($lead->reference, ['leads/' . $lead->reference]);
        }
    }

    public function getSendType()
    {
        switch ($this->send_type) {
            case self::SEND_TYPE_WEBSITE:
                return Yii::t('app', 'Website');
            case self::SEND_TYPE_EMAIL:
                return Yii::t('app', 'Email');
        }
    }

    public function getStatus()
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                return Yii::t('app', 'Active');
            case self::STATUS_NOT_ACTIVE:
                return Yii::t('app', 'Not active');
        }
    }


    public static $intervalTypes = [
        self::INTERVAL_TYPE_MINUTES,
        self::INTERVAL_TYPE_HOURS,
        self::INTERVAL_TYPE_DAYS,
        self::INTERVAL_TYPE_WEEKS,
    ];

    public static function getDropdownIntervalType()
    {
        return [
            self::INTERVAL_TYPE_MINUTES => Yii::t('app', 'Minutes'),
            self::INTERVAL_TYPE_HOURS => Yii::t('app', 'Hours'),
            self::INTERVAL_TYPE_DAYS => Yii::t('app', 'Days'),
            self::INTERVAL_TYPE_WEEKS => Yii::t('app', 'Weeks')
        ];
    }

    public static function getIntervalType($intervalType)
    {
        switch ($intervalType) {
            case self::INTERVAL_TYPE_MINUTES:
                return Yii::t('app', 'Minutes');
            case self::INTERVAL_TYPE_HOURS:
                return Yii::t('app', 'Hours');
            case self::INTERVAL_TYPE_DAYS:
                return Yii::t('app', 'Days');
            case self::INTERVAL_TYPE_WEEKS:
                return Yii::t('app', 'Weeks');
        }
    }

    public static function getSecondsIntervalType($intervalType)
    {
        switch ($intervalType) {
            case self::INTERVAL_TYPE_MINUTES:
                return 60;
            case self::INTERVAL_TYPE_HOURS:
                return 60 * 60;
            case self::INTERVAL_TYPE_DAYS:
                return 60 * 60 * 24;
            case self::INTERVAL_TYPE_WEEKS:
                return 60 * 60 * 24 * 7;
        }
    }

    public function getTime()
    {
        switch ($this->interval_type) {
            case self::INTERVAL_TYPE_MINUTES:
                return $this->time / 60;
            case self::INTERVAL_TYPE_HOURS:
                return $this->time / (60 * 60);
            case self::INTERVAL_TYPE_DAYS:
                return $this->time / (60 * 60 * 24);
            case self::INTERVAL_TYPE_WEEKS:
                return $this->time / (60 * 60 * 24 * 7);
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reminder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'user_id', 'status'], 'required'],
            [['key_id'], 'required', 'message' => Yii::t('app', 'Select something to what you want to apply this reminder')],
            [['time', 'key_id', 'interval_type', 'created_at', 'user_id', 'send_type', 'status'], 'integer'],
            [['key'], 'string'],
            [['remind_at_time_result', 'key_id', 'remind_at_time', 'interval_type', 'time', 'send_type', 'description', 'notification_created_at', 'seconds_interval', 'notification_time_from', 'subject', 'users'], 'safe'],
            ['timeOrIntervalError', AtLeastValidator::className(), 'in' => ['remind_at_time', 'time'], 'message' => 'Please, enter interval or time, or both'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'time' => Yii::t('app', 'Interval Time'),
            'key' => Yii::t('app', 'Key'),
            'key_id' => Yii::t('app', 'Key ID'),
            'interval_type' => Yii::t('app', 'Interval'),
            'created_at' => Yii::t('app', 'Created At'),
            'description' => Yii::t('app', 'Note'),
            'remind_at_time' => Yii::t('app', 'Notification time'),
            'subject' => Yii::t('app', 'Event subject'),
        ];
    }

    public function sendNotificationEmail($user)
    {
        if ($user->email) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($user->email)
                ->setSubject($this->getNotificationTitle())
                ->setTextBody($this->getEmailNotificationDescription())
                ->send();
        }

        $this->notification_created_at = time();
        $this->update();
    }

    public $futureNotificationCreatedAt;

    public static function getPersonalAssistantDataProvider()
    {
        $query = Reminder::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->select('*, (notification_created_at + (seconds_interval * time)) as futureNotificationCreatedAt');
        $query->andFilterWhere([
            'status' => self::STATUS_ACTIVE,
            'user_id' => Yii::$app->user->id,
        ]);
        $query->orderBy('futureNotificationCreatedAt ASC');
        $dataProvider->pagination->pageSize = 5;
        return $dataProvider;
    }

    public static function getReminders()
    {
        $query = Reminder::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere([
            'status' => self::STATUS_ACTIVE,
            'user_id' => Yii::$app->user->id,
        ]);
        $query->orderBy('created_at DESC');
        $dataProvider->pagination->pageSize = 5;
        return $dataProvider;
    }

    public static function addReminder($key, $keyId, $intervalType, $sendType, $status, $time, $remindAtTime, $secondsInterval)
    {
        $newReminder = new Reminder;
        $newReminder->user_id = Yii::$app->user->id;
        $newReminder->key = $key;
        $newReminder->key_id = $keyId;
        $newReminder->interval_type = $intervalType;
        $newReminder->send_type = $sendType;
        $newReminder->status = $status;
        $newReminder->created_at = time();
        $newReminder->seconds_interval = $secondsInterval;
        $newReminder->time = $time;
        $newReminder->remind_at_time = $remindAtTime;
        $newReminder->save();
    }

    public static function findClosestTime($currentTime, $reminder, $userId)
    {
        $reminderSecondsInterval = Reminder::getSecondsIntervalType($reminder->interval_type);
        $tempTime = 0;
        $temp = $currentTime;
        $existNotice = false;

        if ($reminder->time) {
            $remindTime = ($reminder->remind_at_time) ? $reminder->remind_at_time : $reminder->created_at;
            if ($temp < $remindTime) {
                $temp = $currentTime;
            } else {
                $temp += $reminderSecondsInterval * $reminder->time;
            }

            while (($temp - $remindTime) < ($reminderSecondsInterval * $reminder->time)) {
                $temp += $reminderSecondsInterval * $reminder->time;
//                $lastInterval = $temp - ($reminderSecondsInterval * $reminder->time);
//                $lastNotification = Notification::find()->where(['user_id' => $userId, 'key' => $reminder->key, 'key_id' => $reminder->key_id])
//                    ->andWhere(['>=', 'UNIX_TIMESTAMP(created_at)', $lastInterval])
//                    ->andWhere(['<', 'UNIX_TIMESTAMP(created_at)', $temp])
//                    ->one();
//
//                if (!$lastNotification)
//                    $existNotice = true;
            }
            $tempTime = $temp;
        } else if ($reminder->remind_at_time && $reminder->remind_at_time_result == Reminder::REMIND_AT_TIME_WAITING && (time() > $reminder->remind_at_time)) {
            $tempTime = $reminder->remind_at_time;
        }

        return $tempTime;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReminderUsers()
    {
        return $this->hasMany(ReminderUser::class, ['reminder_id' => 'id']);
    }
}
