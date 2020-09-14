<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_guest`.
 */
class m171120_143524_create_event_guest_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('event_guest', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'contact_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-event_guest-event',
            'event_guest',
            'event_id'
        );

        $this->addForeignKey(
            'fk-event_guest-event',
            'event_guest',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-event_guest-contact',
            'event_guest',
            'contact_id'
        );

        $this->addForeignKey(
            'fk-event_guest-contact',
            'event_guest',
            'contact_id',
            'contacts',
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
            'fk-event_guest-event',
            'event_guest'
        );

        $this->dropIndex(
            'idx-event_guest-event',
            'event_guest'
        );

        $this->dropForeignKey(
            'fk-event_guest-contact',
            'event_guest'
        );

        $this->dropIndex(
            'idx-event_guest-contact',
            'event_guest'
        );

        $this->dropTable('event_guest');
    }
}
