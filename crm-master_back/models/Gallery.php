<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property int $property_id
 * @property string $path
 * @property string $path_thumbnail
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'path_thumbnail', 'ref'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ref' => Yii::t('app', 'ref'),
            'path' => Yii::t('app', 'Path'),
            'path_thumbnail' => Yii::t('app', 'Path Thumbnail'),
        ];
    }
}
