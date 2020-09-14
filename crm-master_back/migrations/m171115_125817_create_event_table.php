<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event`.
 */
class m171115_125817_create_event_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer()->notNull(),
            'start' => $this->integer(),
            'end' => $this->integer(),
            'type' => $this->integer(1),
            'title' => $this->string(100),
            'location' => $this->string(100),
            'description' => $this->text(),
            'ref_leads' => $this->integer(),
            'ref_listings' => $this->integer(),
            'ref_deals' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-event-owner_id',
            'event',
            'owner_id'
        );

        $this->addForeignKey(
            'fk-event-owner_id',
            'event',
            'owner_id',
            'user',
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
            'fk-event-owner_id',
            'post'
        );

        $this->dropIndex(
            'idx-event-owner_id',
            'event'
        );

        $this->dropTable('event');
    }
}
