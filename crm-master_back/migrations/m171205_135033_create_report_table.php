<?php

use yii\db\Migration;

/**
 * Handles the creation of table `report`.
 */
class m171205_135033_create_report_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('report', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'menu_item' => $this->integer(1),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'description' => $this->text(),
            'name' => $this->string()->notNull(),
            'date_type' => $this->integer()->notNull(),
            'date_from' => $this->string(10),
            'date_to' => $this->string(10),
            'created_at' => $this->integer()->notNull(),
            'url_id' => $this->string()->notNull()
        ]);

        $this->createIndex(
            'idx-report-user_id',
            'report',
            'user_id'
        );

        $this->addForeignKey(
            'fk-report-user_id',
            'report',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->execute("INSERT INTO `report` (`id`, `type`, `menu_item`, `user_id`, `created_at`, `description`, `name`, `date_type`, `date_from`, `date_to`, `url_id`) VALUES
            (2, 2, 1, 1, 1513082853, 'some description', 'Reports by lead status', 1, NULL, NULL, 'A4xSgqmZ1Vi'),
            (8, 2, 0, 1, 1513348921, 'some description', '345', 1, NULL, NULL, 'KtlY2qshzXU'),
            (9, 2, 0, 1, 1513349736, 'some description', '1111', 2, '2017-11-15', '2017-12-15', 'd-M5tZSwL1K'),
            (10, 2, 0, 1, 1513349874, 'new report description', 'new report', 2, '2017-11-15', '2017-12-15', 'XBCM0pGER-B'),
            (11, 2, 0, 1, 1513350828, '', '88888888', 1, '', '', '2zZigFMbWo9'),
            (12, 2, 0, 1, 1513351004, '', '5675', 2, '2017-11-15', '2017-12-15', 'h3uAnKuIL-7'),
            (13, 2, 0, 1, 1513351012, '', '456', 2, '2017-11-15', '2017-12-15', 'xHl0CnDYg-Q'),
            (14, 2, 0, 1, 1513351190, '', '4564', 2, '2017-11-15', '2017-12-15', 'A8iGRUVwi8x'),
            (15, 2, 0, 1, 1513597799, '', '27-28', 2, '2017-12-27', '2017-12-28', '0GzZ-dIMVBT'),
            (16, 3, 1, 1, 2342344, 'viewings', 'Lead Viewing Report', 1, NULL, NULL, 'K734534fgh'),
            (17, 1, 1, 1, 1513082853, 'some description', 'Reports by lead type', 1, NULL, NULL, 'K7wolLiO9bf'),
            (18, 1, 0, 1, 1513613194, '', 'lead type last week', 2, '2017-12-12', '2017-12-18', 'BUjEnL2lPfD'),
            (19, 1, 0, 1, 1513613522, '', '777', 2, '2017-11-18', '2017-12-18', '15e1OBMOMI3'),
            (20, 1, 0, 1, 1513617195, '', 'qqqqqqqq', 2, '2017-11-18', '2017-12-18', 'F_17HKHVZCS'),
            (21, 2, 0, 1, 1513772153, '', 'November lead status', 2, '2017-11-20', '2017-12-20', 'p8fYj8wghXY'),
            (22, 2, 0, 1, 1513774199, '', 'today status lead', 2, '2017-12-20', '2017-12-20', 'NfFpzjyidHW'),
            (23, 2, 0, 1, 1513863505, '', '20-12-2017', 2, '2017-12-20', '2017-12-20', 'F0mlt5sQVGX'),
            (24, 1, 0, 1, 1513864616, '', 'real lead type', 2, '2017-11-21', '2017-12-21', 'qwpjsOWTMCQ'),
            (27, 3, 0, 1, 1513937975, '', 'total viewings', 2, '2017-11-22', '2017-12-22', 'dazntfa3IAW'),
            (28, 1, 0, 1, 1513945931, '', '8888888', 2, '2017-11-23', '2017-12-22', 'DJC2naDj9cs'),
            (29, 1, 0, 1, 1514293811, '', '12-20 - 12-26', 2, '2017-12-20', '2017-12-26', 'DdE6Vos1FaI'),
            (30, 6, 1, 1, 1513082853, 'Sales By Category', 'Sales By Category', 1, NULL, NULL, 'A4xSgqsdfds'),
            (31, 7, 1, 1, 1513082853, 'Rentals By Category', 'Rentals By Category', 1, NULL, NULL, 'A4ertSgqs'),
            (32, 8, 1, 1, 1513082853, 'Sales By Location', 'Sales By Location', 1, NULL, NULL, 'A4ertSTYpo'),
            (33, 9, 1, 1, 1513082853, 'Rentals By Location', 'Rentals By Location', 1, NULL, NULL, 'A478uSTYpo'),
            (34, 10, 1, 1, 1513082853, 'Sales By Status', 'Sales By Status', 1, NULL, NULL, 'BvcduSTYpo'),
            (35, 11, 1, 1, 1513082853, 'Rentals By Status', 'Rentals By Status', 1, NULL, NULL, 'Bvc67STYpo'),
            (36, 12, 1, 1, 1513082853, 'Sales Viewings Report', 'Sales Viewings Report', 1, NULL, NULL, 'Zdfg67STYpo'),
            (37, 13, 1, 1, 1513082853, 'Rentals Viewings Report', 'Rentals Viewings Report', 1, NULL, NULL, 'ZdfgwererYpo'),
            (38, 6, 0, 1, 1515072766, '', 'Last month Category Sales', 2, '2017-12-06', '2018-01-04', 'z8ONjdDrWpc'),
            (39, 7, 0, 1, 1515073783, '', 'Rentals last 30 days', 2, '2017-12-06', '2018-01-04', 'VS4bkTfl4MN'),
            (40, 14, 1, 1, 1513082853, 'To-Do Tasks Report', 'To-Do Tasks Report', 1, NULL, NULL, 'dffgwererYpo'),
            (41, 14, 0, 1, 1515146231, '', 'new saved reports', 2, '2017-12-05', '2018-01-05', 'pZuxE0bNW9q');");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-report-user_id',
            'report'
        );

        $this->dropIndex(
            'idx-report-user_id',
            'report'
        );

        $this->dropTable('report');
    }
}
