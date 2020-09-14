<?php

use yii\db\Migration;

/**
 * Handles the creation of table `email_lead_source`.
 */
class m180308_064711_create_email_lead_source_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('email_lead_source', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->unique()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('email_lead_source');
    }
}
