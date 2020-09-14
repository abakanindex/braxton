<?php

use yii\db\Migration;
use app\modules\admin\models\AuthItem;

/**
 * Class m191001_085452_update_auth_item_table
 */
class m191001_085452_update_auth_item_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->insert(AuthItem::tableName(), ['name' =>'smsAllowed', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'excelExport', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'canAssignLead', 'type' => '2', 'company_id' => '0']);

        $this->insert(AuthItem::tableName(), ['name' =>'contractsCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'contractsDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'contractsUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'contractsView', 'type' => '2', 'company_id' => '0']);

        $this->insert(AuthItem::tableName(), ['name' =>'viewingCreate', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'viewingDelete', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'viewingUpdate', 'type' => '2', 'company_id' => '0']);
        $this->insert(AuthItem::tableName(), ['name' =>'viewingView', 'type' => '2', 'company_id' => '0']);
    }

    public function down()
    {

    }
}
