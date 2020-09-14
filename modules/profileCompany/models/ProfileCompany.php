<?php

namespace app\modules\profileCompany\models;

use Yii;

/**
 * This is the model class for table "profile_company".
 *
 * @property int $id
 * @property string $company_name
 * @property string $rera_orn
 * @property string $trn
 * @property string $address
 * @property string $office_tel
 * @property string $office_fax
 * @property string $primary_email
 * @property string $website
 * @property string $company_profile
 * @property string $logo
 * @property string $watermark
 * @property string $prefix
 */
class ProfileCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [
                [
                    'company_name', 
                    'rera_orn', 
                    'trn', 
                    'address', 
                    'office_tel', 
                    'office_fax', 
                    'primary_email',
                    'website', 
                    'company_profile', 
                    'prefix',
                ],  'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_name'    => 'Company Name',
            'prefix'          => 'Prefix',
            'rera_orn'        => 'Rera Orn',
            'trn'             => 'Trn',
            'address'         => 'Address',
            'office_tel'      => 'Office Tel',
            'office_fax'      => 'Office Fax',
            'primary_email'   => 'Primary Email',
            'website'         => 'Website',
            'company_profile' => 'Company Profile',
            'logo'            => 'Logo',
            'watermark'       => 'Watermark',
            'company_id'      => 'Company id',
        ];
    }
}
