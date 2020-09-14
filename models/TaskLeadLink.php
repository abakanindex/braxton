<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_lead_link".
 *
 * @property int $id
 * @property int $task_id
 * @property int $lead_id
 *
 * @property Leads $lead
 * @property TaskManager $task
 */
class TaskLeadLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_lead_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'lead_id'], 'integer'],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskManager::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'task_id' => Yii::t('app', 'Task ID'),
            'lead_id' => Yii::t('app', 'Lead ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(TaskManager::className(), ['id' => 'task_id']);
    }
}
