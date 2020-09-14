<?php

use yii\db\Migration;
use app\models\TaskManager;

/**
 * Class m190226_162423_add_status_task_manager_table
 */
class m190226_162423_add_status_task_manager_table extends Migration
{
    public function up()
    {
        $this->addColumn(TaskManager::tableName(), 'status', $this->tinyInteger(1)->null()->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn(TaskManager::tableName(), 'status');
    }
}
