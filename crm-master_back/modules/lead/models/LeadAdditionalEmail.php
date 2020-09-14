<?php

namespace app\modules\lead\models;

use app\models\Leads;
use Yii;

/**
 * This is the model class for table "lead_additional_email".
 *
 * @property int $id
 * @property int $lead_id
 * @property string $email
 *
 * @property Leads $lead
 */
class LeadAdditionalEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_additional_email';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'email'], 'required'],
            [['lead_id'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lead_id' => Yii::t('app', 'Lead ID'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id']);
    }
}
