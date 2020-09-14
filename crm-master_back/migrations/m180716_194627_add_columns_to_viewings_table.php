<?php

use yii\db\Migration;

/**
 * Handles adding created_by to table `viewings`.
 */
class m180716_194627_add_columns_to_viewings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('viewings', 'created_by', $this->integer()->notNull());
        $this->addColumn('viewings', 'type', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('viewings', 'created_by');
        $this->addColumn('viewings', 'type', $this->integer()->notNull());
    }
}
