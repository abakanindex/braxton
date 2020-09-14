<?php

namespace app\models;

use app\components\behaviors\ReminderBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\Company;
use app\interfaces\firstrecordmodel\IfirstRecordModel;
use app\modules\admin\models\OwnerManageGroup;

/**
 * This is the model class for table "{{%task_manager}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $responsible
 * @property string $listing_ref
 * @property int|null $deadline
 * @property string $remind
 * @property string $repeat
 * @property integer $created_at
 * @property integer $priority
 * @property integer $deadline_notificated
 * @property string $leadsIds
 * @property string $contactsIds
 * @property int $owner_id
 * @property int $status
 */
class TaskManager extends \yii\db\ActiveRecord implements IfirstRecordModel
{
    const PRIORITY_HIGH = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 3;

    const DEADLINE_NOTIFICATED_NOT = 0;
    const DEADLINE_NOTIFICATED = 1;

    const STATUS_ON_PROCESS = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_FAILED = 3;

    public $number;
    public $salesIds;
    public $rentalsIds;
    public $responsible;
    public $leadsIds;
    public $contactsIds;
    public $reminder;
    public $username;

    public function behaviors()
    {
        return [
            [
                'class' => ReminderBehavior::className(),
                'reminderAttr' => 'reminder',
                'key' => Reminder::KEY_TYPE_TASKMANAGER,
            ],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        TaskSaleLink::deleteAll(['task_id' => $this->id]);
        $saleIds = json_decode($this->salesIds, true);
        foreach ($saleIds as $saleId) {
            $taskSaleLink = new TaskSaleLink();
            $taskSaleLink->task_id = $this->id;
            $taskSaleLink->sale_id = $saleId;
            $taskSaleLink->save();
        }

        TaskRentalLink::deleteAll(['task_id' => $this->id]);
        $rentalIds = json_decode($this->rentalsIds, true);
        foreach ($rentalIds as $rentalId) {
            $taskRentalLink = new TaskRentalLink();
            $taskRentalLink->task_id = $this->id;
            $taskRentalLink->rental_id = $rentalId;
            $taskRentalLink->save();
        }

        TaskResponsibleUser::deleteAll(['task_id' => $this->id]);
        $taskResponsibleUsers = json_decode($this->responsible, true);
        foreach ($taskResponsibleUsers as $user) {
            $taskResponsibleUser = new TaskResponsibleUser();
            $taskResponsibleUser->task_id = $this->id;
            $taskResponsibleUser->user_id = $user;
            $taskResponsibleUser->save();
        }

        TaskLeadLink::deleteAll(['task_id' => $this->id]);
        $leadIds = json_decode($this->leadsIds, true);
        foreach ($leadIds as $leadId) {
            $taskLeadLink = new TaskLeadLink();
            $taskLeadLink->task_id = $this->id;
            $taskLeadLink->lead_id = $leadId;
            $taskLeadLink->save();
        }

        TaskContactLink::deleteAll(['task_id' => $this->id]);
        $contactsIds = json_decode($this->contactsIds, true);
        foreach ($contactsIds as $contactId) {
            $taskContactLink = new TaskContactLink();
            $taskContactLink->task_id = $this->id;
            $taskContactLink->contact_id = $contactId;
            $taskContactLink->save();
        }

    }

    public function getPriority()
    {
        switch ($this->priority) {
            case self::PRIORITY_HIGH:
                return Yii::t('app', 'High');
            case self::PRIORITY_MEDIUM:
                return Yii::t('app', 'Medium');
            case self::PRIORITY_LOW:
                return Yii::t('app', 'Low');
        }
    }

    public static function findPriority($priority)
    {
        switch ($priority) {
            case self::PRIORITY_HIGH:
                return Yii::t('app', 'High');
            case self::PRIORITY_MEDIUM:
                return Yii::t('app', 'Medium');
            case self::PRIORITY_LOW:
                return Yii::t('app', 'Low');
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_manager}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['priority', 'status'], 'required'],
            [['responsible'], 'required', 'message' => Yii::t('app', 'Please, add responsible users')],
            [['priority'], 'integer'],
            [['owner_id', 'deadline_notificated', 'reminder', 'leadsIds', 'contactsIds', 'salesIds', 'rentalsIds', 'title', 'description', 'responsible', 'deadline', 'remind', 'repeat', 'created_at', 'listing_ref'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'responsible' => Yii::t('app', 'Responsible'),
            'deadline' => Yii::t('app', 'Deadline'),
            'remind' => Yii::t('app', 'Remind'),
            'repeat' => Yii::t('app', 'Repeat'),
            'created_at' => Yii::t('app', 'created_at'),
            'salesIds' => Yii::t('app', 'Sales'),
            'rentalsIds' => Yii::t('app', 'Rentals'),
            'leadsIds' => Yii::t('app', 'Leads'),
            'contactsIds' => Yii::t('app', 'Contacts'),
            'listing_ref' => Yii::t('app', 'Listing ref'),
            'status' => Yii::t('app', 'Status')
        ];
    }

    public static function getPersonalAssistantDataProvider()
    {
        $query = TaskResponsibleUser::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->alias('u');
        $query->join('LEFT JOIN', 'task_manager', 'task_manager.id = u.task_id');
        $query->select('task_manager.deadline as deadline, task_manager.id, UNIX_TIMESTAMP(task_manager.deadline) as unixDeadline');
        $query->groupBy(['task_manager.id']);
        $query->andWhere(['user_id' => Yii::$app->user->id]);
        $query->andFilterWhere(['>', 'UNIX_TIMESTAMP(task_manager.deadline)', time()]);
        $query->orderBy('unixDeadline ASC');
        $dataProvider->pagination->pageSize = 5;
        return $dataProvider;
    }

    public function getResponsibleUsers()
    {
        return $this->hasMany(TaskResponsibleUser::className(), ['task_id' => 'id']);
    }

    public function getSales()
    {
        return $this->hasMany(TaskSaleLink::className(), ['task_id' => 'id']);
    }

    public function getRentals()
    {
        return $this->hasMany(TaskRentalLink::className(), ['task_id' => 'id']);
    }

    public function getLeads()
    {
        return $this->hasMany(TaskLeadLink::className(), ['task_id' => 'id']);
    }

    public function getContacts()
    {
        return $this->hasMany(TaskContactLink::className(), ['task_id' => 'id']);
    }

    public static function getByListingRef($listingRef)
    {
        return TaskManager::findAll([
            'listing_ref' => $listingRef
        ]);
    }

     /**
     *
     * This method returns the first record of model Leads
     * 
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $id = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$id) {
                empty(self::find()->one()) ? $firstRecord = $this : $firstRecord = self::find()->one();
            } else {
                $firstRecord = self::find()->where([
                    'id'         => $id
                ])->one();
            }
        } else {
            if ((new OwnerManageGroup())->getViewsByGroup()) {
                if (Yii::$app->controller->action->id === 'index') {                  
                    self::find()->where([
                        'company_id'         => $companyId,
                        'owner_id' => (new OwnerManageGroup())->getViewsByGroup()
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'company_id'         => $companyId,
                            'owner_id' => (new OwnerManageGroup())->getViewsByGroup()
                        ])->one() 
                        : $firstRecord = $this;
                } else {
                    self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'id'         => $id,
                            'company_id' => $companyId
                        ])->one()
                        : $firstRecord = $this;
                }
            } else {
                if (Yii::$app->controller->action->id === 'index') {
                    
                    self::find()->where([
                        'company_id'         => $companyId,
                        'owner_id' => Yii::$app->user->id
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'company_id'         => $companyId,
                            'owner_id' => Yii::$app->user->id
                        ])->one() 
                        : $firstRecord = $this;
                } else {
                    self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'id'         => $id,
                            'company_id' => $companyId
                        ])->one()
                        : $firstRecord = $this;
                }
            }
        }

        return $firstRecord;
    }

    /**
     * @param null|string $date
     * @return string
     */
    public function getFormattedDeadlineTime(?string $date) : string
    {
        if ($date) {
            $result = date("Y-m-d\TH:i:s", strtotime($date));
        } else {
            $result = date("Y-m-d") . 'T' . date("H:i:s");
        }

        return $result;
    }

    /**
     * @param int $companyId
     * @return array|TaskManager[]
     */
    public static function getTasksByCompanyId(int $companyId) : array
    {
        return self::find()
            ->where(['company_id' => $companyId])
            ->all();
    }

    public static function getStatuses() : array
    {
        $statuses[self::STATUS_ON_PROCESS]       = Yii::t('app', 'On Process');
        $statuses[self::STATUS_COMPLETED]     = Yii::t('app', 'Completed');
        $statuses[self::STATUS_FAILED]   = Yii::t('app', 'Failed');
        return $statuses;
    }
}
