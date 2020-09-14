<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dashboard_report_order`.
 */
class m171219_105502_create_dashboard_report_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('dashboard_report_order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->integer(1)->notNull(),
            'report_id' => $this->integer(),
            'order' => $this->integer(4)->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'mode' => $this->integer(1)->notNull(),
        ]);

        $this->createIndex(
            'idx-dashboard_report_order_user_id',
            'dashboard_report_order',
            'user_id'
        );

        $this->addForeignKey(
            'fk-dashboard_report_order_user_id',
            'dashboard_report_order',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->execute("INSERT INTO `dashboard_report_order` (`id`, `user_id`, `type`, `report_id`, `order`, `updated_at`, `mode`) VALUES
            (1, 3, 2, NULL, 1, 1515510485, 1),
            (2, 3, 1, 35, 2, 1515510509, 1),
            (3, 3, 1, 30, 3, 1515510567, 1),
            (4, 3, 1, 42, 4, 1515510587, 1),
            (5, 3, 1, 32, 5, 1515510608, 1),
            (6, 3, 1, 33, 6, 1515510611, 1),
            (7, 3, 1, 34, 7, 1515510613, 1),
            (8, 3, 1, 17, 8, 1515510619, 1),
            (9, 3, 1, 2, 9, 1515510623, 1);");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-dashboard_report_order_user_id',
            'dashboard_report_order'
        );

        $this->dropIndex(
            'idx-dashboard_report_order_user_id',
            'dashboard_report_order'
        );

        $this->dropTable('dashboard_report_order');
    }
}
