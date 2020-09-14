<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_status".
 *
 * @property int $id
 * @property string $title
 */
class UserStatus extends \yii\db\ActiveRecord
{
    public static $statuses = [
        1 => 'active',
        2 => 'not active'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    public function getUser()
    {
        return $this->hasMany(User::className(), ['id' => 'id']);
    }
}
