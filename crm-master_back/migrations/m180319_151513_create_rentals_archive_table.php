<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rentals_archive`.
 */
class m180319_151513_create_rentals_archive_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        Yii::$app->db->createCommand("CREATE TABLE rentals_archive LIKE rentals;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('rentals_archive');
    }
}
