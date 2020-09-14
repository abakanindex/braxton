<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth_assignment`.
 */
class m180517_204702_create_auth_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('auth_assignment', [
            'item_name'  => $this->string(),
            'user_id'    => $this->string(),
            'created_at' => $this->integer(),
        ]);
        $this->addPrimaryKey('permission', 'auth_assignment' , ['user_id']);
        $this->insert('auth_assignment' , ['item_name' => 'Owner', 'user_id' => '1',]);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('auth_assignment');
    }
}
