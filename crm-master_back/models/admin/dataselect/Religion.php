<?php

namespace app\models\admin\dataselect;

use Yii;

/**
 * This is the model class for table "{{%religion}}".
 *
 * @property int $id
 * @property string $religions
 */
class Religion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%religion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['religions'], 'required'],
            [['religions'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'religions' => 'Religions',
        ];
    }

    /**
     * @inheritdoc
     * @return ReligionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReligionQuery(get_called_class());
    }
}
