<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_agent`.
 */
class m180206_062955_create_lead_agent_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lead_agent', [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-leads-user_id',
            'lead_agent',
            'user_id'
        );

        $this->addForeignKey(
            'fk-leads-user_id',
            'lead_agent',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-leads-lead_id',
            'lead_agent',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-leads-lead_id',
            'lead_agent',
            'lead_id',
            'leads',
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
            'fk-leads-user_id',
            'lead_agent'
        );

        $this->dropIndex(
            'idx-leads-user_id',
            'lead_agent'
        );

        $this->dropForeignKey(
            'fk-leads-lead_id',
            'lead_agent'
        );

        $this->dropIndex(
            'idx-leads-lead_id',
            'lead_agent'
        );
        $this->dropTable('lead_agent');
    }
}
