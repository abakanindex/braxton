<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_type`.
 */
class m171117_090454_create_event_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('event_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)
        ]);

        $this->insert('event_type', ['name' => 'Meeting']);
        $this->insert('event_type', ['name' => 'Task']);
        $this->insert('event_type', ['name' => 'Notes']);
        $this->insert('event_type', ['name' => 'Lead Viewings']);

        $this->createIndex(
            'idx-event-type',
            'event',
            'type'
        );

        $this->addForeignKey(
            'fk-event-type',
            'event',
            'type',
            'event_type',
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
            'fk-event-type',
            'event'
        );

        $this->dropIndex(
            'idx-event-type',
            'event'
        );

        $this->dropTable('event_type');
    }
}
