<?php

namespace app\models\admin\dataselect;

use Yii;

/**
 * This is the model class for table "{{%title}}".
 *
 * @property int $id
 * @property string $titles
 */
class Title extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%title}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titles'], 'required'],
            [['titles'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titles' => 'Titles',
        ];
    }

    /**
     * @inheritdoc
     * @return TitleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TitleQuery(get_called_class());
    }
}
