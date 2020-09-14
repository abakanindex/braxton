<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment_plan`.
 */
class m171124_121015_create_payment_plan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment_plan', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'max_users' => $this->integer(),
        ]);

        $this->insert('payment_plan', ['title' => 'Minor', 'max_users' => 10]);
        $this->insert('payment_plan', ['title' => 'Standart', 'max_users' => 25]);
        $this->insert('payment_plan', ['title' => 'Standart+', 'max_users' => 50]);
        $this->insert('payment_plan', ['title' => 'Corporate', 'max_users' => 100]);
        $this->insert('payment_plan', ['title' => 'Corporate+', 'max_users' => 500]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payment_plan');
    }
}
