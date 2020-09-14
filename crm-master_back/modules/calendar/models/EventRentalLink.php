<?php

namespace app\modules\calendar\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Rentals;

/**
 * This is the model class for table "event_rental_link".
 *
 * @property int $id
 * @property int $event_id
 * @property int $rental_id
 *
 * @property Rentals $rental
 * @property Event $event
 */

class EventRentalLink extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_rental_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'rental_id'], 'integer'],
            [['rental_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rentals::class, 'targetAttribute' => ['rental_id' => 'id']],
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
            'rental_id' => Yii::t('app', 'Rental ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRental()
    {
        return $this->hasOne(Rentals::class, ['id' => 'rental_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }
}