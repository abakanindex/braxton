<?php

namespace app\modules\lead\models;

use app\models\Rentals;
use app\models\Sale;
use Yii;

/**
 * This is the model class for table "lead_property".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $property_id
 * @property int $type
 */
class LeadProperty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_property';
    }

    const TYPE_SALE = 1;
    const TYPE_RENTALS = 2;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'property_id', 'type'], 'integer'],
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
            'property_id' => Yii::t('app', 'Property ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    public function getProperty()
    {
        if ($this->type == self::TYPE_SALE)
            return $this->hasOne(Sale::className(), ['id' => 'property_id']);
        elseif ($this->type == self::TYPE_RENTALS)
            return $this->hasOne(Rentals::className(), ['id' => 'property_id']);
    }
}
