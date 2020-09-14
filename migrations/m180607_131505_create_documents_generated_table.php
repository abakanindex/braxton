<?php

use yii\db\Migration;

/**
 * Handles the creation of table `documents_generated`.
 */
class m180607_131505_create_documents_generated_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('documents_generated', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'path' => $this->string(),
            'created_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('documents_generated');
    }
}
