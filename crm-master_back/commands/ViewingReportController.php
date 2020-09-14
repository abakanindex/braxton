<?php

namespace app\commands;

use yii\console\Controller;
use Yii;
use app\models\Viewings;
use app\models\Reminder;
use app\components\widgets\ReminderWidget;

class ViewingReportController extends Controller
{
    public $message;

    public function actionIndex()
    {
        if ($models = Viewings::findWithThreeCancellationsOfAgents()) {
            foreach ($models as $model) {
                $reminder = new Reminder();
                $reminder->key = Reminder::KEY_TYPE_VIEWING_REPORT;
                $reminder->key_id = $model->id;
                $reminder->created_at
                    = $reminder->remind_at_time
                    = time();
                $reminder->status = Reminder::STATUS_ACTIVE;
                $reminder->user_id = $model->created_by;
                $reminder->time = 2;
                $reminder->interval_type = Reminder::INTERVAL_TYPE_HOURS;
                $reminder->send_type = Reminder::SEND_TYPE_WEBSITE;
                $reminder->seconds_interval = 3600;
                $reminder->save();

                $model->is_sent_to_creator = 1;
                $model->save();
            }
        }

        echo "Ok!\n";
        return 0;
    }
}