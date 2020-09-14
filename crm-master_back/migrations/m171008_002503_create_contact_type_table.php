<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contact_Type`.
 */
class m171008_002503_create_contact_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('contact_type', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('contact_type');
    }
}
