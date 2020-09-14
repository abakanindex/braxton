<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_viewing`.
 */
class m180119_081532_create_lead_viewing_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lead_viewing', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'lead_id' => $this->integer()->notNull(),
            'time' => $this->integer()->notNull(),
            'report' => $this->text(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-lead_viewing-user_id',
            'lead_viewing',
            'user_id'
        );

        $this->addForeignKey(
            'fk-lead_viewing-user_id',
            'lead_viewing',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-lead_viewing-lead_id',
            'lead_viewing',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-lead_viewing-lead_id',
            'lead_viewing',
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
            'fk-lead_viewing-user_id',
            'lead_viewing'
        );

        $this->dropIndex(
            'idx-lead_viewing-user_id',
            'lead_viewing'
        );

        $this->dropForeignKey(
            'fk-lead_viewing-lead_id',
            'lead_viewing'
        );

        $this->dropIndex(
            'idx-lead_viewing-lead_id',
            'lead_viewing'
        );

        $this->dropTable('lead_viewing');
    }
}
