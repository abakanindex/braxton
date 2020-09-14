<?php

use yii\db\Migration;

/**
 * Handles the creation of table `departments`.
 */
class m180321_094924_create_departments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('departments', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'parent' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('departments');
    }
}
