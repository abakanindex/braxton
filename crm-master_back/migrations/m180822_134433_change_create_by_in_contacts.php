<?php

use yii\db\Migration;
use app\models\Contacts;
use app\models\ContactsArchive;

/**
 * Class m180822_134433_change_create_by_in_contacts
 */
class m180822_134433_change_create_by_in_contacts extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn(Contacts::tableName(), 'created_by', $this->integer());
        $this->alterColumn(ContactsArchive::tableName(), 'created_by', $this->integer());
    }

    public function down()
    {
        $this->alterColumn(Contacts::tableName(), 'created_by', $this->string());
        $this->alterColumn(ContactsArchive::tableName(), 'created_by', $this->string());
    }
}
