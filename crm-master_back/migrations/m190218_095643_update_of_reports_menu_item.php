<?php

use yii\db\Migration;

/**
 * Class m190218_095643_update_of_reports_menu_item
 */
class m190218_095643_update_of_reports_menu_item extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->update('reports_menu_item',
            ['title' => 'Sales Active By Agent'],
            ['title' => 'Sales By Agent']
        );

        $this->update('reports_menu_item',
            ['title' => 'Rentals Active By Agent'],
            ['title' => 'Rentals By Agent']
        );

        $this->execute("INSERT INTO `reports_menu_item` (`id`, `title`, `uri`, `status`, `class`, `icon`, `sort_order`, `parent_id`) VALUES
            (40, 'Sales Inactive By Agent', 'report?id=F8HjygDShm', 1, '', NULL, NULL, 2),
            (41, 'Rentals Inactive By Agent', 'report?id=K9dgyHGdrk', 1, '', NULL, NULL, 2);");
    }

    public function down()
    {
        $this->update('reports_menu_item',
            ['title' => 'Sales By Agent'],
            ['title' => 'Sales Active By Agent']
        );

        $this->update('reports_menu_item',
            ['title' => 'Rentals By Agent'],
            ['title' => 'Rentals Active By Agent']
        );

        $this->execute("DELETE FROM `reports_menu_item` WHERE `id` IN (40,41);");
    }
}
