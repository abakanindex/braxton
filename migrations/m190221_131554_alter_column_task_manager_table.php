<?php

use yii\db\Migration;

/**
 * Class m190221_131554_alter_column_task_manager_table
 */
class m190221_131554_alter_column_task_manager_table extends Migration
{
    public function up()
    {
        $this->alterColumn('task_manager', 'deadline', $this->timestamp()->null()->defaultValue(null));
    }

    public function down()
    {
        $this->alterColumn('task_manager', 'deadline', $this->integer(11)->null());
    }
}
