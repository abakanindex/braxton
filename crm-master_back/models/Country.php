<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $country_id
 * @property string $ru
 * @property string $ua
 * @property string $be
 * @property string $en
 * @property string $es
 * @property string $pt
 * @property string $de
 * @property string $fr
 * @property string $it
 * @property string $pl
 * @property string $ja
 * @property string $lt
 * @property string $lv
 * @property string $cz
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id'], 'required'],
            [['country_id'], 'integer'],
            [['ru', 'ua', 'be', 'en', 'es', 'pt', 'de', 'fr', 'it', 'pl', 'ja', 'lt', 'lv', 'cz'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => 'Country ID',
            'ru' => 'Ru',
            'ua' => 'Ua',
            'be' => 'Be',
            'en' => 'En',
            'es' => 'Es',
            'pt' => 'Pt',
            'de' => 'De',
            'fr' => 'Fr',
            'it' => 'It',
            'pl' => 'Pl',
            'ja' => 'Ja',
            'lt' => 'Lt',
            'lv' => 'Lv',
            'cz' => 'Cz',
        ];
    }
}
