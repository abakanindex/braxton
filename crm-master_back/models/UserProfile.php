<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property int $accost_id
 * @property int $company_id
 * @property string $rental_comm
 * @property string $sales_comm
 * @property string $rera_brn
 * @property int $mobile_number
 * @property string $job_title
 * @property string $Department
 * @property int $office_tel
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'accost_id', 'company_id',], 'integer'],
            [['mobile_number', 'office_tel',], 'number',],
            [['first_name', 'last_name', 'rental_comm', 'sales_comm', 'rera_brn', 'job_title', 'Department', 'watermark'], 'safe'],
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
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'watermark' => Yii::t('app', 'Watermark'),
            'accost_id' => Yii::t('app', 'Accost ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'rental_comm' => Yii::t('app', 'Rental Comm'),
            'sales_comm' => Yii::t('app', 'Sales Comm'),
            'rera_brn' => Yii::t('app', 'Rera Brn'),
            'mobile_number' => Yii::t('app', 'Mobile Number'),
            'job_title' => Yii::t('app', 'Job Title'),
            'Department' => Yii::t('app', 'Department'),
            'office_tel' => Yii::t('app', 'Office Tel'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }

    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
