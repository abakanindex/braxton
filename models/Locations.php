<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $parent_id
 */
class Locations extends \yii\db\ActiveRecord
{
    const TYPE_EMIRATE      = 1;
    const TYPE_LOCATION     = 2;
    const TYPE_SUB_LOCATION = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'parent_id' => 'Parent ID',
        ];
    }

    public function getChildren()
    {
        return $this->hasMany(Locations::className(), ['parent_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Locations::className(), ['id' => 'parent_id']);
    }

    public static function getByType($type)
    {
        return Locations::find()->where(['type' => $type])->with('children')->all();
    }

    public static function getLocationByType($type) {
        return (new Query())->select('')->from(self::tableName())->where('type=:type', [':type' => $type])->createCommand()->queryAll();
    }

    public static function getByParentId($parent_id)
    {
        return Locations::find()->where(['parent_id' => $parent_id])->with('children')->all();
    }

    public static function getByParentIdInRange($ids)
    {
        return self::find()->where(['in', 'parent_id', $ids])->all();
    }

    /*
     * Better use getAllLocations - without ActiveRecord
     */
    public static function getAll()
    {
        return Locations::find()->all();
    }

    public static function getAllLocations() {
        return (new Query())->select('')->from(self::tableName())->createCommand()->queryAll();
    }

    public static function getByName($name)
    {
        return Locations::find()->where(['name' => $name])->with('parent')->with('children')->one();
    }

    public static function getById($id)
    {
        return Locations::find()->where(['id' => $id])->with('parent')->with('children')->one();
    }

    public static function find()
    {
        return parent::find()->orderBy(['name' => SORT_ASC]);
    }
}
