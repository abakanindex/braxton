<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grid_columns".
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property int $user_id
 */
class GridColumns extends \yii\db\ActiveRecord
{
    const TYPE_SALE    = 1;
    const TYPE_RENTAL  = 2;
    const TYPE_CONTACT = 3;
    const TYPE_LEAD    = 4;
    const TYPE_DEAL    = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grid_columns';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'user_id'], 'required'],
            [['type', 'user_id'], 'integer'],
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * Save checked column name for selected section
     * @param $name
     * @param $type
     * @param $userId
     */
    public static function add($name, $type, $userId)
    {
        $model = new GridColumns();
        $model->name    = $name;
        $model->type    = $type;
        $model->user_id = $userId;
        $model->save();
    }

    /**
     * get checked columns for grid - saved by user
     * @param $type
     * @param $userId
     * @return mixed
     */
    public static function getForSection($type, $userId)
    {
        return GridColumns::findAll([
            'type'    => $type,
            'user_id' => $userId
        ]);
    }

    /**
     * remove previously saved columns for grid
     * @param $type
     * @param $userId
     */
    public static function removeForSection($type, $userId)
    {
        GridColumns::deleteAll([
            'type'    => $type,
            'user_id' => $userId
        ]);
    }
}
