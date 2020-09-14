<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contacts_archive`.
 */
class m180319_102758_create_contacts_archive_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        Yii::$app->db->createCommand("CREATE TABLE contacts_archive LIKE contacts;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('contacts_archive');
    }
}
