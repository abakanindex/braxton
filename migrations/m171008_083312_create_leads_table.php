<?php

use yii\db\Migration;

/**
 * Handles the creation of table `leads`.
 */
class m171008_083312_create_leads_table extends Migration
{
    public $path;
    
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('leads', [
            'id' => $this->primaryKey(),

            'reference' => $this->string(20),
            'type_id' => $this->integer(2),
            'status' => $this->integer(2),
            'sub_status_id' => $this->integer(2),
            'priority' => $this->integer(2),
            'hot_lead' => $this->string(),
            'first_name' => $this->string(100),
            'last_name' => $this->string(100),
            'mobile_number' => $this->string(30),
            'category_id' => $this->integer(3),
            'emirate' => $this->string(),
            'location' => $this->string(50),
            'sub_location' => $this->string(50),
            'unit_type' => $this->string(),
            'unit_number' => $this->string(),
            'min_beds' => $this->string(10),
            'max_beds' => $this->string(10),
            'min_price' => $this->string(20),
            'max_price' => $this->string(20),
            'min_area' => $this->string(20),
            'max_area' => $this->string(20),
            'source' => $this->integer(),
            'listing_ref' => $this->string(),
            'created_by_user_id' => $this->integer()->notNull(),
            'finance_type' => $this->integer(1),
            'enquiry_time' => $this->integer(),
            'updated_time' => $this->integer(),
            'agent_referrala' => $this->string(),
            'shared_leads' => $this->string(),
            'contract_company' => $this->string(100),
            'email' => $this->string(100),
            'slug' => $this->string(),
            'activity' => $this->integer(1)->defaultValue(1),
            'notes' => $this->text(),
            'email_opt_out' => $this->integer(1),
            'phone_opt_out' => $this->integer(1),
            'is_imported' => $this->integer(1),
            'company_id' => $this->integer(),
            'agent_1' => $this->string(),
            'agent_2' => $this->string(),
            'agent_3' => $this->string(),
            'agent_4' => $this->string(),
            'agent_5' => $this->string(),
            'is_parsed' => $this->integer(1)->defaultValue(0),
            'latitude'             => $this->float(),
            'longitude'            => $this->float()
        ]);

        $this->createIndex(
            'idx-leads-created_by_user_id',
            'leads',
            'created_by_user_id'
        );

        $this->addForeignKey(
            'fk-leads-created_by_user_id',
            'leads',
            'created_by_user_id',
            'user',
            'id',
            'CASCADE'
        );

        /*$this->createIndex(
            'idx-leads-company_id',
            'leads',
            'company_id'
        );

        $this->addForeignKey(
            'fk-leads-company_id',
            'leads',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );*/

        /*$this->path = 'migrations/_leads.sql';
        $this->execute(file_get_contents($this->path));*/
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-leads-created_by_user_id',
            'leads'
        );

        $this->dropIndex(
            'idx-leads-created_by_user_id',
            'leads'
        );

        /*$this->dropForeignKey(
            'fk-leads-company_id',
            'leads'
        );

        $this->dropIndex(
            'idx-leads-company_id',
            'leads'
        );*/

        $this->dropTable('leads');
    }
}
