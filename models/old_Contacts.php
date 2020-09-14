<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
/**
 * This is the model class for table "{{%contacts}}".
 *
 * @property int $id
 * @property string $assigned_to
 * @property string $ref
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $date_of_birth
 * @property string $nationalities
 * @property string $religion
 * @property string $languagesd
 * @property string $hobbies
 * @property string $mobile
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $fb
 * @property string $tw
 * @property string $linkedin
 * @property string $skype
 * @property string $googlplus
 * @property string $wechat
 * @property string $in
 * @property string $contact_source
 * @property string $company_name
 * @property string $designation
 * @property string $contact_type
 * @property string $created_by
 * @property string $notes
 * @property string $documents
 */
class Contacts extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'ref',
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contacts}}';
    }

    const SCENARIO_EVENT = 'event';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_EVENT] = ['email'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[], 'required'],
            [['assigned_to', 'ref', 'title', 'first_name', 'last_name', 'gender', 'date_of_birth', 'nationalities', 'religion', 'languagesd', 'hobbies', 'mobile', 'phone', 'email', 'address', 'fb', 'tw', 'linkedin', 'skype', 'googlplus', 'wechat', 'in', 'contact_source', 'company_name', 'designation', 'contact_type', 'created_by', 'notes', 'documents', 'avatar'], 'safe'],

            [['email'], 'trim', 'on' => self::SCENARIO_EVENT],
            [['email'], 'required', 'on' => self::SCENARIO_EVENT],
            [['email'], 'email', 'on' => self::SCENARIO_EVENT],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'assigned_to' => Yii::t('app', 'Assigned To'),
            'ref' => Yii::t('app', 'Ref'),
            'title' => Yii::t('app', 'Title'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'date_of_birth' => Yii::t('app', 'Date Of Birth'),
            'nationalities' => Yii::t('app', 'Nationalities'),
            'religion' => Yii::t('app', 'Religion'),
            'languagesd' => Yii::t('app', 'Languagesd'),
            'hobbies' => Yii::t('app', 'Hobbies'),
            'mobile' => Yii::t('app', 'Mobile'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'address' => Yii::t('app', 'Address'),
            'fb' => Yii::t('app', 'Fb'),
            'tw' => Yii::t('app', 'Tw'),
            'linkedin' => Yii::t('app', 'Linkedin'),
            'skype' => Yii::t('app', 'Skype'),
            'googlplus' => Yii::t('app', 'googlplus'),
            'wechat' => Yii::t('app', 'Wechat'),
            'in' => Yii::t('app', 'In'),
            'contact_source' => Yii::t('app', 'Contact Source'),
            'company_name' => Yii::t('app', 'Company Name'),
            'designation' => Yii::t('app', 'Designation'),
            'contact_type' => Yii::t('app', 'Contact Type'),
            'created_by' => Yii::t('app', 'Created By'),
            'notes' => Yii::t('app', 'Notes'),
            'documents' => Yii::t('app', 'Documents'),
            'avatar' => Yii::t('app', 'Avatar'),
        ];
    }

}
