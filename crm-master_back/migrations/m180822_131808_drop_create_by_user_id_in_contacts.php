<?php

use yii\db\Migration;
use app\models\Contacts;
use app\models\ContactsArchive;

/**
 * Class m180822_131808_drop_create_by_user_id_in_contacts
 */
class m180822_131808_drop_create_by_user_id_in_contacts extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->dropColumn(Contacts::tableName(), 'created_by_user_id');
        $this->dropColumn(ContactsArchive::tableName(), 'created_by_user_id');
    }

    public function down()
    {
        $this->addColumn(Contacts::tableName(), 'created_by_user_id', $this->integer());
        $this->addColumn(ContactsArchive::tableName(), 'created_by_user_id', $this->integer());
    }
}
