<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_manager`.
 */
class m171214_231054_create_task_manager_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('task_manager', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'deadline' => $this->integer(),
            'remind' => $this->string(),
            'repeat' => $this->string(),
            'description' => $this->string(),
            'priority' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'company_id' => $this->integer(),
            'deadline_notificated' => $this->integer(1)->defaultValue(0),
            'owner_id' => $this->integer(),
            'listing_ref' => $this->string(),
            'created_by_user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-task_manager-owner_id',
            'task_manager',
            'owner_id'
        );

        $this->addForeignKey(
            'fk-task_manager-owner_id',
            'task_manager',
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
            'fk-task_manager-owner_id',
            'task_manager'
        );

        $this->dropIndex(
            'idx-task_manager-owner_id',
            'task_manager'
        );

        $this->dropTable('task_manager');
    }
}
