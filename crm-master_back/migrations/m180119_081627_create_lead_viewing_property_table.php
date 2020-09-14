<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_viewing_property`.
 */
class m180119_081627_create_lead_viewing_property_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lead_viewing_property', [
            'id' => $this->primaryKey(),
            'lead_viewing_id' => $this->integer()->notNull(),
            'property_id' => $this->integer()->notNull(),
            'type' => $this->integer(1)->notNull(),
        ]);

        $this->createIndex(
            'idx-lead_viewing_property-lead_viewing_id',
            'lead_viewing_property',
            'lead_viewing_id'
        );

        $this->addForeignKey(
            'fk-lead_viewing_property-lead_viewing_id',
            'lead_viewing_property',
            'lead_viewing_id',
            'lead_viewing',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-lead_viewing_property-lead_viewing_id',
            'lead_viewing_property'
        );

        $this->dropIndex(
            'idx-lead_viewing_property-lead_viewing_id',
            'lead_viewing_property'
        );

        $this->dropTable('lead_viewing_property');
    }
}
