<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reminder`.
 */
class m180111_081748_create_reminder_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('reminder', [
            'id' => $this->primaryKey(),
            'time' => $this->integer(),
            'key' => $this->string(20)->notNull(),
            'key_id' => $this->integer()->notNull(),
            'interval_type' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'send_type' => $this->integer(1)->defaultValue(1),
            'status' => $this->integer(1)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'notification_created_at' => $this->integer(),
            'seconds_interval' => $this->integer(),
            'notification_time_from' => $this->integer(),
            'remind_at_time' => $this->integer(),
            'remind_at_time_result' => $this->integer(1)->defaultValue(0)
        ]);

        $this->createIndex(
            'idx-reminder-user_id',
            'reminder',
            'user_id'
        );

        $this->addForeignKey(
            'fk-reminder-user_id',
            'reminder',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-reminder-user_id',
            'reminder'
        );

        $this->dropIndex(
            'idx-reminder-user_id',
            'reminder'
        );

        $this->dropTable('reminder');
    }
}
