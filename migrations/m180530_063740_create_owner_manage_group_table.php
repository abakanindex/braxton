<?php

use yii\db\Migration;

/**
 * Handles the creation of table `owner_manage_group`.
 */
class m180530_063740_create_owner_manage_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('owner_manage_group', [
            'group_name' => $this->string(),
            'owner_id'   => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('owner_manage_group');
    }
}
