<?php

namespace app\modules\calendar\models;

use app\models\Contacts;
use app\models\User;
use app\models\UserProfile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int $owner_id
 * @property int $start
 * @property int $end
 * @property int $type
 * @property string $title
 * @property string $location
 * @property string $description
 * @property int $ref_leads
 * @property int $ref_listings
 * @property int $ref_deals
 * @property int $lead_viewing_id
 * @property string $leadsIds
 * @property string $contactsIds
 * @property string $salesIds
 * @property string $rentalsIds
 *
 * @property User $owner
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    public $displayStart;
    public $displayEnd;
    public $eventContactsIds;

    public $repeatType;
    public $repeatInterval;
    public $repeatEndMode;
    public $repeatStart;
    public $repeatEnd;
    public $repeatWeeklyDays;
    public $username;
    public $sales;
    public $salesIds;
    public $rentals;
    public $rentalsIds;
    public $leads;
    public $leadsIds;
    public $contacts;
    public $contactsIds;

    private $startTime;
    private $endTime;

    const REPEAT_END_MODE_ON = 'on';
    const REPEAT_END_MODE_NEVER = 'never';

    const REPEAT_TYPE_NONE = 'none';
    const REPEAT_TYPE_DAILY = 'daily';
    const REPEAT_TYPE_WEEKLY = 'weekly';
    const REPEAT_TYPE_MONTHLY = 'monthly';
    const REPEAT_TYPE_YEARLY = 'yearly';

    const REPEAT_DAILY_MAX_INTERVAL = 5;
    const REPEAT_WEEKLY_MAX_INTERVAL = 4;
    const REPEAT_MONTHLY_MAX_INTERVAL = 5;
    const REPEAT_YEARLY_MAX_INTERVAL = 5;

    const SCENARIO_CHANGE_EVENT = 'change-event';
    const SCENARIO_REPEAT = 'repeat';

    public static $repeatTypes = [
        self::REPEAT_TYPE_NONE,
        self::REPEAT_TYPE_DAILY,
        self::REPEAT_TYPE_WEEKLY,
        self::REPEAT_TYPE_MONTHLY,
        self::REPEAT_TYPE_YEARLY,
    ];

    public static function getRepeatTypeTitle($reminderType)
    {
        switch ($reminderType) {
            case self::REPEAT_TYPE_NONE:
                return Yii::t('app', 'None');
            case self::REPEAT_TYPE_DAILY:
                return Yii::t('app', 'Daily');
            case self::REPEAT_TYPE_WEEKLY:
                return Yii::t('app', 'Weekly');
            case self::REPEAT_TYPE_MONTHLY:
                return Yii::t('app', 'Monthly');
            case self::REPEAT_TYPE_YEARLY:
                return Yii::t('app', 'Yearly');
        }
    }

    public static function getRepeatTypeAddonText($reminderType)
    {
        switch ($reminderType) {
            case self::REPEAT_TYPE_NONE:
                return Yii::t('app', 'None');
            case self::REPEAT_TYPE_DAILY:
                return Yii::t('app', 'Day(s)');
            case self::REPEAT_TYPE_WEEKLY:
                return Yii::t('app', 'Week(s)');
            case self::REPEAT_TYPE_MONTHLY:
                return Yii::t('app', 'Month(s)');
            case self::REPEAT_TYPE_YEARLY:
                return Yii::t('app', 'Year(s)');
        }
    }

    public static function getRepeatTypeMaxInterval($reminderType)
    {
        switch ($reminderType) {
            case self::REPEAT_TYPE_DAILY:
                return self::REPEAT_DAILY_MAX_INTERVAL;
            case self::REPEAT_TYPE_WEEKLY:
                return self::REPEAT_WEEKLY_MAX_INTERVAL;
            case self::REPEAT_TYPE_MONTHLY:
                return self::REPEAT_MONTHLY_MAX_INTERVAL;
            case self::REPEAT_TYPE_YEARLY:
                return self::REPEAT_YEARLY_MAX_INTERVAL;
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_EVENT] = ['lead_viewing_id', 'owner_id', 'displayEnd', 'displayStart', 'repeatType', 'type', 'title', 'location', 'description', 'rentals_id', 'sale_id', 'eventContactsIds', 'repeatEndMode', 'repeatType', 'repeatInterval', 'repeatStart', 'repeatEnd', 'repeatWeeklyDays'];
        $scenarios[self::SCENARIO_REPEAT] = ['lead_viewing_id', 'owner_id', 'displayEnd', 'displayStart', 'repeatType', 'type', 'title', 'location', 'description', 'rentals_id', 'sale_id', 'start', 'end', 'repeatWeeklyDays'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'start', 'end', 'created_at'], 'required'],
            [['displayStart', 'displayEnd', 'repeatType'], 'required', 'on' => self::SCENARIO_CHANGE_EVENT],
            [['displayEnd'], 'checkEventTime'],
            [['owner_id', 'start', 'end', 'type', 'rentals_id', 'sale_id'], 'integer'],
            [['description', 'displayStart', 'displayEnd'], 'string'],
            [['title', 'location'], 'string', 'max' => 100],
            [['lead_viewing_id', 'title', 'location', 'description', 'rentals_id', 'sale_id', 'eventContactsIds', 'repeatEndMode', 'repeatType', 'repeatInterval', 'repeatStart', 'repeatEnd', 'repeatWeeklyDays', 'leadsIds', 'contactsIds', 'salesIds', 'rentalsIds'], 'safe'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],

            [['lead_viewing_id', 'displayEnd', 'displayStart', 'repeatType'], 'safe', 'on' => self::SCENARIO_REPEAT],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Calendar',
            'start' => 'Start',
            'end' => 'End',
            'type' => 'Type',
            'title' => 'Title',
            'location' => 'Location',
            'description' => 'Description',
            'rentals_id' => 'Rentals',
            'sale_id' => 'Sales',
            'displayStart' => 'Start',
            'displayEnd' => 'End',
            'salesIds' => Yii::t('app', 'Sales'),
            'rentalsIds' => Yii::t('app', 'Rentals'),
            'leadsIds' => Yii::t('app', 'Leads'),
            'contactsIds' => Yii::t('app', 'Contacts'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->created_at = time();
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->saveContacts();

        EventSaleLink::deleteAll(['event_id' => $this->id]);
        $saleIds = json_decode($this->salesIds, true);
        foreach ($saleIds as $saleId) {
            $eventSaleLink = new EventSaleLink();
            $eventSaleLink->event_id = $this->id;
            $eventSaleLink->sale_id = $saleId;
            $eventSaleLink->save();
        }

        EventRentalLink::deleteAll(['event_id' => $this->id]);
        $rentalIds = json_decode($this->rentalsIds, true);
        foreach ($rentalIds as $rentalId) {
            $eventRentalLink = new EventRentalLink();
            $eventRentalLink->event_id = $this->id;
            $eventRentalLink->rental_id = $rentalId;
            $eventRentalLink->save();
        }

        EventLeadLink::deleteAll(['event_id' => $this->id]);
        $leadIds = json_decode($this->leadsIds, true);
        foreach ($leadIds as $leadId) {
            $eventLeadLink = new EventLeadLink();
            $eventLeadLink->event_id = $this->id;
            $eventLeadLink->lead_id = $leadId;
            $eventLeadLink->save();
        }

        EventContactLink::deleteAll(['event_id' => $this->id]);
        $contactsIds = json_decode($this->contactsIds, true);
        foreach ($contactsIds as $contactId) {
            $eventContactLink = new EventContactLink();
            $eventContactLink->event_id = $this->id;
            $eventContactLink->contact_id = $contactId;
            $eventContactLink->save();
        }
    }

    public function checkEventTime($attribute, $params)
    {
        if ($this->start >= $this->end) {
            $this->addError($attribute, 'End time must be bigger then start time');
        }
    }

    public function getFormatedStartTime()
    {
        return date("Y-m-d", $this->start) . 'T' . date("H:i:s", $this->start);
    }

    public function getFormatedEndTime()
    {
        return date("Y-m-d", $this->end) . 'T' . date("H:i:s", $this->end);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(EventType::className(), ['id' => 'type']);
    }

    public function getEventGuest()
    {
        return $this->hasMany(EventGuest::className(), ['event_id' => 'id']);
    }

    public function getEventReminder()
    {
        return $this->hasMany(EventReminder::className(), ['event_id' => 'id']);
    }

    private function sendInvitation($contact)
    {
        \Yii::$app->mailer->compose('invite_event_guest',
            ['owner' => $this->owner->username,
                'title' => $this->title,
                'start' => date("Y-m-d H:i", $this->start),
                'end' => date("Y-m-d H:i", $this->end),])
            ->setFrom([\Yii::$app->params['adminEmail'] => 'Test Mail'])
            ->setTo($contact->work_email)
            ->setSubject('Event invitation mail')
            ->send();
    }

    public function saveContacts()
    {
        $contactIds = explode(",", $this->eventContactsIds);
        $oldEventGuestIds = ArrayHelper::getColumn(EventGuest::find()->where(['event_id' => $this->id])->all(), 'contact_id');
        $oldRemainedEventGuestIds = array_intersect($contactIds, $oldEventGuestIds);
        $oldRemovedEventGuestIds = array_diff($oldEventGuestIds, $oldRemainedEventGuestIds);
        EventGuest::deleteAll(['event_id' => $this->id, 'contact_id' => $oldRemovedEventGuestIds]);
        foreach ($contactIds as $contactId) {
            if ($contactId && !in_array($contactId, $oldRemainedEventGuestIds)) {
                $eventGuest = new EventGuest();
                $eventGuest->event_id = $this->id;
                $eventGuest->contact_id = $contactId;
                $eventGuest->save();
                //) {} else print_r($eventGuest->getErrors());
                $this->sendInvitation(Contacts::findOne($contactId));
            }
        }
    }

    public function getContactsIdsString()
    {
        $eventGuests = EventGuest::find()->where(['event_id' => $this->id])->all();
        $eventContactsId = [];
        foreach ($eventGuests as $eventGuest) {
            $eventContactsId[] = $eventGuest->contact_id;
        }
        $eventContactsIdsString = implode(",", $eventContactsId);
        return $eventContactsIdsString;
    }

    public function repeatEvents()
    {
        $events = [];
        if ($this->repeatType != self::REPEAT_TYPE_NONE) {
            $yearEnd = mktime(0, 0, 0, 12, 31, date('Y'));
            $endTime = $yearEnd + 24 * 60 * 60;
            switch ($this->repeatType) {
                case self::REPEAT_TYPE_DAILY:
                    if ($this->repeatEndMode === self::REPEAT_END_MODE_NEVER) {
                        $events = $this->initRepeatEvents('day', $endTime);
                    } elseif ($this->repeatEndMode === self::REPEAT_END_MODE_ON)
                        $events = $this->initRepeatEvents('day', $this->repeatEnd);
                    break;
                case self::REPEAT_TYPE_WEEKLY:
                    if ($this->repeatEndMode === self::REPEAT_END_MODE_NEVER) {
                        $events = $this->initRepeatEvents('week', $endTime, $this->repeatWeeklyDays);
                    } elseif ($this->repeatEndMode === self::REPEAT_END_MODE_ON)
                        $events = $this->initRepeatEvents('week', $this->repeatEnd, $this->repeatWeeklyDays);
                    break;
                case self::REPEAT_TYPE_MONTHLY:
                    if ($this->repeatEndMode === self::REPEAT_END_MODE_NEVER) {
                        $events = $this->initRepeatEvents('month', $endTime);
                    } elseif ($this->repeatEndMode === self::REPEAT_END_MODE_ON)
                        $events = $this->initRepeatEvents('month', $this->repeatEnd);
                    break;
                case self::REPEAT_TYPE_YEARLY:
                    if ($this->repeatEndMode === self::REPEAT_END_MODE_NEVER) {
                        $events = $this->initRepeatEvents('year', strtotime("+5 year", $this->repeatStart));
                    } elseif ($this->repeatEndMode === self::REPEAT_END_MODE_ON)
                        $events = $this->initRepeatEvents('year', $this->repeatEnd);
                    break;
                default:
                    $events[] = $this;
            }
        } else {
            $events[] = $this;
        }
        $eventsArr = ArrayHelper::toArray($events, [
            get_class($this) => [
                'id',
                'start',
                'end',
                'ownerName' => function ($event) {
                    return UserProfile::findOne($event->owner_id)->first_name;
                },
                'title',
                'location',
                'rentals_id',
                'sale_id',
            ],
        ]);
        return $eventsArr;
    }

    private function initRepeatEvents($repeatInterval, $endTime)
    {
        $events = [];
        $this->endTime = $endTime;
        $this->startTime = strtotime("+$this->repeatInterval $repeatInterval", $this->repeatStart);
        $day = '';
        if ($this->repeatWeeklyDays && !empty($this->repeatWeeklyDays)) {
            while ($this->startTime < $this->endTime) {
                $events = array_merge($events, $this->createDayWeekRepeatEvent($repeatInterval, $day));
            }
        } else {
            while ($this->startTime < $this->endTime) {
                $events[] = $this->createRepeatEvent($repeatInterval, $day);
            }
        }
        $events[] = $this;
        return $events;
    }

    private function createDayWeekRepeatEvent()
    {
        $events = [];
        $days = explode(',', $this->repeatWeeklyDays);
        $weekTime = $this->startTime;
        foreach ($days as $day) {
            $eventTime = $this->end - $this->start;
            $event = $this->cloneRepeatEvent();
            $this->startTime = strtotime("$day this week", $weekTime);
            $event->start = $this->startTime;
            $event->end = $this->startTime + $eventTime;
            if ($event->save()) {
                $event->saveContacts();
                $events[] = $event;
            }
        }
        $this->startTime = strtotime("+$this->repeatInterval week", $this->startTime);
        return $events;
    }

    private function createRepeatEvent($repeatInterval, $day)
    {
        $eventTime = $this->end - $this->start;
        $event = $this->cloneRepeatEvent();
        $event->start = $this->startTime;
        $event->end = $this->startTime + $eventTime;
        $this->startTime = strtotime("$day +$this->repeatInterval $repeatInterval", $this->startTime);
        if ($event->save()) {
            $event->saveContacts();
            return $event;
        } else {
            return null;
        }
    }

    private function cloneRepeatEvent()
    {
        $event = new Event();
        $event->scenario = self::SCENARIO_REPEAT;
        $event->attributes = $this->attributes;
        $event->owner_id = $this->owner_id;
        $event->eventContactsIds = $this->eventContactsIds;
        return $event;
    }

    public static function getPersonalAssistantDataProvider()
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere(['owner_id' => Yii::$app->user->id]);
        $query->andFilterWhere(['>', 'start', time()]);
        $query->orderBy('start ASC');
        $dataProvider->pagination->pageSize = 5;
        return $dataProvider;
    }

    public function getSales()
    {
        return $this->hasMany(EventSaleLink::class, ['event_id' => 'id']);
    }

    public function getRentals()
    {
        return $this->hasMany(EventRentalLink::class, ['event_id' => 'id']);
    }

    public function getLeads()
    {
        return $this->hasMany(EventLeadLink::class, ['event_id' => 'id']);
    }

    public function getContacts()
    {
        return $this->hasMany(EventContactLink::class, ['event_id' => 'id']);
    }
}
