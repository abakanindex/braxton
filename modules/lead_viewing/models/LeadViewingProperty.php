<?php

namespace app\modules\lead_viewing\models;

use app\models\Leads;
use app\models\Rentals;
use app\models\Sale;
use Yii;

/**
 * This is the model class for table "lead_viewing_property".
 *
 * @property int $id
 * @property int $lead_viewing_id
 * @property int $property_id
 * @property int $type
 *
 * @property Leads $leadViewing
 */
class LeadViewingProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_viewing_property';
    }

    const TYPE_SALE = 1;
    const TYPE_RENTALS = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lead_viewing_id', 'property_id', 'type'], 'required'],
            [['lead_viewing_id', 'property_id', 'type'], 'integer'],
            [['lead_viewing_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadViewing::className(), 'targetAttribute' => ['lead_viewing_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lead_viewing_id' => Yii::t('app', 'Lead Viewing ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadViewing()
    {
        return $this->hasOne(LeadViewing::className(), ['id' => 'lead_viewing_id']);
    }

    public function getSales()
    {

    }

    public function getProperty()
    {
        if ($this->type == self::TYPE_SALE)
            return $this->hasOne(Sale::className(), ['id' => 'property_id']);
        elseif ($this->type == self::TYPE_RENTALS)
            return $this->hasOne(Rentals::className(), ['id' => 'property_id']);
    }

}
