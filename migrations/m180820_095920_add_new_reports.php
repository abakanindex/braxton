<?php

use yii\db\Migration;

/**
 * Class m180820_095920_add_new_reports
 */
class m180820_095920_add_new_reports extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->execute("INSERT INTO `report` (`type`, `menu_item`, `user_id`, `created_at`, `description`, `name`, `date_type`, `date_from`, `date_to`, `url_id`) VALUES
            (19, 1, 1, 1513082853, 'Leads By Property', 'Leads By Property', 1, NULL, NULL, 'dMNF4eVbK4'),
            (20, 1, 1, 1513082853, 'Leads By Source', 'Leads By Source', 1, NULL, NULL, 'KboyvC4ojd'),
            (21, 1, 1, 1513082853, 'Open Leads', 'Open Leads', 1, NULL, NULL, 'gb4kvCe9jd'),
            (22, 1, 1, 1513082853, 'Agent Contact Interval', 'Agent Contact Interval', 1, NULL, NULL, 'jgRfvkj7k6');");

        $this->execute("INSERT INTO `reports_menu_item` (`title`, `uri`, `status`, `class`, `icon`, `sort_order`, `parent_id`) VALUES
            ('By Property', 'report?id=dMNF4eVbK4', 1, '', NULL, NULL, 8),
            ('By Source', 'report?id=KboyvC4ojd', 1, '', NULL, NULL, 8),
            ('Open Leads', 'report?id=gb4kvCe9jd', 1, '', NULL, NULL, 8),
            ('Agent Contact Interval', 'report?id=jgRfvkj7k6', 1, '', NULL, NULL, 8)");
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180820_095920_add_new_reports cannot be reverted.\n";
        return false;
    }
}
