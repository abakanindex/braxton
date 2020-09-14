<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leads".
 *
 * @property int $id
 * @property string $auto
 * @property string $Ref
 * @property string $Type
 * @property string $Status
 * @property string $Sub Status
 * @property string $Priority
 * @property string $Hot LeadHot
 * @property string $First Name
 * @property string $Last Name
 * @property string $Mobile No
 * @property string $Category
 * @property string $Emirate
 * @property string $Location
 * @property string $Sub-location
 * @property string $Unit Type
 * @property string $Unit No
 * @property string $Min Beds
 * @property string $Max Beds
 * @property string $Min Price
 * @property string $Max Price
 * @property string $Min Area
 * @property string $Max Area
 * @property string $Listing Ref
 * @property string $Source
 * @property string $Agent 1
 * @property string $Agent 2
 * @property string $Agent 3
 * @property string $Agent 4
 * @property string $Agent 5
 * @property string $Created By
 * @property string $Finance
 * @property string $Enquiry Date
 * @property string $Updated
 * @property string $Agent Referrala
 * @property string $Shared LeadS
 * @property string $Contact Company
 * @property string $Email Address
 *
 * @property LeadAdditionalEmail[] $leadAdditionalEmails
 * @property LeadAgent[] $leadAgents
 * @property LeadSocialMediaContact[] $leadSocialMediaContacts
 * @property LeadViewing[] $leadViewings
 * @property PropertyRequirement[] $propertyRequirements
 */
class Leads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auto', 'Ref', 'Type', 'Status', 'Sub Status', 'Priority', 'Hot LeadHot', 'First Name', 'Last Name', 'Mobile No', 'Category', 'Emirate', 'Location', 'Sub-location', 'Unit Type', 'Unit No', 'Min Beds', 'Max Beds', 'Min Price', 'Max Price', 'Min Area', 'Max Area', 'Listing Ref', 'Source', 'Agent 1', 'Agent 2', 'Agent 3', 'Agent 4', 'Agent 5', 'Created By', 'Finance', 'Enquiry Date', 'Updated', 'Agent Referrala', 'Shared LeadS', 'Contact Company', 'Email Address'], 'string', 'max' => 255],
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
            'Ref' => Yii::t('app', 'Ref'),
            'Type' => Yii::t('app', 'Type'),
            'Status' => Yii::t('app', 'Status'),
            'Sub Status' => Yii::t('app', 'Sub  Status'),
            'Priority' => Yii::t('app', 'Priority'),
            'Hot LeadHot' => Yii::t('app', 'Hot  Lead Hot'),
            'First Name' => Yii::t('app', 'First  Name'),
            'Last Name' => Yii::t('app', 'Last  Name'),
            'Mobile No' => Yii::t('app', 'Mobile  No'),
            'Category' => Yii::t('app', 'Category'),
            'Emirate' => Yii::t('app', 'Emirate'),
            'Location' => Yii::t('app', 'Location'),
            'Sub-location' => Yii::t('app', 'Sub Location'),
            'Unit Type' => Yii::t('app', 'Unit  Type'),
            'Unit No' => Yii::t('app', 'Unit  No'),
            'Min Beds' => Yii::t('app', 'Min  Beds'),
            'Max Beds' => Yii::t('app', 'Max  Beds'),
            'Min Price' => Yii::t('app', 'Min  Price'),
            'Max Price' => Yii::t('app', 'Max  Price'),
            'Min Area' => Yii::t('app', 'Min  Area'),
            'Max Area' => Yii::t('app', 'Max  Area'),
            'Listing Ref' => Yii::t('app', 'Listing  Ref'),
            'Source' => Yii::t('app', 'Source'),
            'Agent 1' => Yii::t('app', 'Agent 1'),
            'Agent 2' => Yii::t('app', 'Agent 2'),
            'Agent 3' => Yii::t('app', 'Agent 3'),
            'Agent 4' => Yii::t('app', 'Agent 4'),
            'Agent 5' => Yii::t('app', 'Agent 5'),
            'Created By' => Yii::t('app', 'Created  By'),
            'Finance' => Yii::t('app', 'Finance'),
            'Enquiry Date' => Yii::t('app', 'Enquiry  Date'),
            'Updated' => Yii::t('app', 'Updated'),
            'Agent Referrala' => Yii::t('app', 'Agent  Referrala'),
            'Shared LeadS' => Yii::t('app', 'Shared  Lead S'),
            'Contact Company' => Yii::t('app', 'Contact  Company'),
            'Email Address' => Yii::t('app', 'Email  Address'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadAdditionalEmails()
    {
        return $this->hasMany(LeadAdditionalEmail::className(), ['lead_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadAgents()
    {
        return $this->hasMany(LeadAgent::className(), ['lead_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadSocialMediaContacts()
    {
        return $this->hasMany(LeadSocialMediaContact::className(), ['lead_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeadViewings()
    {
        return $this->hasMany(LeadViewing::className(), ['lead_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyRequirements()
    {
        return $this->hasMany(PropertyRequirement::className(), ['lead_id' => 'id']);
    }
}
