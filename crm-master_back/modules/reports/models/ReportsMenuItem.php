<?php

namespace app\modules\reports\models;

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
class ReportsMenuItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reports_menu_item';
    }

    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status',], 'required'],
            [['class', 'icon', 'uri'], 'string'],
            [['status'], 'integer'],
            [['title', 'uri', 'class', 'icon'], 'string', 'max' => 255],
            [['parent_id', 'uri'], 'safe'],
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
            'uri' => Yii::t('app', 'uri'),
            'status' => Yii::t('app', 'Status'),
            'class' => Yii::t('app', 'Class'),
            'icon' => Yii::t('app', 'Icon'),
        ];
    }

    public function getParent()
    {
        return $this->hasOne(self::classname(), ['id' => 'parent_id'])->
        where(['status' => ReportsMenuItem::STATUS_ACTIVE])->
        from(self::tableName() . ' AS parent');
    }

    public function getChilds()
    {
        return $this->hasMany(self::classname(), ['parent_id' => 'id'])
            ->where(['status' => ReportsMenuItem::STATUS_ACTIVE])
            ->from(self::tableName() . ' AS childs')
            ->orderBy(['sort_order' => SORT_ASC]);
    }
}
