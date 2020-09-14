<?php

namespace app\modules\reports\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "{{%dashboard_report_order}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property int $report_id
 * @property int $order
 * @property int $updated_at
 * @property int $mode
 *
 * @property User $user
 */
class DashboardReportOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dashboard_report_order}}';
    }

    const TYPE_COMMON = 1;
    const TYPE_AGENT_LEADER_BOARD = 2;

    const MODE_OPENED = 1;
    const MODE_CLOSED = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'order', 'updated_at', 'mode'], 'required'],
            [['user_id', 'type', 'report_id', 'order', 'updated_at', 'mode'], 'integer'],
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
            'type' => Yii::t('app', 'Type'),
            'report_id' => Yii::t('app', 'Report ID'),
            'order' => Yii::t('app', 'Order'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getReport()
    {
        return $this->hasOne(Reports::className(), ['id' => 'report_id']);
    }
}
