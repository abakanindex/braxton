<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%auth_controller_list}}".
 *
 * @property int $id
 * @property string $controller_id
 * @property string $action_id
 * @property string $description
 */
class AuthControllerList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_controller_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['controller_id', 'action_id'], 'string', 'max' => 255],
            [['unique_id'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'controller_id' => Yii::t('app', 'Controller ID'),
            'action_id' => Yii::t('app', 'Action ID'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
