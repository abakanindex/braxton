<?php

namespace app\modules\calendar\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Contacts;

/**
 * This is the model class for table "event_contact_link".
 *
 * @property int $id
 * @property int $event_id
 * @property int $contact_id
 *
 * @property Contacts $contact
 * @property Event $event
 */

class EventContactLink extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_contact_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'contact_id'], 'integer'],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contacts::class, 'targetAttribute' => ['contact_id' => 'id']],
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
            'contact_id' => Yii::t('app', 'Contact ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contacts::class, ['id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }
}
