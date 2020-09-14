<?php

use yii\db\Migration;
use app\modules\lead\models\LeadAgent;

/**
 * Class m180824_075116_add_created_at_to_lead_agent_table
 */
class m180824_075116_add_created_at_to_lead_agent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn(LeadAgent::tableName(), 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn(LeadAgent::tableName(), 'created_at');
    }
}
