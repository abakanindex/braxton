<?php

namespace app\modules\calendar\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Sale;

/**
 * This is the model class for table "event_sale_link".
 *
 * @property int $id
 * @property int $event_id
 * @property int $sale_id
 *
 * @property Sale $sales
 * @property Event $event
 */

class EventSaleLink extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_sale_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'sale_id'], 'integer'],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
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
            'sale_id' => Yii::t('app', 'Sale ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }
}