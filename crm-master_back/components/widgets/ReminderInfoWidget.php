<?php

namespace app\components\widgets;

use app\models\Reminder;
use Yii;
use yii\base\Widget;

class ReminderInfoWidget extends Widget
{
    public $keyId;
    public $keyType;

    public function run()
    {
        $reminder = null;
        if ($this->keyId)
            $reminder = Reminder::findOne(['key_id' => $this->keyId, 'key' => $this->keyType, 'user_id' => Yii::$app->user->id]);
        return $this->render('reminderInfo/reminder_info',
            [
                'reminder' => $reminder
            ]);
    }
}