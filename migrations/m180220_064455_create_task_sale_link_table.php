<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_sale_link`.
 */
class m180220_064455_create_task_sale_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('task_sale_link', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'sale_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-task_sale_link-task_id',
            'task_sale_link',
            'task_id'
        );

        $this->addForeignKey(
            'fk-task_sale_link-task_id',
            'task_sale_link',
            'task_id',
            'task_manager',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-task_sale_link-sale_id',
            'task_sale_link',
            'sale_id'
        );

        $this->addForeignKey(
            'fk-task_sale_link-sale_id',
            'task_sale_link',
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
        $this->dropForeignKey(
            'fk-task_sale_link-task_id',
            'task_sale_link'
        );

        $this->dropIndex(
            'idx-task_sale_link-task_id',
            'task_sale_link'
        );
        $this->dropForeignKey(
            'fk-task_sale_link-sale_id',
            'task_sale_link'
        );

        $this->dropIndex(
            'idx-task_sale_link-sale_id',
            'task_sale_link'
        );
        $this->dropTable('task_sale_link');
    }
}
