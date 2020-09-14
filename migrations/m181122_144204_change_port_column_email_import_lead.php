<?php

use yii\db\Migration;

/**
 * Class m181122_144204_change_port_column_email_import_lead
 */
class m181122_144204_change_port_column_email_import_lead extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn(\app\models\EmailImportLead::tableName(), 'port', $this->integer()->null());
    }

    public function down()
    {
        $this->alterColumn(\app\models\EmailImportLead::tableName(), 'port', $this->integer()->notNull());
    }
}
