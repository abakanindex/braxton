<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company`.
 */
class m170927_190211_create_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company', [
            'id' => $this->primaryKey(),
            'company_name' => $this->string(100)->unique(),
            'employees_quantity' => $this->integer(11)->defaultValue(0),
            'owner_user_id' => $this->integer(),
            'status' => $this->integer(),
            'payment_status' => $this->integer(),
            'payment_plan' => $this->integer(),
        ]);

        $this->insert('company', ['company_name' => 'samsung', 'owner_user_id' => '2']);
        $this->insert('company', ['company_name' => 'aple', 'owner_user_id' => '2' ]);
        $this->insert('company', ['company_name' => 'huawey', 'owner_user_id' => '2']);
        $this->insert('company', ['company_name' => 'nano', 'owner_user_id' => '2']);
        $this->insert('company', ['company_name' => 'newnew', 'owner_user_id' => '0']);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('company');
    }
}
