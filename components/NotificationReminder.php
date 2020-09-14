<?php

namespace app\components;

use app\models\EmailImportLead;
use app\models\Leads;
use app\models\Reminder;
use app\models\TaskManager;
use app\models\TaskResponsibleUser;
use app\models\User;
use app\modules\admin\models\ManageGroupChild;
use app\modules\calendar\models\EventReminder;
use app\modules\lead\models\EmailImportLeadParser;
use Yii;

class NotificationReminder extends \yii\base\Component
{

    public function init()
    {
        if (!Yii::$app->user->isGuest) {
            $user = User::findOne(Yii::$app->user->id);
            $groups = ManageGroupChild::getForUser($user->id);
            $currentTime = time();
            $this->checkTaskDeadline($user);
            if (Yii::$app->request->isAjax) {
//                if ($user->imap_enabled)
//                    EmailImportLeadParser::checkEmail($user);

                $leads = Leads::find()->where(['created_by_user_id' => Yii::$app->user->id])
                    ->with('contactNote')
                    ->andWhere(['is_parsed' => Leads::IS_PARSED_NOT])
                    ->all();
                foreach ($leads as $lead) {
                    if (!$lead->contactNote)
                        $this->createLeadContactReminder($lead);
//                    else
//                        $this->removeLeadContactReminder($lead);
                }
                $reminders = Reminder::findAll(['user_id' => $user->id, 'status' => Reminder::STATUS_ACTIVE]);
                foreach ($reminders as $reminder) {
                    if (!is_null($reminder->notification_time_from)) {
                        if ($currentTime > $reminder->notification_time_from)
                            $this->checkNotifications($user, $currentTime, $reminder, $groups);
                    } else
                        $this->checkNotifications($user, $currentTime, $reminder, $groups);
                }
            }
        }
    }

    /**
     * @param User $user
     */
    private function checkTaskDeadline($user)
    {
        $tasksIdsArr = TaskResponsibleUser::find()->where(['user_id'=>$user->id])->select(['task_id'])->column();
        foreach ($tasksIdsArr as $tasksId) {
            $task = TaskManager::find()->where(['id' => $tasksId])->with(['responsibleUsers'])->one();
            if ($task->deadline) {
                if ($task->deadline_notificated == TaskManager::DEADLINE_NOTIFICATED_NOT) {
                    if (date('Y-m') == date('Y-m', $task->deadline)) {
                        if (time() > strtotime('today 9:00')) {
                            Notification::deleteAll(['user_id' => $user->id, 'key' => Reminder::KEY_TYPE_TASKMANAGER, 'key_id' => $task->id]);
                            Notification::notify(Reminder::KEY_TYPE_TASKMANAGER, $user->id, $task->id);
                            $task->deadline_notificated = TaskManager::DEADLINE_NOTIFICATED;
                            $responsibleUsersIds = [];
                            foreach ($task->responsibleUsers as $responsibleUser) {
                                $responsibleUsersIds[] = $responsibleUser->id;
                            }
                            $task->responsible = json_encode($responsibleUsersIds);
                            $task->save();
                        }
                    }
                }
            }
        }
    }

    private function createLeadContactReminder($lead)
    {
        $reminder = Reminder::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['key' => Reminder::KEY_TYPE_LEAD_CONTACT])
            ->andWhere(['key_id' => $lead->id])
            ->one();
        if (!$reminder) {
            $newReminder = new Reminder;
            $newReminder->user_id = Yii::$app->user->id;
            $newReminder->time = 24;
            $newReminder->key = Reminder::KEY_TYPE_LEAD_CONTACT;
            $newReminder->key_id = $lead->id;
            $newReminder->interval_type = Reminder::INTERVAL_TYPE_HOURS;
            $newReminder->send_type = Reminder::SEND_TYPE_WEBSITE;
            $newReminder->status = Reminder::STATUS_ACTIVE;
            $newReminder->created_at = time();
            $newReminder->seconds_interval = Reminder::getSecondsIntervalType(Reminder::INTERVAL_TYPE_HOURS);
            $newReminder->save();
        }
    }

    private function removeLeadContactReminder($lead)
    {
        Reminder::deleteAll([
            'key' => Reminder::KEY_TYPE_LEAD_CONTACT,
            'key_id' => $lead->id
        ]);

        Reminder::deleteAll([
            'key' => Reminder::KEY_TYPE_OPEN_LEAD,
            'key_id' => $lead->id
        ]);
    }

    private function checkNotifications($user, $currentTime, $reminder, $groups)
    {
        $reminderSecondsInterval = Reminder::getSecondsIntervalType($reminder->interval_type);
        $lastInterval = $currentTime - $reminderSecondsInterval * $reminder->time;

        if ($reminder->time) {
            $remindTime = ($reminder->remind_at_time) ? $reminder->remind_at_time : $reminder->created_at;
            if (($currentTime - $remindTime) >= ($reminderSecondsInterval * $reminder->time)) {
                $lastNotification = Notification::find()->where(['user_id' => $user->id, 'key' => $reminder->key, 'key_id' => $reminder->key_id])
                    ->andWhere(['>=', 'UNIX_TIMESTAMP(created_at)', $lastInterval])
                    ->andWhere(['<', 'UNIX_TIMESTAMP(created_at)', $currentTime])
                    ->one();

                if (!$lastNotification) {
                    Notification::deleteAll(['user_id' => $user->id, 'key' => $reminder->key, 'key_id' => $reminder->key_id]);
                    Notification::notify($reminder->key, $user->id, $reminder->key_id);
                    $reminder->notification_created_at = time();
                    $reminder->update();
                    $reminder->sendNotificationEmail($user);

                    $limitTime = $reminder->created_at + 60*60*24*3;

                    if (($reminder->key = Reminder::KEY_TYPE_LEAD_CONTACT) && ($limitTime >= time())) {
                        foreach($groups as $group) {
                            $ownerUser   = User::findOne($group['owner_id']);
                            $newReminder = new Reminder;

                            $newReminder->user_id = $group['owner_id'];
                            $newReminder->key = Reminder::KEY_TYPE_OPEN_LEAD;
                            $newReminder->key_id = $reminder->key_id;
                            $newReminder->send_type = Reminder::SEND_TYPE_WEBSITE;//TODO check for email
                            $newReminder->status = Reminder::STATUS_ACTIVE;
                            $newReminder->created_at = time();
                            $newReminder->remind_at_time = $limitTime;
                            $newReminder->remind_at_time_result = Reminder::REMIND_AT_TIME_WAITING;
                            $newReminder->save();
                            $newReminder->sendNotificationEmail($ownerUser);
                        }
                    }
                }
            }
        } else if ($reminder->remind_at_time && $reminder->remind_at_time_result == Reminder::REMIND_AT_TIME_WAITING && time() > $reminder->remind_at_time) {
            Notification::deleteAll(['user_id' => $user->id, 'key' => $reminder->key, 'key_id' => $reminder->key_id]);
            Notification::notify($reminder->key, $user->id, $reminder->key_id);
            $reminder->remind_at_time_result = Reminder::REMIND_AT_TIME_SUCCESS;
            $reminder->update();
        }

    }

}