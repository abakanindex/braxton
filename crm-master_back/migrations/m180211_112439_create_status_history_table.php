<?php

use yii\db\Migration;

/**
 * Handles the creation of table `status_history`.
 */
class m180211_112439_create_status_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('status_history', [
            'id' => $this->primaryKey(),
            'time_change' => $this->dateTime(),
            'name_model' => $this->string(),
            'history_fields' => $this->text(),
            'parent_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('status_history');
    }
}
