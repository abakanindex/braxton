<?php

use yii\db\Migration;
use app\models\Leads;
use app\models\LeadsArchive;

/**
 * Class m180612_101956_add_created_at_to_lead
 */
class m180612_101956_add_created_at_to_lead extends Migration
{
    public function up()
    {
        $this->addColumn(Leads::tableName(), 'created_at', $this->integer());
        $this->addColumn(LeadsArchive::tableName(), 'created_at', $this->integer());
    }

    public function down()
    {
        $this->dropColumn(Leads::tableName(), 'created_at');
        $this->dropColumn(LeadsArchive::tableName(), 'created_at');
    }
}
