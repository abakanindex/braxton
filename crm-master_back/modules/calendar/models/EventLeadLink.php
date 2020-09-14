<?php

namespace app\modules\calendar\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Leads;

/**
 * This is the model class for table "event_lead_link".
 *
 * @property int $id
 * @property int $event_id
 * @property int $lead_id
 *
 * @property Leads $lead
 * @property Event $event
 */


class EventLeadLink extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_lead_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'lead_id'], 'integer'],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::class, 'targetAttribute' => ['lead_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::class, 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event ID'),
            'lead_id' => Yii::t('app', 'Lead ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::class, ['id' => 'lead_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }
}