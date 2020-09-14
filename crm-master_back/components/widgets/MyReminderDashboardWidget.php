<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\data\ActiveDataProvider;

class MyReminderDashboardWidget extends Widget
{
    /**
     * @var array
     */
    public $reminders;

    /**
     * @var int
     */
    public $reminderPages;

//    public function init()
//    {
//    }

    public function run()
    {
        return $this->render('myReminderDashboard/my-reminder-dashboard', [
            'reminders'  => $this->reminders,
            'reminderPages' => $this->reminderPages,
        ]);
    }
}
