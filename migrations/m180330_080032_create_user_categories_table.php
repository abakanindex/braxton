<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_categories`.
 */
class m180330_080032_create_user_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('user_categories', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            'idx-user_categories-category_id',
            'user_categories',
            'category_id'
        );

        $this->addForeignKey(
            'fk-user_categories-category_id',
            'user_categories',
            'category_id',
            'property_category',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_categories-user_id',
            'user_categories',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_categories-user_id',
            'user_categories',
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
        $this->dropForeignKey(
            'fk-user_categories-category_id',
            'user_categories'
        );

        $this->dropIndex(
            'idx-user_categories-category_id',
            'user_categories'
        );

        $this->dropForeignKey(
            'fk-user_categories-user_id',
            'user_categories'
        );

        $this->dropIndex(
            'idx-user_categories-user_id',
            'user_categories'
        );

        $this->dropTable('user_categories');
    }
}
