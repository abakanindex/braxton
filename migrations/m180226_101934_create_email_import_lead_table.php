<?php

use yii\db\Migration;

/**
 * Handles the creation of table `email_import_lead`.
 */
class m180226_101934_create_email_import_lead_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('email_import_lead', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'email' => $this->string(100)->notNull(),
            'imap' => $this->string(100)->notNull(),
            'port' => $this->integer(5)->notNull(),
            'status' => $this->integer(1)->notNull(),
            'last_updated' => $this->integer(),
            'password' => $this->string()->notNull(),
            'last_checked_uid' => $this->string(),
        ]);

        $this->createIndex(
            'idx-email_import_lead-user_id',
            'email_import_lead',
            'user_id'
        );

        $this->addForeignKey(
            'fk-email_import_lead-user_id',
            'email_import_lead',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-email_import_lead-user_id',
            'email_import_lead'
        );

        $this->dropIndex(
            'idx-email_import_lead-user_id',
            'email_import_lead'
        );

        $this->dropTable('email_import_lead');
    }
}
