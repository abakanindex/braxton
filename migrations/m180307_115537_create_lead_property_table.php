<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_property`.
 */
class m180307_115537_create_lead_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('lead_property', [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer(),
            'property_id' => $this->integer(),
            'type' => $this->integer(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('lead_property');
    }
}
