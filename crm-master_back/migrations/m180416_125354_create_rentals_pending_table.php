<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rentals_pending`.
 */
class m180416_125354_create_rentals_pending_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        Yii::$app->db->createCommand("CREATE TABLE rentals_pending LIKE rentals;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('rentals_pending');
    }
}
