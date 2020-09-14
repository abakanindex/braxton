<?php

namespace app\modules\lead\models;

use Yii;

/**
 * This is the model class for table "lead_sub_status".
 *
 * @property int $id
 * @property string $title
 * @property int $order
 *
 * @property Leads[] $leads
 */
class LeadSubStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_sub_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'order'], 'required'],
            [['order'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['order'], 'unique'],
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
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeads()
    {
        return $this->hasMany(Leads::className(), ['sub_status_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getSubStatuses()
    {
        return self::find()->all();
    }
}
