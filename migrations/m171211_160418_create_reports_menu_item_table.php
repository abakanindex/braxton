<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reports_menu_item`.
 */
class m171211_160418_create_reports_menu_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('reports_menu_item', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'uri' => $this->string(),
            'status' => $this->integer(2),
            'class' => $this->string(255),
            'icon' => $this->string(255),
            'sort_order' => $this->integer(11),
            'parent_id' => $this->integer(11),
        ]);

        $this->execute("INSERT INTO `reports_menu_item` (`id`, `title`, `uri`, `status`, `class`, `icon`, `sort_order`, `parent_id`) VALUES
            (1, 'Dashboard', 'dashboard', 1, '', NULL, NULL, NULL),
            (2, 'Listings Reports', '', 1, '', NULL, NULL, NULL),
            (3, 'Sales By Category', 'report?id=A4xSgqsdfds', 1, '', NULL, NULL, 2),
            (4, 'Rentals By Category', 'report?id=A4ertSgqs', 1, '', NULL, NULL, 2),
            (5, 'Sales By Location', 'report?id=A4ertSTYpo', 1, '', NULL, NULL, 2),
            (6, 'Rentals By Location', 'report?id=A478uSTYpo', 1, '', NULL, NULL, 2),
            (7, 'Sales By Status', 'report?id=BvcduSTYpo', 1, '', NULL, NULL, 2),
            (8, 'Leads Reports', '', 1, '', NULL, NULL, NULL),
            (9, 'Lead Viewing Report', 'report?id=K734534fgh', 1, '', NULL, NULL, 8),
            (10, 'By Lead Type', 'report?id=K7wolLiO9bf', 1, '', NULL, NULL, 8),
            (12, 'By Status', 'report?id=A4xSgqmZ1Vi', 1, '', NULL, NULL, 8),
            (13, 'My Saved Reports', 'saved-reports?report_type=2', 1, '', NULL, NULL, 8),
            (17, 'Deals reports', '', 0, '', NULL, NULL, NULL),
            (18, 'By deal type and status', 'report?id=K7wolLiO9as', 1, '', NULL, NULL, 17),
            (19, 'Successful deals', 'report?id=K7wolLifdas', 1, '', NULL, NULL, 17),
            (20, 'My saved reports', 'saved-reports?report_type=3', 1, '', NULL, NULL, 17),
            (21, 'Contacts reports', '', 0, '', NULL, NULL, NULL),
            (22, 'My saved reports', 'saved-reports?report_type=4', 1, '', NULL, NULL, 21),
            (23, 'To-Do tasks reports', '', 1, '', NULL, NULL, NULL),
            (24, 'To-Do Tasks by Priority', 'report?id=dffgwererYpo', 1, '', NULL, NULL, 23),
            (25, 'My saved reports', 'saved-reports?report_type=5', 1, '', NULL, NULL, 23),
            (26, 'Agent leaderboard', 'report?id=jghWgqmZ1Vi', 1, '', NULL, NULL, NULL),
            (27, 'Rentals By Status', 'report?id=Bvc67STYpo', 1, '', NULL, NULL, 2),
            (28, 'Sales Viewing Reports', 'report?id=Zdfg67STYpo', 1, '', NULL, NULL, 2),
            (29, 'Rentals Viewing Reports', 'report?id=ZdfgwererYpo', 1, '', NULL, NULL, 2),
            (30, 'My saved reports', 'saved-reports?report_type=1', 1, '', NULL, NULL, 2);");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->truncateTable('reports_menu_item');
        $this->dropTable('reports_menu_item');
    }
}
