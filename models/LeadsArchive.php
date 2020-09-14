<?php

namespace app\models;

use app\models\reference_books\PropertyCategory;
use app\modules\lead\models\CompanySource;
use app\modules\lead\models\LeadAdditionalEmail;
use app\modules\lead\models\LeadSocialMediaContact;
use app\modules\lead\models\LeadSubStatus;
use app\modules\lead\models\LeadType;
use app\modules\lead\models\PropertyRequirement;
use Yii;
use app\interfaces\leads\iLeads;
use app\modules\admin\models\OwnerManageGroup;

/**
 * This is the model class for table "leads_archive".
 *
 * @property int $id
 * @property string $reference
 * @property int $type_id
 * @property int $status
 * @property int $sub_status_id
 * @property int $priority
 * @property string $hot_lead
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property int $category_id
 * @property string $emirate
 * @property string $location
 * @property string $sub_location
 * @property string $unit_type
 * @property string $unit_number
 * @property int $min_beds
 * @property int $max_beds
 * @property int $min_price
 * @property int $max_price
 * @property int $min_area
 * @property int $max_area
 * @property int $source
 * @property string $listing_ref
 * @property int $created_by_user_id
 * @property int $finance_type
 * @property int $enquiry_time
 * @property int $updated_time
 * @property string $agent_referrala
 * @property string $shared_leads
 * @property string $contract_company
 * @property string $email
 * @property string $slug
 * @property int $activity
 * @property string $notes
 * @property int $email_opt_out
 * @property int $phone_opt_out
 * @property int $is_imported
 * @property int $company_id
 * @property string $agent_1
 * @property string $agent_2
 * @property string $agent_3
 * @property string $agent_4
 * @property string $agent_5
 * @property int $is_parsed
 * @property User $createdByUser
 * @property double $latitude
 * @property double $longitude
 */
class LeadsArchive extends \yii\db\ActiveRecord implements iLeads
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_archive';
    }

    public static $statuses = [
        self::STATUS_OPEN,
        self::STATUS_CLOSED,
        self::STATUS_CLOSED,
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'status', 'sub_status_id', 'priority', 'category_id', 'min_beds', 'max_beds', 'min_price', 'max_price', 'min_area', 'max_area', 'source', 'created_by_user_id', 'finance_type', 'enquiry_time', 'updated_time', 'activity', 'email_opt_out', 'phone_opt_out', 'is_imported', 'company_id', 'is_parsed'], 'integer'],
            [['created_by_user_id'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['notes'], 'string'],
            [['reference'], 'string', 'max' => 20],
            [['hot_lead', 'emirate', 'unit_type', 'unit_number', 'listing_ref', 'agent_referrala', 'shared_leads', 'slug', 'agent_1', 'agent_2', 'agent_3', 'agent_4', 'agent_5'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'contract_company', 'email'], 'string', 'max' => 100],
            [['mobile_number'], 'string', 'max' => 30],
            [['location', 'sub_location'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference' => 'Reference',
            'type_id' => 'Type ID',
            'status' => 'Status',
            'sub_status_id' => 'Sub Status ID',
            'priority' => 'Priority',
            'hot_lead' => 'Hot Lead',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'mobile_number' => 'Mobile Number',
            'category_id' => 'Category ID',
            'emirate' => 'Emirate',
            'location' => 'Location',
            'sub_location' => 'Sub Location',
            'unit_type' => 'Unit Type',
            'unit_number' => 'Unit Number',
            'min_beds' => 'Min Beds',
            'max_beds' => 'Max Beds',
            'min_price' => 'Min Price',
            'max_price' => 'Max Price',
            'min_area' => 'Min Area',
            'max_area' => 'Max Area',
            'source' => 'Source',
            'listing_ref' => 'Listing Ref',
            'created_by_user_id' => 'Created By User ID',
            'finance_type' => 'Finance Type',
            'enquiry_time' => 'Enquiry Time',
            'updated_time' => 'Updated Time',
            'agent_referrala' => 'Agent Referrala',
            'shared_leads' => 'Shared Leads',
            'contract_company' => 'Contract Company',
            'email' => 'Email',
            'slug' => 'Slug',
            'activity' => 'Activity',
            'notes' => 'Notes',
            'email_opt_out' => 'Email Opt Out',
            'phone_opt_out' => 'Phone Opt Out',
            'is_imported' => 'Is Imported',
            'company_id' => 'Company ID',
            'agent_1' => 'Agent 1',
            'agent_2' => 'Agent 2',
            'agent_3' => 'Agent 3',
            'agent_4' => 'Agent 4',
            'agent_5' => 'Agent 5',
            'is_parsed' => 'Is Parsed',
            'latitude'            => Yii::t('app', 'Latitude'),
            'longitude'           => Yii::t('app', 'Longitude')
        ];
    }

    public function getType()
    {
        return LeadType::findOne(['id' => $this->type_id])->title;
    }

    public static function findType($type)
    {
        return LeadType::findOne(['id' => $type])->title;
    }

    public function getEmirateRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'emirate']);
    }

    public function getLocationRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'location']);
    }

    public function getSubLocationRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'sub_location']);
    }

    public function getLeadType()
    {
        return $this->hasOne(LeadType::className(), ['id' => 'type_id']);
    }

    public function getSubStatus()
    {
        return $this->hasOne(LeadSubStatus::className(), ['id' => 'sub_status_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'category_id']);
    }

    public function getPropertyRequirements()
    {
        return $this->hasMany(PropertyRequirement::className(), ['lead_id' => 'id']);
    }

    public function getCreatedUserFullname()
    {
        if ($this->createdByUser->userProfile)
            return $this->createdByUser->userProfile->getFullname();
        else return '';
    }

    public static function find()
    {
        return parent::find()->with('emirateRecord')->with('locationRecord')->with('subLocationRecord');
    }

    public function getCompanySource()
    {
        return $this->hasOne(CompanySource::className(), ['id' => 'source']);
    }

    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by_user_id'])->from(User::tableName() . ' u2');;
    }

    public function getAdditionalEmailsList()
    {
        return $this->hasMany(LeadAdditionalEmail::className(), ['lead_id' => 'id']);
    }

    public function getLeadSocialMeadiaContacts()
    {
        return $this->hasMany(LeadSocialMediaContact::className(), ['lead_id' => 'id']);
    }

    public function getStatus()
    {
        switch ($this->status) {
            case self::STATUS_OPEN:
                return Yii::t('app', 'Open');
            case self::STATUS_CLOSED:
                return Yii::t('app', 'Closed');
            case self::STATUS_NOT_SPECIFIED:
                return Yii::t('app', 'Not Specified');
        }
    }

    public function getPriority()
    {
        switch ($this->priority) {
            case self::PRIORITY_URGENT:
                return Yii::t('app', 'Urgent');
            case self::PRIORITY_HIGH:
                return Yii::t('app', 'High');
            case self::PRIORITY_NORMAL:
                return Yii::t('app', 'Normal');
            case self::PRIORITY_LOW:
                return Yii::t('app', 'Low');
        }
    }

    public function getFinanceType()
    {
        switch ($this->finance_type) {
            case self::FINANCE_TYPE_CASH:
                return Yii::t('app', 'Cash');
            case self::FINANCE_TYPE_LOAN_APPROVED:
                return Yii::t('app', 'Loan (approved)');
            case self::FINANCE_TYPE_LOAN_NOT_APPROVED:
                return Yii::t('app', 'Loan (not approved)');
        }
    }
}
