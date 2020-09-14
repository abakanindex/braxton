<?php

use yii\db\Migration;

/**
 * Handles the creation of table `employees_quantity`.
 */
class m171008_162016_create_employees_quantity_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('employees_quantity', [
            'id' => $this->primaryKey(),
            'value' => $this->string(255),
        ]);

        $this->insert('employees_quantity', ['value' => '1 - 10']);
        $this->insert('employees_quantity', ['value' => '11 - 50']);
        $this->insert('employees_quantity', ['value' => '51 - 100']);
        $this->insert('employees_quantity', ['value' => '101 - 500']);
        $this->insert('employees_quantity', ['value' => 'more then 500']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('employees_quantity');
    }
}
