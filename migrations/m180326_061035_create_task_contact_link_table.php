<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_contact_link`.
 */
class m180326_061035_create_task_contact_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('task_contact_link', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'contact_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-task_contact_link-task_id',
            'task_contact_link',
            'task_id'
        );

        $this->addForeignKey(
            'fk-task_contact_link-task_id',
            'task_contact_link',
            'task_id',
            'task_manager',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-task_contact_link-contact_id',
            'task_contact_link',
            'contact_id'
        );

        $this->addForeignKey(
            'fk-task_contact_link-contact_id',
            'task_contact_link',
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
            'fk-task_contact_link-task_id',
            'task_contact_link'
        );

        $this->dropIndex(
            'idx-task_contact_link-task_id',
            'task_contact_link'
        );

        $this->dropForeignKey(
            'fk-task_contact_link-contact_id',
            'task_contact_link'
        );

        $this->dropIndex(
            'idx-task_contact_link-contact_id',
            'task_contact_link'
        );

        $this->dropTable('task_contact_link');
    }
}
