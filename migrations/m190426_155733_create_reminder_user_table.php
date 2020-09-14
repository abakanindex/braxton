<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reminder_user`.
 */
class m190426_155733_create_reminder_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('reminder_user', [
            'id' => $this->primaryKey(),
            'reminder_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-reminders-user_id',
            'reminder_user',
            'user_id'
        );

        $this->addForeignKey(
            'fk-reminders-user_id',
            'reminder_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-reminders-reminder_id',
            'reminder_user',
            'reminder_id'
        );

        $this->addForeignKey(
            'fk-reminders-reminder_id',
            'reminder_user',
            'reminder_id',
            'reminder',
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
            'fk-reminders-user_id',
            'reminder_user'
        );

        $this->dropIndex(
            'idx-reminders-user_id',
            'reminder_user'
        );

        $this->dropForeignKey(
            'fk-reminders-reminder_id',
            'reminder_user'
        );

        $this->dropIndex(
            'idx-reminders-reminder_id',
            'reminder_user'
        );
        $this->dropTable('reminder_user');
    }
}
