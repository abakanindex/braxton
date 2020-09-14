<?php

use yii\db\Migration;

/**
 * Class m180516_165914_creare_auth_item_table
 */
class m180516_165914_create_auth_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('auth_item', [
            'name'        => $this->string(),
            'type'        => $this->string(),
            'description' => $this->text(),
            'rule_name'   => $this->string(),
            'data'        => $this->binary(),
            'created_at'  => $this->string(),
            'updated_at'  => $this->integer(),
            'company_id'  => $this->integer(),
        ]);

        $this->addPrimaryKey('role_company', 'auth_item' , ['name', 'company_id']);
        $this->insert('auth_item' , ['name' => 'Admin', 'type' => '1', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' => 'Owner', 'type' => '1', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' => 'Agent', 'type' => '1', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' => 'Manager',   'type' => '1', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' => 'Department Leader', 'type' => '1', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' => 'Executive Agent', 'type' => '1', 'company_id' => '0']);

        $this->insert('auth_item' , ['name' =>'leadsСreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'leadsUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'leadsView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'leadsDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'contactsCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'contactsUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'contactsView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'contactsDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'saleCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'saleUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'saleView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'saleDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'rentalsCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'rentalsUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'rentalsView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'rentalsDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'calendarView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialsalesCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialsalesUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialsalesView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialsalesDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialrentalsCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialrentalsUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialrentalsView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'commercialrentalsDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'reportsCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'reportsUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'reportsView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'reportsDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'taskmanagerCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'taskmanagerUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'taskmanagerView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'taskmanagerDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'myremindersView', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'dealsCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'dealsDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'dealsUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert('auth_item' , ['name' =>'dealsView',   'type' => '2', 'company_id' => '0']);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('auth_item');
    }


}
