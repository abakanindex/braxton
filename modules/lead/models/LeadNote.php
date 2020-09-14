<?php

namespace app\modules\lead\models;

use app\models\Leads;
use Yii;

/**
 * This is the model class for table "lead_note".
 *
 * @property int $id
 * @property string $text
 * @property int $lead_id
 *
 * @property Leads $lead
 */
class LeadNote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['lead_id'], 'integer'],
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
            'text' => Yii::t('app', 'Text'),
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
}
