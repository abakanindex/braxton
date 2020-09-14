<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%accounts}}".
 *
 * @property int $id
 * @property string $user_name
 * @property string $password
 * @property string $user_role
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile_number
 * @property string $job_title
 * @property string $department
 * @property string $office_tel
 * @property string $hobbies
 * @property string $mobile
 * @property string $phone
 * @property string $rera_brn
 * @property string $rental_comm
 * @property string $sales_comm
 * @property string $languages_spoken
 * @property string $status
 * @property string $avatar
 * @property string $bio
 * @property string $edit_other_managers
 * @property string $permissions
 * @property string $excel_export
 * @property string $sms_allowed
 * @property string $listing_detail
 * @property string $can_assign_leads
 * @property string $show_owner
 * @property string $delete_data
 * @property string $edit_published_listings
 * @property string $access_time
 * @property string $hr_manager
 * @property string $agent_type
 * @property string $contact_lookup_broad_search
 * @property string $user_listing_sharing
 * @property string $user_screen_settings
 * @property string $enabled
 * @property string $imap
 * @property string $import_email_leads_email
 * @property string $import_email_leads_password
 * @property string $import_email_leads_port
 * @property string $categories
 * @property string $locations
 */
class Accounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%accounts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[],'required'],
            [['user_name', 'password', 'user_role', 'first_name', 'last_name', 'email', 'mobile_number', 'job_title', 'department', 'office_tel', 'hobbies', 'mobile', 'phone', 'rera_brn', 'rental_comm', 'sales_comm', 'languages_spoken', 'status', 'avatar', 'bio', 'edit_other_managers', 'permissions', 'excel_export', 'sms_allowed', 'listing_detail', 'can_assign_leads', 'show_owner', 'delete_data', 'edit_published_listings', 'access_time', 'hr_manager', 'agent_type', 'contact_lookup_broad_search', 'user_listing_sharing', 'user_screen_settings', 'enabled', 'imap', 'import_email_leads_email', 'import_email_leads_password', 'import_email_leads_port', 'categories', 'locations'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'password' => Yii::t('app', 'Password'),
            'user_role' => Yii::t('app', 'User Role'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'mobile_number' => Yii::t('app', 'Mobile Number'),
            'job_title' => Yii::t('app', 'Job Title'),
            'department' => Yii::t('app', 'Department'),
            'office_tel' => Yii::t('app', 'Office Tel'),
            'hobbies' => Yii::t('app', 'Hobbies'),
            'mobile' => Yii::t('app', 'Mobile'),
            'phone' => Yii::t('app', 'Phone'),
            'rera_brn' => Yii::t('app', 'Rera Brn'),
            'rental_comm' => Yii::t('app', 'Rental Comm'),
            'sales_comm' => Yii::t('app', 'Sales Comm'),
            'languages_spoken' => Yii::t('app', 'Languages Spoken'),
            'status' => Yii::t('app', 'Status'),
            'avatar' => Yii::t('app', 'Avatar'),
            'bio' => Yii::t('app', 'Bio'),
            'edit_other_managers' => Yii::t('app', 'Edit Other Managers'),
            'permissions' => Yii::t('app', 'Permissions'),
            'excel_export' => Yii::t('app', 'Excel Export'),
            'sms_allowed' => Yii::t('app', 'Sms Allowed'),
            'listing_detail' => Yii::t('app', 'Listing Detail'),
            'can_assign_leads' => Yii::t('app', 'Can Assign Leads'),
            'show_owner' => Yii::t('app', 'Show Owner'),
            'delete_data' => Yii::t('app', 'Delete Data'),
            'edit_published_listings' => Yii::t('app', 'Edit Published Listings'),
            'access_time' => Yii::t('app', 'Access Time'),
            'hr_manager' => Yii::t('app', 'Hr Manager'),
            'agent_type' => Yii::t('app', 'Agent Type'),
            'contact_lookup_broad_search' => Yii::t('app', 'Contact Lookup Broad Search'),
            'user_listing_sharing' => Yii::t('app', 'User Listing Sharing'),
            'user_screen_settings' => Yii::t('app', 'User Screen Settings'),
            'enabled' => Yii::t('app', 'Enabled'),
            'imap' => Yii::t('app', 'Imap'),
            'import_email_leads_email' => Yii::t('app', 'Import Email Leads Email'),
            'import_email_leads_password' => Yii::t('app', 'Import Email Leads Password'),
            'import_email_leads_port' => Yii::t('app', 'Import Email Leads Port'),
            'categories' => Yii::t('app', 'Categories'),
            'locations' => Yii::t('app', 'Locations'),
        ];
    }
}
