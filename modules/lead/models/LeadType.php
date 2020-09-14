<?php

namespace app\modules\lead\models;

use Yii;

/**
 * This is the model class for table "lead_type".
 *
 * @property int $id
 * @property string $title
 * @property int $order
 */
class LeadType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_type';
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

    public static function getByTitle($title)
    {
        return self::findOne(['title' => $title]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTypes()
    {
        return self::find()->all();
    }
}
