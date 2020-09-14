<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sale_archive`.
 */
class m180319_162809_create_sale_archive_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        Yii::$app->db->createCommand("CREATE TABLE sale_archive LIKE sale;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('sale_archive');
    }
}
