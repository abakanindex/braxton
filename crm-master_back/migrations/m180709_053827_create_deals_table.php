<?php

use yii\db\Migration;

/**
 * Handles the creation of table `deals`.
 */
class m180709_053827_create_deals_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('deals', [
            'id' => $this->primaryKey(),
            'ref' => $this->string(16),
            'type' => $this->integer(1),
            'created_at' => $this->integer(11),
            'model_id' => $this->integer(11),
            'lead_id' => $this->integer(11),
            'seller_id' => $this->integer(11),
            'buyer_id' => $this->integer(11),
            'company_id' => $this->integer(11),
            'status' => $this->integer(1),
            'sub_status' => $this->integer(1),
            'source' => $this->string(50),
            'deal_price' => $this->integer(6),
            'deposit' => $this->integer(6),
            'gross_commission' => $this->integer(6),
            'is_vat' => $this->integer(1),
            'is_external_referral' => $this->integer(1),
            'external_referral_name' => $this->string(255),
            'external_referral_type' => $this->integer(1),
            'external_referral_commission' => $this->integer(6),
            'your_company_commission' => $this->integer(6),
            'agent_1' => $this->integer(11),
            'agent_1_commission' => $this->integer(6),
            'agent_2' => $this->integer(11),
            'agent_2_commission' => $this->integer(6),
            'agent_3' => $this->integer(11),
            'agent_3_commission' => $this->integer(6),
            'cheques' => $this->integer(11),
            'estimated_date' => $this->integer(11),
            'actual_date' => $this->integer(11),
            'created_by' => $this->integer(11),
            'is_international' => $this->integer(1)->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('deals');
    }
}
