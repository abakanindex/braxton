<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contacts`.
 */
class m170929_100854_create_contacts_table extends Migration
{
    public $path;
    
    /**
     * @inheritdoc
     */
    public function up()
    {
        /*$this->createTable('contacts', [
            'id' => $this->primaryKey(),
            'Ref'=>$this->string(),
            'Gender'=>$this->string(),
            'First_Name'=>$this->string(),
            'Last_Name'=>$this->string(),
            'Company'=>$this->string(),
            'Home_Address_1'=>$this->string(),
            'Home_Address_2'=>$this->string(),
            'Home_City'=>$this->string(),
            'Home_State'=>$this->string(),
            'Home_Country'=>$this->string(),
            'Home_Zip_Code'=>$this->string(),
            'Personal_Phone'=>$this->string(),
            'Work_Phone'=>$this->string(),
            'Home_Fax'=>$this->string(),
            'Home_PO_Box'=>$this->string(),
            'Personal_Mobile'=>$this->string(),
            'Personal_Email'=>$this->string(),
            'Work_Email'=>$this->string(),
            'Date_Of_Birth'=>$this->string(),
            'Designation'=>$this->string(),
            'Nationality'=>$this->string(),
            'Religion'=>$this->string(),
            'Title'=>$this->string(),
            'Work_Mobile'=>$this->string(),
            'Assigned_To'=>$this->string(),
            'Updated'=>$this->string(),
            'Other_Phone'=>$this->string(),
            'Other_Mobile'=>$this->string(),
            'Work_Fax'=>$this->string(),
            'Other_Fax'=>$this->string(),
            'Other_Email'=>$this->string(),
            'Facebook'=>$this->string(),
            'Twitter'=>$this->string(),
            'LinkedIn'=>$this->string(),
            'Google+'=>$this->string(),
            'Instagram'=>$this->string(),
            'WeChat'=>$this->string(),
            'Skype'=>$this->string(),
            'Company_PO_Box'=>$this->string(),
            'Company_Address_1'=>$this->string(),
            'Company_Address_2'=>$this->string(),
            'Company_City'=>$this->string(),
            'Company_State'=>$this->string(),
            'Company_Country'=>$this->string(),
            'Company_Zip_Code'=>$this->string(),
            'Native_Language'=>$this->string(),
            'Second_Language'=>$this->string(),
            'Contact_Source'=>$this->string(),
            'Contact_Type'=>$this->string(),
            'Created_Date'=>$this->string(),
            'Created_By'=>$this->string(),
            'Type'=>$this->string(),
            'company_id' => $this->integer(),
        ]);*/
        $this->createTable('contacts', [
            'id' => $this->primaryKey(),
            'ref' => $this->string(),
            'gender' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'company_id' => $this->integer(),
            'home_address_1' => $this->string(),
            'home_address_2' => $this->string(),
            'home_city' => $this->string(),
            'home_state' => $this->string(),
            'home_country' => $this->string(),
            'home_zip_code' => $this->string(),
            'personal_phone' => $this->string(),
            'work_phone' => $this->string(),
            'home_fax' => $this->string(),
            'home_po_box' => $this->string(),
            'personal_mobile' => $this->string(),
            'personal_email' => $this->string(),
            'work_email' => $this->string(),
            'date_of_birth' => $this->string(),
            'designation' => $this->string(),
            'nationality' => $this->string(),
            'religion' => $this->string(),
            'title' => $this->string(),
            'work_mobile' => $this->string(),
            'assigned_to' => $this->string(),
            'updated' => $this->string(),
            'other_phone' => $this->string(),
            'other_mobile' => $this->string(),
            'work_fax' => $this->string(),
            'other_fax' => $this->string(),
            'other_email' => $this->string(),
            'website' => $this->string(),
            'facebook' => $this->string(),
            'twitter' => $this->string(),
            'linkedin' => $this->string(),
            'google' => $this->string(),
            'instagram' => $this->string(),
            'wechat' => $this->string(),
            'skype' => $this->string(),
            'company_po_box' => $this->string(),
            'company_address_1' => $this->string(),
            'company_address_2' => $this->string(),
            'company_city' => $this->string(),
            'company_state' => $this->string(),
            'company_country' => $this->string(),
            'company_zip_code' => $this->string(),
            'native_language' => $this->string(),
            'second_language' => $this->string(),
            'contact_source' => $this->string(),
            'contact_type' => $this->string(),
            'created_date' => $this->string(),
            'created_by' => $this->string(),
            'type' => $this->string(),
            'created_by_user_id' => $this->integer()->notNull(),
        ]);

        /*$this->path = 'migrations/_contacts.sql';
        $this->execute(file_get_contents($this->path));*/
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('contacts');
    }
}
