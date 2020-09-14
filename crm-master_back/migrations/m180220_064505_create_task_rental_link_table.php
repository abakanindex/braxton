<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_rental_link`.
 */
class m180220_064505_create_task_rental_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('task_rental_link', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'rental_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-task_rental_link-task_id',
            'task_rental_link',
            'task_id'
        );

        $this->addForeignKey(
            'fk-task_rental_link-task_id',
            'task_rental_link',
            'task_id',
            'task_manager',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-task_rental_link-rental_id',
            'task_rental_link',
            'rental_id'
        );

        $this->addForeignKey(
            'fk-task_rental_link-rental_id',
            'task_rental_link',
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
            'fk-task_rental_link-task_id',
            'task_rental_link'
        );

        $this->dropIndex(
            'idx-task_rental_link-task_id',
            'task_rental_link'
        );
        $this->dropForeignKey(
            'fk-task_rental_link-rental_id',
            'task_rental_link'
        );

        $this->dropIndex(
            'idx-task_rental_link-rental_id',
            'task_rental_link'
        );
        $this->dropTable('task_rental_link');
    }
}
