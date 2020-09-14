<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_lead_link`.
 */
class m180326_061024_create_task_lead_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('task_lead_link', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'lead_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-task_lead_link-task_id',
            'task_lead_link',
            'task_id'
        );

        $this->addForeignKey(
            'fk-task_lead_link-task_id',
            'task_lead_link',
            'task_id',
            'task_manager',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-task_lead_link-lead_id',
            'task_lead_link',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-task_lead_link-lead_id',
            'task_lead_link',
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
            'fk-task_lead_link-task_id',
            'task_lead_link'
        );

        $this->dropIndex(
            'idx-task_lead_link-task_id',
            'task_lead_link'
        );

        $this->dropForeignKey(
            'fk-task_lead_link-lead_id',
            'task_lead_link'
        );

        $this->dropIndex(
            'idx-task_lead_link-lead_id',
            'task_lead_link'
        );

        $this->dropTable('task_lead_link');
    }
}
