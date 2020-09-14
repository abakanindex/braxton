<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_sale_link`.
 */
class m180625_084840_create_event_sale_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('event_sale_link', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer(),
            'sale_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-event_sale_link-event_id',
            'event_sale_link',
            'event_id'
        );

        $this->addForeignKey(
            'fk-event_sale_link-event_id',
            'event_sale_link',
            'event_id',
            'event',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-event_sale_link-sale_id',
            'event_sale_link',
            'sale_id'
        );

        $this->addForeignKey(
            'fk-event_sale_link-sale_id',
            'event_sale_link',
            'sale_id',
            'sale',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('event_sale_link');

        $this->dropForeignKey(
            'fk-event_sale_link-event_id',
            'event_sale_link'
        );

        $this->dropIndex(
            'idx-event_sale_link-event_id',
            'event_sale_link'
        );

        $this->dropForeignKey(
            'fk-event_sale_link-sale_id',
            'event_sale_link'
        );

        $this->dropIndex(
            'idx-event_sale_link-sale_id',
            'event_sale_link'
        );

        $this->dropTable('event_sale_link');
    }
}
