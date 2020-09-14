<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_plan".
 *
 * @property int $id
 * @property string $title
 * @property int $max_users
 */
class PaymentPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max_users'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'max_users' => 'Max Users',
        ];
    }
}
