<?php

namespace app\modules\lead\models;

use Yii;

/**
 * This is the model class for table "lead_source".
 *
 * @property int $id
 * @property string $auto
 * @property string $ref
 * @property string $type
 * @property string $status
 * @property string $sub_status
 * @property string $priority
 * @property string $hot_leadhot
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property string $category
 * @property string $emirate
 * @property string $location
 * @property string $sub_location
 * @property string $unit_type
 * @property string $unit_no
 * @property string $min_beds
 * @property string $max_beds
 * @property string $min_price
 * @property string $max_price
 * @property string $min_area
 * @property string $max_area
 * @property string $listing_ref
 * @property string $source
 * @property string $agent_1
 * @property string $agent_2
 * @property string $agent_3
 * @property string $agent_4
 * @property string $agent_5
 * @property string $created_by
 * @property string $finance
 * @property string $enquiry_date
 * @property string $updated
 * @property string $agent_referral
 * @property string $shared_leadS
 * @property string $contact_company
 * @property string $email_address
 * @property int $company_id
 */
class LeadSource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_source';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['auto', 'ref', 'type', 'status', 'sub_status', 'priority', 'hot_leadhot', 'first_name', 'last_name', 'mobile_no', 'category', 'emirate', 'location', 'sub_location', 'unit_type', 'unit_no', 'min_beds', 'max_beds', 'min_price', 'max_price', 'min_area', 'max_area', 'listing_ref', 'source', 'agent_1', 'agent_2', 'agent_3', 'agent_4', 'agent_5', 'created_by', 'finance', 'enquiry_date', 'updated', 'agent_referral', 'shared_leadS', 'contact_company', 'email_address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'auto' => Yii::t('app', 'Auto'),
            'ref' => Yii::t('app', 'Ref'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'sub_status' => Yii::t('app', 'Sub Status'),
            'priority' => Yii::t('app', 'Priority'),
            'hot_leadhot' => Yii::t('app', 'Hot Leadhot'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'mobile_no' => Yii::t('app', 'Mobile No'),
            'category' => Yii::t('app', 'Category'),
            'emirate' => Yii::t('app', 'Emirate'),
            'location' => Yii::t('app', 'Location'),
            'sub_location' => Yii::t('app', 'Sub Location'),
            'unit_type' => Yii::t('app', 'Unit Type'),
            'unit_no' => Yii::t('app', 'Unit No'),
            'min_beds' => Yii::t('app', 'Min Beds'),
            'max_beds' => Yii::t('app', 'Max Beds'),
            'min_price' => Yii::t('app', 'Min Price'),
            'max_price' => Yii::t('app', 'Max Price'),
            'min_area' => Yii::t('app', 'Min Area'),
            'max_area' => Yii::t('app', 'Max Area'),
            'listing_ref' => Yii::t('app', 'Listing Ref'),
            'source' => Yii::t('app', 'Source'),
            'agent_1' => Yii::t('app', 'Agent 1'),
            'agent_2' => Yii::t('app', 'Agent 2'),
            'agent_3' => Yii::t('app', 'Agent 3'),
            'agent_4' => Yii::t('app', 'Agent 4'),
            'agent_5' => Yii::t('app', 'Agent 5'),
            'created_by' => Yii::t('app', 'Created By'),
            'finance' => Yii::t('app', 'Finance'),
            'enquiry_date' => Yii::t('app', 'Enquiry Date'),
            'updated' => Yii::t('app', 'Updated'),
            'agent_referral' => Yii::t('app', 'Agent Referral'),
            'shared_leadS' => Yii::t('app', 'Shared Lead S'),
            'contact_company' => Yii::t('app', 'Contact Company'),
            'email_address' => Yii::t('app', 'Email Address'),
            'company_id' => Yii::t('app', 'Company ID'),
        ];
    }
}
