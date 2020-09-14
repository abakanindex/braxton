<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts_archive".
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
 */
class ContactsArchive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts_archive';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'created_by'], 'integer'],
            [['ref', 'gender', 'first_name', 'last_name', 'home_address_1', 'home_address_2', 'home_city', 'home_state', 'home_country', 'home_zip_code', 'personal_phone', 'work_phone', 'home_fax', 'home_po_box', 'personal_mobile', 'personal_email', 'work_email', 'date_of_birth', 'designation', 'nationality', 'religion', 'title', 'work_mobile', 'assigned_to', 'updated', 'other_phone', 'other_mobile', 'work_fax', 'other_fax', 'other_email', 'website', 'facebook', 'twitter', 'linkedin', 'google', 'instagram', 'wechat', 'skype', 'company_po_box', 'company_address_1', 'company_address_2', 'company_city', 'company_state', 'company_country', 'company_zip_code', 'native_language', 'second_language', 'contact_source', 'contact_type', 'created_date', 'type', 'parsed_full_name', 'parsed_full_name_reverse'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref' => 'Ref',
            'gender' => 'Gender',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'company_id' => 'Company ID',
            'home_address_1' => 'Home Address 1',
            'home_address_2' => 'Home Address 2',
            'home_city' => 'Home City',
            'home_state' => 'Home State',
            'home_country' => 'Home Country',
            'home_zip_code' => 'Home Zip Code',
            'personal_phone' => 'Personal Phone',
            'work_phone' => 'Work Phone',
            'home_fax' => 'Home Fax',
            'home_po_box' => 'Home Po Box',
            'personal_mobile' => 'Personal Mobile',
            'personal_email' => 'Personal Email',
            'work_email' => 'Work Email',
            'date_of_birth' => 'Date Of Birth',
            'designation' => 'Designation',
            'nationality' => 'Nationality',
            'religion' => 'Religion',
            'title' => 'Title',
            'work_mobile' => 'Work Mobile',
            'assigned_to' => 'Assigned To',
            'updated' => 'Updated',
            'other_phone' => 'Other Phone',
            'other_mobile' => 'Other Mobile',
            'work_fax' => 'Work Fax',
            'other_fax' => 'Other Fax',
            'other_email' => 'Other Email',
            'website' => 'Website',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'linkedin' => 'Linkedin',
            'google' => 'Google',
            'instagram' => 'Instagram',
            'wechat' => 'Wechat',
            'skype' => 'Skype',
            'company_po_box' => 'Company Po Box',
            'company_address_1' => 'Company Address 1',
            'company_address_2' => 'Company Address 2',
            'company_city' => 'Company City',
            'company_state' => 'Company State',
            'company_country' => 'Company Country',
            'company_zip_code' => 'Company Zip Code',
            'native_language' => 'Native Language',
            'second_language' => 'Second Language',
            'contact_source' => 'Contact Source',
            'contact_type' => 'Contact Type',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'type' => 'Type',
        ];
    }
}
