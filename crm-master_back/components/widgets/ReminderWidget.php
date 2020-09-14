<?php

namespace app\components\widgets;

use app\models\Reminder;
use app\models\User;
use app\models\Company;
use Yii;
use yii\base\Widget;

class ReminderWidget extends Widget
{
    public $keyId;
    public $keyType;

    public function run()
    {
        $reminder = null;
        if ($this->keyId)
            $reminder = Reminder::findOne(['key_id' => $this->keyId, 'key' => $this->keyType, 'user_id' => Yii::$app->user->id]);
        if (!$reminder) {
            $reminder = new Reminder();
            $reminder->key = $this->keyType;
            $reminder->created_at = time();
            $reminder->status = Reminder::STATUS_ACTIVE;
        }

        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main') {
            $users = User::find()->all();
        } else {
            $users = User::find()->where(['company_id' => $companyId])->all();
        }


        return $this->render('reminder/reminder',
            [
                'reminder' => $reminder,
                'keyId' => $this->keyId,
                'keyType' => $this->keyType,
                'companyUsers' => $users,
            ]);
    }
}