<?php

namespace app\components\behaviors;

use app\models\Reminder;
use DateTime;
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ReminderBehavior extends Behavior
{
    public $reminderAttr = 'reminderAttr';
    public $key = '';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => 'refreshReminder'
        ];
    }

    public function refreshReminder($event)
    {
        $userId = Yii::$app->user->id;
        $params = [];
        parse_str($this->owner->{$this->reminderAttr}, $params);
        if ($params) {
            $reminder = Reminder::findOne(['key' => $this->key, 'key_id' => $this->owner->id, 'user_id'=>$userId]);
            if (!$reminder) {
                $reminder = new Reminder();
                $reminder = $this->loadParams($reminder, $params, $userId);
                $reminder->created_at = time();
                if ($reminder->save()) {} else print_r($reminder->getErrors()); ;
            } else {
                $createdAt = $reminder->created_at;
                $reminder = $this->loadParams($reminder, $params, $userId);
                $reminder->created_at = $createdAt;
                if ($reminder->update()) {} else print_r($reminder->getErrors()); ;
            }
        }
    }

    private function loadParams($reminder, $params, $userId)
    {
        $oldRemindAtTime = $reminder->remind_at_time;
        $reminder->load($params);
        $reminder->key = $this->key;
        $reminder->key_id = $this->owner->id;
        $reminder->user_id = $userId;

        $remindAtTime = DateTime::createFromFormat("Y-m-d H:i", $reminder->remind_at_time);
        if ($remindAtTime)
            $reminder->remind_at_time = $remindAtTime->getTimestamp();
        if ($oldRemindAtTime != $reminder->remind_at_time)
            $reminder->remind_at_time_result = Reminder::REMIND_AT_TIME_WAITING;
        return $reminder;
    }

}