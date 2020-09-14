<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_responsible_user".
 *
 * @property int $id
 * @property int $user_id
 * @property int $task_id
 *
 * @property TaskManager $task
 * @property User $user
 */
class TaskResponsibleUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_responsible_user';
    }

    public $deadline;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'task_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskManager::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'task_id' => Yii::t('app', 'Task ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(TaskManager::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
