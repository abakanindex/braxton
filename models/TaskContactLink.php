<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_contact_link".
 *
 * @property int $id
 * @property int $task_id
 * @property int $contact_id
 *
 * @property Contacts $contact
 * @property TaskManager $task
 */
class TaskContactLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_contact_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'contact_id'], 'integer'],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contacts::className(), 'targetAttribute' => ['contact_id' => 'id']],
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
            'contact_id' => Yii::t('app', 'Contact ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contacts::className(), ['id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(TaskManager::className(), ['id' => 'task_id']);
    }
}
