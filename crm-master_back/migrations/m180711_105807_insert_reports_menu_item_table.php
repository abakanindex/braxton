<?php

use yii\db\Migration;

/**
 * Class m180711_105807_insert_reports_menu_item_table
 */
class m180711_105807_insert_reports_menu_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("INSERT INTO `reports_menu_item` (`title`, `uri`, `status`, `class`, `icon`, `sort_order`, `parent_id`) VALUES
            ('Sales By Agents', 'report?id=A4x5gKsdal', 1, '', NULL, NULL, 2),
            ('Rentals By Agents', 'report?id=B5x9gNsdal', 1, '', NULL, NULL, 2),
            ('By Agents', 'report?id=D4xjgNs3al', 1, '', NULL, NULL, 8)");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180711_105807_insert_reports_menu_item_table cannot be reverted.\n";
        return false;
    }
}
