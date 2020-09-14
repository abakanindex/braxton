<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile_mobile_phones".
 *
 * @property int $id
 * @property int $user_id
 * @property int $mobile_phone
 */
class UserProfileMobilePhones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile_mobile_phones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'mobile_phone'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'mobile_phone' => Yii::t('app', 'Mobile Phone'),
        ];
    }
}
