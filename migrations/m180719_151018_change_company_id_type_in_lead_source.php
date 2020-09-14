<?php

use yii\db\Migration;

/**
 * Class m180719_151018_change_comoany_id_type_in_lead_source
 */
class m180719_151018_change_company_id_type_in_lead_source extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('lead_source', 'company_id', 'string');
    }

    public function down()
    {
        $this->alterColumn('lead_source', 'company_id', 'integer');
    }
}
