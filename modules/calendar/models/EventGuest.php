<?php

namespace app\modules\calendar\models;

use app\models\Contacts;
use Yii;

/**
 * This is the model class for table "event_guest".
 *
 * @property int $id
 * @property int $event_id
 * @property int $contact_id
 *
 * @property Contacts $contact
 * @property Event $event
 */
class EventGuest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_guest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'contact_id'], 'integer'],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contacts::className(), 'targetAttribute' => ['contact_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'contact_id' => 'Contact ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contacts::className(), ['id' => 'contact_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
