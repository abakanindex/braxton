<?php

use yii\db\Migration;

/**
 * Class m180903_124119_new_order_of_reports_menu_item
 */
class m180903_124119_new_order_of_reports_menu_item extends Migration
{
    public function up()
    {
        $this->execute("TRUNCATE TABLE `reports_menu_item`");
        $this->execute("INSERT INTO `reports_menu_item` (`id`, `title`, `uri`, `status`, `class`, `icon`, `sort_order`, `parent_id`) VALUES
            (1, 'Dashboard', 'dashboard', 1, '', NULL, NULL, NULL),
            (2, 'Listings Reports', '', 1, '', NULL, NULL, NULL),
            (3, 'Leads Reports', '', 1, '', NULL, NULL, NULL),
            (4, 'Sales Reports', '', 1, '', NULL, NULL, NULL),
            (5, 'To-Do tasks reports', '', 1, '', NULL, NULL, NULL),
            (6, 'Agent Leaderboard', '', 1, '', NULL, NULL, NULL),
            
            (7, 'Sales By Category', 'report?id=A4xSgqsdfds', 1, '', NULL, NULL, 2),
            (8, 'Rentals By Category', 'report?id=A4ertSgqs', 1, '', NULL, NULL, 2),
            (9, 'Sales By Location', 'report?id=A4ertSTYpo', 1, '', NULL, NULL, 2),
            (10, 'Rentals By Location', 'report?id=A478uSTYpo', 1, '', NULL, NULL, 2),
            (11, 'Sales By Status', 'report?id=BvcduSTYpo', 1, '', NULL, NULL, 2),
            (12, 'Rentals By Status', 'report?id=Bvc67STYpo', 1, '', NULL, NULL, 2),
            (13, 'Sales By Agent', 'report?id=A4x5gKsdal', 1, '', NULL, NULL, 2),
            (14, 'Rentals By Agent', 'report?id=B5x9gNsdal', 1, '', NULL, NULL, 2),
            (15, 'Sales By Viewings', 'report?id=Zdfg67STYpo', 1, '', NULL, NULL, 2),
            (16, 'Rentals By Viewins', 'report?id=ZdfgwererYpo', 1, '', NULL, NULL, 2),
            (17, 'My saved reports', 'saved-reports?report_type=1', 1, '', NULL, NULL, 2),
            
            (18, 'Leads By Agent', 'report?id=D4xjgNs3al', 1, '', NULL, NULL, 3),
            (19, 'Leads Contact Time By Agents', 'report?id=jgRfvkj7k6', 1, '', NULL, NULL, 3),
            (20, 'Leads Contact Number By Agents', 'report?id=YTsdB765KJ', 1, '', NULL, NULL, 3),
            (21, 'Leads By Type', 'report?id=K7wolLiO9bf', 1, '', NULL, NULL, 3),
            (22, 'Leads By Status', 'report?id=A4xSgqmZ1Vi', 1, '', NULL, NULL, 3),
            (23, 'Leads By Source', 'report?id=KboyvC4ojd', 1, '', NULL, NULL, 3),
            (24, 'Leads By Location', 'report?id=G6Yyjn596j', 1, '', NULL, NULL, 3),
            (25, 'Leads By Property Type', 'report?id=dMNF4eVbK4', 1, '', NULL, NULL, 3),
            (26, 'Open Leads', 'report?id=gb4kvCe9jd', 1, '', NULL, NULL, 3),
            (27, 'Leads By Viewings', 'report?id=K734534fgh', 1, '', NULL, NULL, 3),
            (28, 'My saved reports', 'saved-reports?report_type=2', 1, '', NULL, NULL, 3),
            
            (29, 'Sales By Agents In Numbers Of Properties', 'report?id=6gdd86Kg85', 1, '', NULL, NULL, 4),
            (30, 'Sales By Agents In AED', 'report?id=j873574hkj', 1, '', NULL, NULL, 4),
            (31, 'Sales By Location', 'report?id=fhD43kfjh8', 1, '', NULL, NULL, 4),
            (32, 'Rentals By Agents In Numbers Of Properties', 'report?id=y434kyhjd5', 1, '', NULL, NULL, 4),
            (33, 'Rentals By Agents In AED', 'report?id=plkghdfad1', 1, '', NULL, NULL, 4),
            (34, 'Rentals By Location', 'report?id=GHHFGFGDDA', 1, '', NULL, NULL, 4),
            (35, 'My saved reports', 'saved-reports?report_type=3', 1, '', NULL, NULL, 4),
            
            (36, 'To-Do Tasks by Priority', 'report?id=dffgwererYpo', 1, '', NULL, NULL, 5),
            (37, 'My saved reports', 'saved-reports?report_type=4', 1, '', NULL, NULL, 5),
            
            (38, 'By Sales', 'report?id=jghWgqmZ1Vi', 1, '', NULL, NULL, 6),
            (39, 'By Rentals', 'report?id=jghWgqmA1Vc', 1, '', NULL, NULL, 6);");

    }

    public function down()
    {
        $this->execute("TRUNCATE TABLE `reports_menu_item`");
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
            (30, 'My saved reports', 'saved-reports?report_type=1', 1, '', NULL, NULL, 2),
            (31, 'Sales By Agents', 'report?id=A4x5gKsdal', 1, '', NULL, NULL, 2),
            (32, 'Rentals By Agents', 'report?id=B5x9gNsdal', 1, '', NULL, NULL, 2),
            (33, 'By Agents', 'report?id=D4xjgNs3al', 1, '', NULL, NULL, 8),
            (41, 'By Property', 'report?id=dMNF4eVbK4', 1, '', NULL, NULL, 8),
            (42, 'By Source', 'report?id=KboyvC4ojd', 1, '', NULL, NULL, 8),
            (43, 'Open Leads', 'report?id=gb4kvCe9jd', 1, '', NULL, NULL, 8),
            (44, 'Agent Contact interval', 'report?id=jgRfvkj7k6', 1, '', NULL, NULL, 8);");
    }
}
