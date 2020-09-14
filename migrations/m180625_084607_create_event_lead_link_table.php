<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_lead_link`.
 */
class m180625_084607_create_event_lead_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('event_lead_link', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'lead_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-event_lead_link-event_id',
            'event_lead_link',
            'event_id'
        );

        $this->addForeignKey(
            'fk-event_lead_link-event_id',
            'event_lead_link',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-event_lead_link-lead_id',
            'event_lead_link',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-event_lead_link-lead_id',
            'event_lead_link',
            'lead_id',
            'leads',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-event_lead_link-event_id',
            'event_lead_link'
        );

        $this->dropIndex(
            'idx-event_lead_link-event_id',
            'event_lead_link'
        );

        $this->dropForeignKey(
            'fk-event_lead_link-lead_id',
            'event_lead_link'
        );

        $this->dropIndex(
            'idx-event_lead_link-lead_id',
            'event_lead_link'
        );

        $this->dropTable('event_lead_link');
    }
}
