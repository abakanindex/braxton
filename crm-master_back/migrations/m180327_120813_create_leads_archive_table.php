<?php

use yii\db\Migration;

/**
 * Handles the creation of table `leads_archive`.
 */
class m180327_120813_create_leads_archive_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        Yii::$app->db->createCommand("CREATE TABLE leads_archive LIKE leads;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('leads_archive');
    }
}
