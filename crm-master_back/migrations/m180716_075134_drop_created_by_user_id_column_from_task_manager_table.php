<?php

use yii\db\Migration;

/**
 * Handles dropping created_by_user_id from table `task_manager`.
 */
class m180716_075134_drop_created_by_user_id_column_from_task_manager_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->dropColumn('task_manager', 'created_by_user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->addColumn('task_manager', 'created_by_user_id', $this->integer());
    }
}
