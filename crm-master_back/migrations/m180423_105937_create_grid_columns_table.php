<?php

use yii\db\Migration;

/**
 * Handles the creation of table `grid_columns`.
 */
class m180423_105937_create_grid_columns_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('grid_columns', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-grid_columns-user_id',
            'grid_columns',
            'user_id'
        );

        $this->addForeignKey(
            'fk-grid_columns-user_id',
            'grid_columns',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('grid_columns');
    }
}
