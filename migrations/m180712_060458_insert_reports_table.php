<?php

use yii\db\Migration;

/**
 * Class m180712_060458_insert_reports_table
 */
class m180712_060458_insert_reports_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("INSERT INTO `report` (`type`, `menu_item`, `user_id`, `created_at`, `description`, `name`, `date_type`, `date_from`, `date_to`, `url_id`) VALUES
            (16, 1, 1, 1513082853, 'Sales By Agents', 'Sales By Agents', 1, NULL, NULL, 'A4x5gKsdal'),
            (17, 1, 1, 1513082853, 'Rentals By Agents', 'Rentals By Agents', 1, NULL, NULL, 'B5x9gNsdal'),
            (18, 1, 1, 1513082853, 'Leads By Agents', 'Leads By Agents', 1, NULL, NULL, 'D4xjgNs3al');");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180712_060458_insert_reports_table cannot be reverted.\n";
        return false;
    }
}
