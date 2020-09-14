<?php

use yii\db\Migration;

/**
 * Class m180219_070155_create_lead_additional_email
 */
class m180219_070155_create_lead_additional_email extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('lead_additional_email', [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-lead_additional_email-lead_id',
            'lead_additional_email',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-lead_additional_email-lead_id',
            'lead_additional_email',
            'lead_id',
            'leads',
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
            'fk-lead_additional_email-lead_id',
            'lead_additional_email'
        );

        $this->dropIndex(
            'idx-lead_additional_email-lead_id',
            'lead_additional_email'
        );

        $this->dropTable('lead_additional_email');
    }
}
