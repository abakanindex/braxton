<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_reponsible_user`.
 */
class m180323_091515_create_task_reponsible_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('task_responsible_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'task_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-task_responsible_user-user_id',
            'task_responsible_user',
            'user_id'
        );

        $this->addForeignKey(
            'fk-task_responsible_user-user_id',
            'task_responsible_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-task_responsible_user-task_id',
            'task_responsible_user',
            'task_id'
        );

        $this->addForeignKey(
            'fk-task_responsible_user-task_id',
            'task_responsible_user',
            'task_id',
            'task_manager',
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
            'fk-task_responsible_user-user_id',
            'task_responsible_user'
        );

        $this->dropIndex(
            'idx-task_responsible_user-user_id',
            'task_responsible_user'
        );

        $this->dropForeignKey(
            'fk-task_responsible_user-task_id',
            'task_responsible_user'
        );

        $this->dropIndex(
            'idx-task_responsible_user-task_id',
            'task_responsible_user'
        );
        
        $this->dropTable('task_reponsible_user');
    }
}
