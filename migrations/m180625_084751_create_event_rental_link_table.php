<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_rental_link`.
 */
class m180625_084751_create_event_rental_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('event_rental_link', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'rental_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-event_rental_link-event_id',
            'event_rental_link',
            'event_id'
        );

        $this->addForeignKey(
            'fk-event_rental_link-event_id',
            'event_rental_link',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-event_rental_link-rental_id',
            'event_rental_link',
            'rental_id'
        );

        $this->addForeignKey(
            'fk-event_rental_link-rental_id',
            'event_rental_link',
            'rental_id',
            'rentals',
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
            'fk-event_rental_link-event_id',
            'event_rental_link'
        );

        $this->dropIndex(
            'idx-event_rental_link-event_id',
            'event_rental_link'
        );

        $this->dropForeignKey(
            'fk-event_rental_link-rental_id',
            'event_rental_link'
        );

        $this->dropIndex(
            'idx-event_rental_link-rental_id',
            'event_rental_link'
        );

        $this->dropTable('event_rental_link');
    }
}
