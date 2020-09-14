<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "font_awesome_icons_list".
 *
 * @property int $id
 * @property string $icon_class
 */
class FontAwesomeIconsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'font_awesome_icons_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['icon_class'], 'required'],
            [['icon_class'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'icon_class' => Yii::t('app', 'Icon Class'),
        ];
    }
}
