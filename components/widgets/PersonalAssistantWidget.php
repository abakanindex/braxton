<?php

namespace app\components\widgets;

use app\components\Notification;
use app\models\Note;
use app\models\Reminder;
use app\models\TaskManager;
use app\modules\calendar\models\Event;
use app\modules\lead_viewing\models\LeadViewing;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PersonalAssistantWidget extends Widget
{

    public function run()
    {
        $notificationsDataProvider = Reminder::getPersonalAssistantDataProvider();
        $tasksDataProvider = TaskManager::getPersonalAssistantDataProvider();
        $eventsDataProvider = Event::getPersonalAssistantDataProvider();
        $leadViewingDataProvider = LeadViewing::getPersonalAssistantDataProvider();
        $notesDataProvider = Note::getPersonalAssistantDataProvider();
        $remindersDataProvider = Reminder::getReminders();
        return $this->render('personalAssistant/personal-assistant', [
            'notificationsDataProvider' => $notificationsDataProvider,
            'tasksDataProvider' => $tasksDataProvider,
            'eventsDataProvider' => $eventsDataProvider,
            'leadViewingDataProvider' => $leadViewingDataProvider,
            'notesDataProvider' => $notesDataProvider,
            'remindersDataProvider' => $remindersDataProvider,
            'emailLeadImportDataProvider' => self::getEmailLeadImportDataProvider(),
        ]);
    }

    private static function getEmailLeadImportDataProvider()
    {
        $query = Notification::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere(['user_id' => Yii::$app->user->id]);
        $query->andFilterWhere(['key' => Notification::KEY_EMAIL_IMPORT_LEAD]);
        $query->orderBy('id DESC');
        $dataProvider->pagination->pageSize = 5;
        return $dataProvider;
    }

}