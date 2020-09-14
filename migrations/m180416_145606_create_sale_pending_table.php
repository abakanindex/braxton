<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sale_pending`.
 */
class m180416_145606_create_sale_pending_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        Yii::$app->db->createCommand("CREATE TABLE sale_pending LIKE sale;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('sale_pending');
    }
}
