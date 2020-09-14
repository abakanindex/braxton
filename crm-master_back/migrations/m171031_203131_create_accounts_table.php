<?php

use yii\db\Migration;

/**
 * Handles the creation of table `accounts`.
 */
class m171031_203131_create_accounts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        
        $this->createTable('accounts', [
            'id' => $this->primaryKey(),
            'user_name' => $this->string(),
            'password' => $this->string(),
            'user_role' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'email' => $this->string(),
            'mobile_number' => $this->string(),
            'job_title' => $this->string(),
            'department' => $this->string(),
            'office_tel' => $this->string(),
            'hobbies' => $this->string(),
            'mobile' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'rera_brn' => $this->string(),
            'rental_comm' => $this->string(),
            'sales_comm' => $this->string(),
            'languages_spoken' => $this->string(),
            'status' => $this->string(),
            'avatar' => $this->string(),
            'bio' => $this->string(),
            'edit_other_managers' => $this->string(),
            'permissions' => $this->string(),
            'excel_export' => $this->string(),
            'sms_allowed' => $this->string(),
            'listing_detail' => $this->string(),
            'can_assign_leads' => $this->string(),
            'show_owner' => $this->string(),
            'delete_data' => $this->string(),
            'edit_published_listings' => $this->string(),
            'access_time' => $this->string(),
            'hr_manager' => $this->string(),
            'agent_type' => $this->string(),
            'contact_lookup_broad_search' => $this->string(),
            'user_listing_sharing' => $this->string(),
            'user_screen_settings' => $this->string(),
            'enabled' => $this->string(),
            'imap' => $this->string(),
            'import_email_leads_email' => $this->string(),
            'import_email_leads_password' => $this->string(),
            'import_email_leads_port' => $this->string(),
            'categories' => $this->string(),
            'locations' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('accounts');
    }
}
