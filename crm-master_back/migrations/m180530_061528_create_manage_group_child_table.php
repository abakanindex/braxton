<?php

use yii\db\Migration;

/**
 * Handles the creation of table `manage_group_child`.
 */
class m180530_061528_create_manage_group_child_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('manage_group_child', [
            'group_name' => $this->string(),
            'user_id'    => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('manage_group_child');
    }
}
