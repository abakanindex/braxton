<?php

use yii\db\Migration;

/**
 * Class m190218_095712_update_of_report
 */
class m190218_095712_update_of_report extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->update('report',
            ['description' => 'Sales Active By Agent', 'name' => 'Sales Active By Agent'],
            ['type' => 16]
        );

        $this->update('report',
            ['description' => 'Rentals Active By Agent', 'name' => 'Rentals Active By Agent'],
            ['type' => 17]
        );

        $this->execute("INSERT INTO `report` (`type`, `menu_item`, `user_id`, `created_at`, `description`, `name`, `date_type`, `date_from`, `date_to`, `url_id`) VALUES
            (33, 1, 1, 1513082853, 'Sales Inactive By Agent', 'Sales Inactive By Agent', 1, NULL, NULL, 'F8HjygDShm'),
            (34, 1, 1, 1513082853, 'Rentals Inactive By Agent', 'Rentals Inactive By Agent', 1, NULL, NULL, 'K9dgyHGdrk');");
    }

    public function down()
    {
        $this->update('report',
            ['description' => 'Sales By Agent', 'name' => 'Sales By Agent'],
            ['type' => 16]
        );

        $this->update('report',
            ['description' => 'Rentals By Agent', 'name' => 'Rentals By Agent'],
            ['type' => 17]
        );

        $this->execute("DELETE FROM `reports_menu_item` WHERE `type` IN (33,34);");
    }
}
