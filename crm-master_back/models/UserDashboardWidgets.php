<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_dashboard_widgets".
 *
 * @property int $id
 * @property int $user_id
 * @property int $widget
 * @property int $order
 *
 * @property User $user
 */
class UserDashboardWidgets extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_dashboard_widgets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'widget', 'order'], 'required'],
            [['user_id', 'widget', 'order'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'widget' => Yii::t('app', 'Widget'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
