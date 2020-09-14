<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_source`.
 */
class m180228_144700_create_lead_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('lead_source', [
            'id' => $this->primaryKey(),
            'auto' => $this->string(),
            'ref' => $this->string(),
            'type' => $this->string(),
            'status' => $this->string(),
            'sub_status' => $this->string(),
            'priority' => $this->string(),
            'hot_leadhot' => $this->string(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'mobile_no' => $this->string(),
            'category' => $this->string(),
            'emirate' => $this->string(),
            'location' => $this->string(),
            'sub_location' => $this->string(),
            'unit_type' => $this->string(),
            'unit_no' => $this->string(),
            'min_beds' => $this->string(),
            'max_beds' => $this->string(),
            'min_price' => $this->string(),
            'max_price' => $this->string(),
            'min_area' => $this->string(),
            'max_area' => $this->string(),
            'listing_ref' => $this->string(),
            'source' => $this->string(),
            'agent_1' => $this->string(),
            'agent_2' => $this->string(),
            'agent_3' => $this->string(),
            'agent_4' => $this->string(),
            'agent_5' => $this->string(),
            'created_by' => $this->string(),
            'finance' => $this->string(),
            'enquiry_date' => $this->string(),
            'updated' => $this->string(),
            'agent_referral' => $this->string(),
            'shared_leadS' => $this->string(),
            'contact_company' => $this->string(),
            'email_address' => $this->string(),
            'company_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('lead_source');
    }
}
