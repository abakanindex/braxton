<?php

use yii\db\Migration;
use app\models\Contacts;

/**
 * Class m190129_131419_update_contacts_table
 */
class m190129_131419_update_contacts_table extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn(Contacts::tableName(), 'postal_code', $this->string());
        $this->addColumn(Contacts::tableName(), 'po_box', $this->string());
    }

    public function down()
    {
        $this->dropColumn(Contacts::tableName(), 'postal_code');
        $this->dropColumn(Contacts::tableName(), 'po_box');
    }
}
