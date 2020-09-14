<?php

namespace app\modules\menu\models;

use Yii;

/**
 * This is the model class for table "menu_items".
 *
 * @property int $id
 * @property string $title
 * @property string $uri
 * @property int $status
 * @property string $class
 * @property string $icon
 */
class MenuItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_items';
    }

    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'uri', 'status',], 'required'],
            [['class', 'icon'], 'string'],
            [['status', 'parent_id'], 'integer'],
            [['title', 'uri', 'class', 'icon'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['parent_id'], 'safe'],
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
            'uri' => Yii::t('app', 'Uri'),
            'status' => Yii::t('app', 'Status'),
            'class' => Yii::t('app', 'Class'),
            'icon' => Yii::t('app', 'Icon'),
        ];
    }

    public function getParent()
    {
        return $this->hasOne(self::classname(), ['id' => 'parent_id'])->
        from(self::tableName() . ' AS parent');
    }
}
