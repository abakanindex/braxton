<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_rental_link".
 *
 * @property int $id
 * @property int $task_id
 * @property int $rental_id
 *
 * @property Rentals $rental
 * @property TaskManager $task
 */
class TaskRentalLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_rental_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'rental_id'], 'required'],
            [['task_id', 'rental_id'], 'integer'],
            [['rental_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rentals::className(), 'targetAttribute' => ['rental_id' => 'id']],
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
            'rental_id' => Yii::t('app', 'Rental ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRental()
    {
        return $this->hasOne(Rentals::className(), ['id' => 'rental_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(TaskManager::className(), ['id' => 'task_id']);
    }
}
