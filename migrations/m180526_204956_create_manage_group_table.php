<?php

use yii\db\Migration;

/**
 * Handles the creation of table `manage_group`.
 */
class m180526_204956_create_manage_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('manage_group', [
            'group_name'  => $this->string(),
            'description' => $this->string(),
            'company_id'  => $this->integer(),
        ]);

        $this->addPrimaryKey('group_users', 'manage_group' , ['group_name', 'company_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('manage_group');
    }
}
