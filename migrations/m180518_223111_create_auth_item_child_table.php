<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth_item_child`.
 */
class m180518_223111_create_auth_item_child_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('auth_item_child', [
            'parent'     => $this->string(),
            'child'      => $this->string(),
            'company_id' => $this->integer(),
        ]);

        $this->addPrimaryKey('role_company_child', 'auth_item_child' , ['parent', 'child', 'company_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('auth_item_child');
    }
}
