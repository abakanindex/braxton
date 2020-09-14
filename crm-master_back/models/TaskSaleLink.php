<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_sale_link".
 *
 * @property int $id
 * @property int $task_id
 * @property int $sale_id
 *
 * @property Sale $sale
 * @property TaskManager $task
 */
class TaskSaleLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_sale_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'sale_id'], 'required'],
            [['task_id', 'sale_id'], 'integer'],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::className(), 'targetAttribute' => ['sale_id' => 'id']],
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
            'sale_id' => Yii::t('app', 'Sale ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::className(), ['id' => 'sale_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(TaskManager::className(), ['id' => 'task_id']);
    }
}
