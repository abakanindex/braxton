<?php

namespace app\models;

use app\models\ref\Ref;
use Yii;
use app\models\statusHistory\ArchiveHistory;
use app\models\Company;
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string $ref
 * @property string $gender
 * @property string $first_name
 * @property string $last_name
 * @property int $company_id
 * @property string $home_address_1
 * @property string $home_address_2
 * @property string $home_city
 * @property string $home_state
 * @property string $home_country
 * @property string $home_zip_code
 * @property string $personal_phone
 * @property string $work_phone
 * @property string $home_fax
 * @property string $home_po_box
 * @property string $personal_mobile
 * @property string $personal_email
 * @property string $work_email
 * @property string $date_of_birth
 * @property string $designation
 * @property string $nationality
 * @property string $religion
 * @property string $title
 * @property string $work_mobile
 * @property string $assigned_to
 * @property string $updated
 * @property string $other_phone
 * @property string $other_mobile
 * @property string $work_fax
 * @property string $other_fax
 * @property string $other_email
 * @property string $website
 * @property string $facebook
 * @property string $twitter
 * @property string $linkedin
 * @property string $google
 * @property string $instagram
 * @property string $wechat
 * @property string $skype
 * @property string $company_po_box
 * @property string $company_address_1
 * @property string $company_address_2
 * @property string $company_city
 * @property string $company_state
 * @property string $company_country
 * @property string $company_zip_code
 * @property string $native_language
 * @property string $second_language
 * @property string $contact_source
 * @property string $contact_type
 * @property string $created_date
 * @property string $created_by
 * @property string $type
 * @property string $postal_code
 * @property string $po_box
 * @property bool $status
 */
class Contacts extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED   = 2;
    const STATUS_UNPUBLISHED = 1;

    public $email;

    public static $contactType = [
        self::CONTACT_TYPE_TENANT => 'Tenant',
        self::CONTACT_TYPE_BUYER => 'Buyer',
        self::CONTACT_TYPE_LANDLORD => 'LandLord',
        self::CONTACT_TYPE_SELLER => 'Seller',
        self::CONTACT_TYPE_LANDLORD_SELLER => 'LandLord+Seller',
        self::CONTACT_TYPE_REP_OF_LANDLORD => 'Rep. of Landlord',
        self::CONTACT_TYPE_AGENT => 'Agent',
        self::CONTACT_TYPE_OTHER => 'Other',
    ];

    const CONTACT_TYPE_TENANT          = 'Tenant';
    const CONTACT_TYPE_BUYER           = 'Buyer';
    const CONTACT_TYPE_LANDLORD        = 'LandLord';
    const CONTACT_TYPE_SELLER          = 'Seller';
    const CONTACT_TYPE_LANDLORD_SELLER = 'LandLord+Seller';
    const CONTACT_TYPE_REP_OF_LANDLORD = 'Rep. of Landlord';
    const CONTACT_TYPE_AGENT           = 'Agent';
    const CONTACT_TYPE_OTHER           = 'Other';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    const SCENARIO_EVENT = 'event';

    public function scenarios()
    {
        $scenarios                       = parent::scenarios();
        $scenarios[self::SCENARIO_EVENT] = ['work_email'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     * @param $insert
     * @return void
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (Yii::$app->controller->action->id === 'update') {

                $archive = new ArchiveHistory(self::findOne($this->id));
                $archive->addArchiveProperty(
                    $this->getDirtyAttributes(),
                    $this->getOldAttributes()
                );

            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['personal_mobile', 'personal_phone', 'work_mobile', 'other_mobile', 'work_phone', 'other_phone'], 'unique'],
            [['personal_email', 'work_email', 'other_email'], 'unique'],
            [['first_name', 'last_name'], 'required'],
            [
                [
                    'work_email',
                    'personal_email',
                    'other_email',
                    'personal_mobile',
                    'work_mobile',
                    'other_mobile',
                    'other_phone',
                    'personal_phone',
                    'work_phone'
                ],
                'atLeastOne',
                'skipOnEmpty' => false,
                'skipOnError' => false
            ],
            [['work_email', 'personal_email', 'other_email'], 'email'],
            [['company_id',  'created_by'], 'integer'],
            [
                [
                    'ref',
                    'gender',
                    'home_address_1',
                    'home_address_2',
                    'home_city',
                    'home_state',
                    'home_country',
                    'home_zip_code',
                    'personal_phone',
                    'work_phone',
                    'home_fax',
                    'home_po_box', 
                    'personal_mobile', 
                    'personal_email',
                    'date_of_birth', 
                    'designation', 
                    'nationality', 
                    'religion', 
                    'title', 
                    'work_mobile', 
                    'work_email',
                    'assigned_to',
                    'updated', 
                    'other_phone', 
                    'other_mobile', 
                    'work_fax', 
                    'other_fax', 
                    'other_email', 
                    'website', 
                    'facebook', 
                    'twitter', 
                    'linkedin', 
                    'google', 
                    'instagram', 
                    'wechat', 
                    'skype', 
                    'company_po_box', 
                    'company_address_1', 
                    'company_address_2', 
                    'company_city', 
                    'company_state', 
                    'company_country', 
                    'company_zip_code', 
                    'native_language', 
                    'second_language', 
                    'contact_source', 
                    'contact_type', 
                    'created_date',
                    'type',
                    'parsed_full_name',
                    'parsed_full_name_reverse',
                    'postal_code',
                    'po_box'
                ], 
                'string', 
                'max' => 255
            ],
        ];
    }

    public function atLeastOne($attribute, $params)
    {
        if (empty($this->work_email)
            && empty($this->personal_email)
            && empty($this->other_email)
            && empty($this->personal_mobile)
            && empty($this->work_mobile)
            && empty($this->other_mobile)
            && empty($this->other_phone)
            && empty($this->personal_phone)
            && empty($this->work_phone)) {
            $this->addError($attribute, Yii::t('app', 'At least 1 of the field must be filled up properly'));

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'ID'),
            'ref'               => Yii::t('app', 'Ref'),
            'gender'            => Yii::t('app', 'Gender'),
            'first_name'        => Yii::t('app', 'First Name'),
            'last_name'         => Yii::t('app', 'Last Name'),
            'company_id'        => Yii::t('app', 'Company'),
            'home_address_1'    => Yii::t('app', 'Home Address 1'),
            'home_address_2'    => Yii::t('app', 'Home Address 2'),
            'home_city'         => Yii::t('app', 'Home City'),
            'home_state'        => Yii::t('app', 'Home State'),
            'home_country'      => Yii::t('app', 'Home Country'),
            'home_zip_code'     => Yii::t('app', 'Home Zip Code'),
            'personal_phone'    => Yii::t('app', 'Personal Phone'),
            'work_phone'        => Yii::t('app', 'Work Phone'),
            'home_fax'          => Yii::t('app', 'Home Fax'),
            'home_po_box'       => Yii::t('app', 'Home Po Box'),
            'personal_mobile'   => Yii::t('app', 'Personal Mobile'),
            'personal_email'    => Yii::t('app', 'Personal Email'),
            'work_email'        => Yii::t('app', 'Work Email'),
            'date_of_birth'     => Yii::t('app', 'Date Of Birth'),
            'designation'       => Yii::t('app', 'Designation'),
            'nationality'       => Yii::t('app', 'Nationality'),
            'religion'          => Yii::t('app', 'Religion'),
            'title'             => Yii::t('app', 'Title'),
            'work_mobile'       => Yii::t('app', 'Work Mobile'),
            'assigned_to'       => Yii::t('app', 'Assigned To'),
            'updated'           => Yii::t('app', 'Updated'),
            'other_phone'       => Yii::t('app', 'Other Phone'),
            'other_mobile'      => Yii::t('app', 'Other Mobile'),
            'work_fax'          => Yii::t('app', 'Work Fax'),
            'other_fax'         => Yii::t('app', 'Other Fax'),
            'other_email'       => Yii::t('app', 'Other Email'),
            'website'           => Yii::t('app', 'Website'),
            'facebook'          => Yii::t('app', 'Facebook'),
            'twitter'           => Yii::t('app', 'Twitter'),
            'linkedin'          => Yii::t('app', 'Linkedin'),
            'google'            => Yii::t('app', 'Google'),
            'instagram'         => Yii::t('app', 'Instagram'),
            'wechat'            => Yii::t('app', 'Wechat'),
            'skype'             => Yii::t('app', 'Skype'),
            'company_po_box'    => Yii::t('app', 'Company Po Box'),
            'company_address_1' => Yii::t('app', 'Company Address 1'),
            'company_address_2' => Yii::t('app', 'Company Address 2'),
            'company_city'      => Yii::t('app', 'Company City'),
            'company_state'     => Yii::t('app', 'Company State'),
            'company_country'   => Yii::t('app', 'Company Country'),
            'company_zip_code'  => Yii::t('app', 'Company Zip Code'),
            'native_language'   => Yii::t('app', 'Native Language'),
            'second_language'   => Yii::t('app', 'Second Language'),
            'contact_source'    => Yii::t('app', 'Contact Source'),
            'contact_type'      => Yii::t('app', 'Contact Type'),
            'created_date'      => Yii::t('app', 'Created Date'),
            'created_by'        => Yii::t('app', 'Created By'),
            'type'              => Yii::t('app', 'Type'),
            'status'            => Yii::t('app', 'Status'),
            'postal_code'       => Yii::t('app', 'Postal Code'),
            'po_box'            => Yii::t('app', 'Po Box')
        ];
    }

    public static function getColumns($dataProvider, $searchModel, $genderList, $nationalities, $nationModel, $religions, $religionModel,
                                      $sources, $contactSourceModel, $contactType)
    {
        $companyUsers = ArrayHelper::map((new User())->getAllCompanyUsers(), 'id', 'username') ;
        $languages = ArrayHelper::map(Language::getAll(), 'id', 'name');
        $companies = ArrayHelper::map(Company::find()->all(), 'id', 'company_name');

        return [
            'gender' => [
                'attribute' => 'gender',
                'value' => function ($dataProvider) {
                    return $dataProvider->gender;
                },
                'filter' =>  Html::activeDropDownList($searchModel, 'gender', $genderList, ['class' => 'form-control', 'prompt' => '']),
            ],
            'date_of_birth' => 'date_of_birth',
            'nationality' => [
                'attribute' => 'nationality',
                'filter' =>  Html::activeDropDownList($searchModel, 'nationality', $nationalities, ['class' => 'form-control', 'prompt' => '']),
                'value' => function ($dataProvider) use ($nationModel) {
                    if ($dataProvider->nationality) {
                        $nationalities = $nationModel::findOne($dataProvider->nationality);
                        if ($nationalities) {
                            return $nationalities->national;
                        } else {
                            return "not set";
                        }
                    }
                },
            ],
            'religion' => [
                'attribute' => 'religion',
                'filter' =>  Html::activeDropDownList($searchModel, 'religion', $religions, ['class' => 'form-control', 'prompt' => '']),
                'value' => function ($dataProvider) use ($religionModel) {
                    if ($dataProvider->religion) {
                        $religion = $religionModel::findOne($dataProvider->religion);
                        if ($religion) {
                            return $religion->religions;
                        } else {
                            return "not set";
                        }
                    }
                },
            ],
            'native_language' => [
                'label' => self::instance()->getAttributeLabel('native_language'),
                'attribute' => 'native_language',
                'value' => function($dataProvider) use ($languages) {
                    return $languages[$dataProvider->native_language];
                },
                'filter' => Html::activeDropDownList($searchModel, 'native_language', $languages, ['class' => 'form-control', 'prompt' => ''])
            ],
            'second_language' => [
                'label' => self::instance()->getAttributeLabel('second_language'),
                'attribute' => 'second_language',
                'value' => function($dataProvider) use ($languages) {
                    return $languages[$dataProvider->second_language];
                },
                'filter' => Html::activeDropDownList($searchModel, 'second_language', $languages, ['class' => 'form-control', 'prompt' => ''])
            ],
            'personal_mobile' => 'personal_mobile',
            'personal_phone' => 'personal_phone',
            'personal_email' => 'personal_email:email',
            'home_address_1' => 'home_address_1',
            'home_address_2' => 'home_address_2',
            'facebook' => 'facebook',
            'twitter' => 'twitter',
            'google' => 'google',
            'linkedin' => 'linkedin',
            'skype' => 'skype',
            'wechat' => 'wechat',
            'instagram' => 'instagram',
            'contact_source' => [
                'label' => Yii::t('app', 'Contact Source'),
                'attribute' => 'contact_source',
                'value' => function ($dataProvider) use ($contactSourceModel) {
                    if ($dataProvider->contact_source) {
                        $contactSource = $contactSourceModel::findOne($dataProvider->contact_source);
                        if ($contactSource) {
                            return $contactSource->source;
                        } else {
                            return "not set";
                        }
                    }
                },
                'filter' =>  Html::activeDropDownList($searchModel,
                    'contact_source',
                    $sources,
                    ['class' => 'form-control', 'prompt' => '']
                ),
            ],
            'company_id' => [
                'attribute' => 'company_id',
                'value' => function ($dataProvider) use ($companies) {
                    return $companies[$dataProvider->company_id];
                },
                'filter' =>  Html::activeDropDownList($searchModel,
                    'company_id',
                    $companies,
                    ['class' => 'form-control', 'prompt' => '']
                ),
            ],
            'contact_type' => [
                'attribute' => 'contact_type',
                'value' => function ($dataProvider) {
                    return $dataProvider->contact_type;
                },
                'filter' =>  Html::activeDropDownList($searchModel,
                    'contact_type',
                    $contactType,
                    ['class' => 'form-control', 'prompt' => '']
                ),
            ],
            'created_by' => [
                'label' => self::instance()->getAttributeLabel('created_by'),
                'attribute' => 'created_by',
                'value' => function($dataProvider) {
                    return $dataProvider->createdBy->username;
                },
                'filter' => Html::activeDropDownList($searchModel,
                    'created_by',
                    $companyUsers,
                    ['class' => 'form-control', 'prompt' => '']
                )
            ],
            'postal_code' => 'postal_code',
            'po_box' => 'po_box'
        ];
    }

    //todo add company id everywhere
    public static function searchBy($value)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query
            ->select([
                's.*'
            ])
            ->from(self::tableName() . ' s')
            ->andWhere(['or',
                ['like', 's.ref', $value],
                ['like', 's.first_name', $value],
                ['like', 's.last_name', $value],
                ['like', 's.work_email', $value],
                ['like', 's.work_phone', $value],
                ['like', 's.work_mobile', $value],
                ['like', 's.home_address_1', $value],
                ['like', 's.home_address_2', $value],
                ['like', 's.personal_phone', $value],
                ['like', 's.personal_mobile', $value],
                ['like', 's.personal_email', $value],
                ['like', 's.other_phone', $value],
                ['like', 's.other_mobile', $value],
                ['like', 's.other_fax', $value],
                ['like', 's.other_email', $value],
                ['like', 's.title', $value]
            ])
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventGuests()
    {
        return $this->hasMany(EventGuest::className(), ['contact_id' => 'id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public static function find()
    {
        return parent::find()
            ->with('createdBy');
    }

    /**
     * @param string $text
     * @return array|null
     */
    public static function searchByName(string $text) : ?array
    {
        return self::find()
            ->where(['or',
                ['like', 'first_name', $text],
                ['like', 'last_name', $text]
            ])
            ->all();
    }
}
