<?php

use yii\db\Migration;

/**
 * Handles the creation of table `templates`.
 */
class m180709_055907_create_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('templates', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(2),
            'content' => $this->text(),
            'title' => $this->string(20),
            'company_id' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'created_at' => $this->integer(11),
            'created_by' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('templates');
    }
}
