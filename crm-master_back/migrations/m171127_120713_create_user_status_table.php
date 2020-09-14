<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_status`.
 */
class m171127_120713_create_user_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_status', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
        ]);

        $this->insert('user_status', ['title' => 'active']);
        $this->insert('user_status', ['title' => 'disabled']);
        $this->insert('user_status', ['title' => 'banned']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_status');
    }
}
