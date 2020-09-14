<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_contact_link`.
 */
class m180625_084347_create_event_contact_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('event_contact_link', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'contact_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-event_contact_link-event_id',
            'event_contact_link',
            'event_id'
        );

        $this->addForeignKey(
            'fk-event_contact_link-event_id',
            'event_contact_link',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-event_contact_link-contact_id',
            'event_contact_link',
            'contact_id'
        );

        $this->addForeignKey(
            'fk-event_contact_link-contact_id',
            'event_contact_link',
            'contact_id',
            'contacts',
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
            'fk-event_contact_link-event_id',
            'event_contact_link'
        );

        $this->dropIndex(
            'idx-event_contact_link-event_id',
            'event_contact_link'
        );

        $this->dropForeignKey(
            'fk-event_contact_link-contact_id',
            'event_contact_link'
        );

        $this->dropIndex(
            'idx-event_contact_link-contact_id',
            'event_contact_link'
        );

        $this->dropTable('event_contact_link');
    }
}
