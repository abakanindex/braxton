<?php

use yii\db\Migration;

/**
 * Class m180719_080152_add_columns_to_leads
 */
class m180719_080152_add_columns_to_leads extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('leads', 'origin', $this->integer());
        $this->addColumn('leads_archive', 'origin', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('leads', 'origin');
        $this->dropColumn('leads_archive', 'origin');
    }

}
