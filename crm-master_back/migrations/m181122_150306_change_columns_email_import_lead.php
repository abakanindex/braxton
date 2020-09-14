<?php

use yii\db\Migration;

/**
 * Class m181122_150306_change_columns_email_import_lead
 */
class m181122_150306_change_columns_email_import_lead extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn(\app\models\EmailImportLead::tableName(), 'password', $this->string()->null());
        $this->alterColumn(\app\models\EmailImportLead::tableName(), 'status', $this->integer()->null());
    }

    public function down()
    {
        $this->alterColumn(\app\models\EmailImportLead::tableName(), 'password', $this->string()->notNull());
        $this->alterColumn(\app\models\EmailImportLead::tableName(), 'status', $this->integer()->notNull());
    }
}
