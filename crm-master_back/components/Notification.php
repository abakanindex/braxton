<?php

namespace app\components;

use app\models\Contacts;
use app\models\Leads;
use app\models\Reminder;
use app\models\Rentals;
use app\models\Sale;
use app\models\TaskManager;
use app\models\Viewings;
use app\modules\calendar\models\Event;
use Yii;
use app\modules\notifications\models\Notification as BaseNotification;
use yii\helpers\Html;
use yii\helpers\Url;

class Notification extends BaseNotification
{

    /**
     * A meeting reminder notification
     */
    const KEY_EVENT_REMINDER = 'event_reminder';
    const KEY_SALE_REMINDER = 'sale_reminder';
    const KEY_RENTALS_REMINDER = 'rentals_reminder';
    const KEY_CONTACT_REMINDER = 'contact_reminder';
    const KEY_LEAD_REMINDER = 'lead_reminder';
    const KEY_TASKMANAGER_REMINDER = 'task_reminder';
    const KEY_LEAD_VIEWING_REPORT = 'lead_viewing_report';
    const KEY_EMAIL_IMPORT_LEAD = 'email_import_lead';
    const KEY_TYPE_LEAD_CONTACT = 'lead_contact';
    const KEY_TYPE_OPEN_LEAD = 'lead_open';
    const KEY_TYPE_VIEWING_REPORT = 'viewing_report';

    public static $keys = [
        self::KEY_EVENT_REMINDER,
        self::KEY_SALE_REMINDER,
        self::KEY_RENTALS_REMINDER,
        self::KEY_CONTACT_REMINDER,
        self::KEY_LEAD_REMINDER,
        self::KEY_TASKMANAGER_REMINDER,
        self::KEY_LEAD_VIEWING_REPORT,
        self::KEY_EMAIL_IMPORT_LEAD,
        self::KEY_TYPE_LEAD_CONTACT,
        self::KEY_TYPE_OPEN_LEAD,
        self::KEY_TYPE_VIEWING_REPORT,
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        switch ($this->key) {
            case self::KEY_EVENT_REMINDER:
                $event = Event::findOne($this->key_id);
                $formatedStart = date("Y-m-d H:i", $event->start);
                return Yii::t('app', 'You have an event {start}', [
                    'start' => $formatedStart
                ]);
            case self::KEY_SALE_REMINDER:
                $ref = Sale::findOne($this->key_id)->ref;
                return Yii::t('app', 'You have a Reminder: {ref}', [
                    'ref' => Html::a($ref, ['/sale/view', 'id' => $this->key_id], ['target' => '_blank', 'data-pjax' => '0'])
                ]);
            case self::KEY_RENTALS_REMINDER:
                $ref = Rentals::findOne($this->key_id)->ref;
                return Yii::t('app', 'You have a Reminder: {ref}', [
                    'ref' => Html::a($ref, ['/rentals/view', 'id' => $this->key_id], ['target' => '_blank', 'data-pjax' => '0'])
                ]);
            case self::KEY_CONTACT_REMINDER:
                $contact = Contacts::findOne($this->key_id);
                return Yii::t('app', 'You have a contact {first_name} {last_name}', [
                    'first_name' => $contact->first_name,
                    'last_name' => $contact->last_name
                ]);
            case self::KEY_LEAD_REMINDER:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'You have a Reminder: {ref}', [
                    'ref' => Html::a($reference, ['/leads/view', 'id' => $this->key_id], ['target' => '_blank', 'data-pjax' => '0'])
                ]);
            case self::KEY_TASKMANAGER_REMINDER:
                return Yii::t('app', 'You have a Task');
            case self::KEY_LEAD_VIEWING_REPORT:
                return Yii::t('app', 'You have to write report on Lead Viewing');
            case self::KEY_EMAIL_IMPORT_LEAD:
                $reference = Leads::findOne($this->key_id)->reference;
                return Yii::t('app', 'You have email imported lead {reference}', [
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
            case self::KEY_TYPE_VIEWING_REPORT:
                $viewing = Viewings::getByIdWithAgent($this->key_id);
                return Yii::t('app', 'Agent {name} is not filling the report for the following viewing: {link}.', [
                    'name' => $viewing->first_name . ' ' . $viewing->last_name,
                    'link' => Html::a($viewing->note, Url::to(['/viewing/view', 'id' => $viewing->id])),
                ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        switch ($this->key) {
            case self::KEY_EVENT_REMINDER:
                return [];
            case self::KEY_SALE_REMINDER:
                $reminder = Reminder::findOne(['key' => Reminder::KEY_TYPE_SALE, 'key_id' => $this->key_id]);
                if ($reminder->description)
                    return $reminder->description;
            case self::KEY_RENTALS_REMINDER:
                $reminder = Reminder::findOne(['key' => Reminder::KEY_TYPE_RENTALS, 'key_id' => $this->key_id]);
                if ($reminder->description)
                    return $reminder->description;
            case self::KEY_CONTACT_REMINDER:
                $reminder = Reminder::findOne(['key' => Reminder::KEY_TYPE_CONTACTS, 'key_id' => $this->key_id]);
                if ($reminder->description)
                    return $reminder->description;
            case self::KEY_LEAD_REMINDER:
                $reminder = Reminder::findOne(['key' => Reminder::KEY_TYPE_LEAD, 'key_id' => $this->key_id]);
                if ($reminder->description)
                    return $reminder->description;
            case self::KEY_TASKMANAGER_REMINDER:
                $reminder = Reminder::findOne(['key' => Reminder::KEY_TYPE_TASKMANAGER, 'key_id' => $this->key_id]);
                if ($reminder->description)
                    return $reminder->description;
            case self::KEY_TYPE_LEAD_CONTACT:
                $reminder = Reminder::findOne(['key' => Reminder::KEY_TYPE_LEAD_CONTACT, 'key_id' => $this->key_id]);
                if ($reminder->description)
                    return $reminder->description;
            case self::KEY_TYPE_OPEN_LEAD:
                $reminder = Reminder::findOne(['key' => Reminder::KEY_TYPE_OPEN_LEAD, 'key_id' => $this->key_id]);
                if ($reminder->description)
                    return $reminder->description;
        }
    }

    /**
     * @inheritdoc
     */
    public function getRoute()
    {
        switch ($this->key) {
            case self::KEY_EVENT_REMINDER:
                return ['/calendar/main/index'];
            case self::KEY_SALE_REMINDER:
                return ['/sale/view', 'id' => $this->key_id];
            case self::KEY_RENTALS_REMINDER:
                return ['/rentals/view', 'id' => $this->key_id];
            case self::KEY_CONTACT_REMINDER:
                return ['/contacts/view', 'id' => $this->key_id];
            case self::KEY_LEAD_REMINDER:
                $reference = Leads::findOne($this->key_id)->reference;
                return ['/leads/' . $reference];
            case self::KEY_TASKMANAGER_REMINDER:
                return ['/task-manager/view', 'id' => $this->key_id];
            case self::KEY_LEAD_VIEWING_REPORT:
                return ['//lead_viewing/main/view', 'id' => $this->key_id];
            case self::KEY_EMAIL_IMPORT_LEAD:
                $reference = Leads::findOne($this->key_id)->reference;
                return ['/leads/' . $reference];
            case self::KEY_TYPE_LEAD_CONTACT:
                $reference = Leads::findOne($this->key_id)->reference;
                return ['/leads/' . $reference];
            case self::KEY_TYPE_OPEN_LEAD:
                $reference = Leads::findOne($this->key_id)->reference;
                return ['/leads/' . $reference];
        };
    }

}