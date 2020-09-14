<?php

use yii\db\Migration;

/**
 * Class m180903_125202_new_of_reports
 */
class m180903_125202_new_of_reports extends Migration
{
    public function up()
    {
        $this->execute("INSERT INTO `report` (`type`, `menu_item`, `user_id`, `created_at`, `description`, `name`, `date_type`, `date_from`, `date_to`, `url_id`) VALUES
            (23, 1, 1, 1513082853, 'Leads Contact Number By Agents', 'Leads Contact Number By Agents', 1, NULL, NULL, 'YTsdB765KJ'),
            (24, 1, 1, 1513082853, 'Leads By Location', 'Leads By Location', 1, NULL, NULL, 'G6Yyjn596j'),
            (25, 1, 1, 1513082853, 'Sales By Agents In Numbers Of Properties', 'Sales By Agents In Numbers Of Properties', 1, NULL, NULL, '6gdd86Kg85'),
            (26, 1, 1, 1513082853, 'Sales By Agents In AED', 'Sales By Agents In AED', 1, NULL, NULL, 'j873574hkj'),
            (27, 1, 1, 1513082853, 'Sales By Location', 'Sales By Location', 1, NULL, NULL, 'fhD43kfjh8'),
            (28, 1, 1, 1513082853, 'Rentals By Agents In Numbers Of Properties', 'Rentals By Agents In Numbers Of Properties', 1, NULL, NULL, 'y434kyhjd5'),
            (29, 1, 1, 1513082853, 'Rentals By Agents In AED', 'Rentals By Agents In AED', 1, NULL, NULL, 'plkghdfad1'),
            (30, 1, 1, 1513082853, 'Rentals By Location', 'Rentals By Location', 1, NULL, NULL, 'GHHFGFGDDA'),
            (31, 1, 1, 1513082853, 'Agent Leaderboard By Sales', 'Agent Leaderboard By Sales', 1, NULL, NULL, 'jghWgqmZ1Vi'),
            (32, 1, 1, 1513082853, 'Agent Leaderboard By Rentals', 'Agent Leaderboard By Rentals', 1, NULL, NULL, 'jghWgqmA1Vc');");
    }

    public function down()
    {
        echo "m180903_125202_new_of_reports cannot be reverted.\n";
        return false;
    }
}
