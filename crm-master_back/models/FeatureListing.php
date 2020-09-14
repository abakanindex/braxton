<?php

namespace app\models;

use app\models\reference_books\Features;
use Yii;

/**
 * This is the model class for table "feature_listing".
 *
 * @property int $id
 * @property string $ref
 * @property int $feature_id
 * @property int $type
 *
 * @property Features $feature
 */
class FeatureListing extends \yii\db\ActiveRecord
{
    const TYPE_SALE   = 1;
    const TYPE_RENTAL = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feature_listing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feature_id', 'type'], 'integer'],
            [['ref'], 'string', 'max' => 255],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Features::className(), 'targetAttribute' => ['feature_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'ref'        => 'Ref',
            'feature_id' => 'Feature ID',
            'type'       => 'Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(Features::className(), ['id' => 'feature_id']);
    }

    public static function deleteByRef($ref)
    {
        self::deleteAll(['ref' => $ref]);
    }
}
