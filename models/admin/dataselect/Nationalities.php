<?php

namespace app\models\admin\dataselect;

use Yii;

/**
 * This is the model class for table "{{%nationalities}}".
 *
 * @property int $id
 * @property string $national
 */
class Nationalities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nationalities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['national'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'national' => 'National',
        ];
    }

    /**
     * @inheritdoc
     * @return NationalitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NationalitiesQuery(get_called_class());
    }
}
