<?php

namespace app\models\reference_books;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "portals".
 *
 * @property int $id
 * @property string $portals
 */
class Portals extends \yii\db\ActiveRecord
{
    const PORTAL_DUBIZZLE               = 1;
    const PORTAL_BAYUT                  = 2;
    const PORTAL_PROPERTY_FINDER        = 3;
    const PORTAL_DUBIZZLE_UPDATE        = 4;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portals'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'portals' => Yii::t('app', 'Portals'),
        ];
    }

    public static function getPortals()
    {
        return (new Query())->select('')->from(self::tableName())->createCommand()->queryAll();
    }
    
}
