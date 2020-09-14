<?php

namespace app\models\admin\dataselect;

use Yii;

/**
 * This is the model class for table "{{%contact_Source}}".
 *
 * @property int $id
 * @property string $source
 */
class ContactSource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact_source}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source' => 'Source',
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
