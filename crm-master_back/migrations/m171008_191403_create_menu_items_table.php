<?php

use yii\db\Migration;

class m171008_191403_create_menu_items_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%menu_items}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->unique(),
            'uri' => $this->string(),
            'status' => $this->integer(2),
            'class' => $this->string(255),
            'icon' => $this->string(255),
            'sort_order' => $this->integer(11),
            'parent_id' => $this->integer(11),
        ]);

        $this->insert('menu_items', ['title' => 'Leads', 'uri' => '/leads/index', 'status' => 1, 'icon' => 'table']);
        $this->insert('menu_items', ['title' => 'Contacts', 'uri' => '/contacts/index', 'status' => 1, 'icon' => 'table']);
        $this->insert('menu_items', ['title' => 'Sales', 'uri' => '/sale/index', 'status' => 1, 'icon' => 'table']);
        $this->insert('menu_items', ['title' => 'Rentals', 'uri' => '/rentals/index', 'status' => 1, 'icon' => 'table']);
        $this->insert('menu_items', ['title' => 'Calendar', 'uri' => '/calendar/main/index', 'status' => 1, 'icon' => 'calendar']);
        // $this->insert('menu_items', ['title' => 'Accounts', 'uri' => '/accounts/index', 'status' => 1, 'icon' => 'table']);
        $this->insert('menu_items', ['title' => 'Commercial Sales', 'uri' => '/commercial-sales/index', 'status' => 1, 'icon' => 'table']);
        $this->insert('menu_items', ['title' => 'Commercial Rentals', 'uri' => '/commercial-rentals/index', 'status' => 1, 'icon' => 'table']);
        $this->insert('menu_items', ['title' => 'Import', 'uri' => '/import_export/import/index', 'status' => 1, 'icon' => 'cloud-upload']);
        $this->insert('menu_items', ['title' => 'Reports', 'uri' => '/reports/main/dashboard', 'status' => 1, 'icon' => 'area-chart',]);
        $this->insert('menu_items', ['title' => 'Task Manager', 'uri' => '/task-manager/index', 'status' => 1, 'icon' => 'list',]);
        $this->insert('menu_items', ['title' => 'Emails ', 'uri' => '/emails/index', 'status' => 1, 'icon' => 'send',]);
        $this->insert('menu_items', ['title' => 'My Reminders ', 'uri' => '/reminder/index', 'status' => 1, 'icon' => 'bell',]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%menu_items}}');
    }
}
