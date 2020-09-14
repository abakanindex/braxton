<?php

use yii\db\Migration;

/**
 * Class m180726_133452_create_indexes
 */
class m180726_133452_create_indexes extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createIndex('category', 'sale', 'category_id');
        $this->createIndex('category', 'rentals', 'category_id');
        $this->createIndex('parent_id', 'locations', 'parent_id');
        $this->createIndex('type', 'locations', 'type');
    }

    public function down()
    {
        $this->dropIndex('category', 'sale');
        $this->dropIndex('category', 'rentals');
        $this->dropIndex('parent_id', 'locations');
        $this->dropIndex('type', 'locations');
    }
}
