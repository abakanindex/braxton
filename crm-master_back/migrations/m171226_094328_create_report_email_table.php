<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report_email`.
 */
class m171226_094328_create_report_email_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('report_email', [
            'id' => $this->primaryKey(),
            'to' => $this->string(),
            'subject' => $this->string(),
            'message' => $this->text(),
            'attach' => $this->integer(1),
            'report_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-report_email_user_id',
            'report_email',
            'user_id'
        );

        $this->addForeignKey(
            'fk-report_email_user_id',
            'report_email',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-report_email_report_id',
            'report_email',
            'report_id'
        );

        $this->addForeignKey(
            'fk-report_email_report_id',
            'report_email',
            'report_id',
            'report',
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
            'fk-report_email_user_id',
            'report_email'
        );

        $this->dropIndex(
            'idx-report_email_user_id',
            'report_email'
        );

        $this->dropForeignKey(
            'fk-report_email_report_id',
            'report_email'
        );

        $this->dropIndex(
            'idx-report_email_report_id',
            'report_email'
        );

        $this->dropTable('report_email');
    }
}
