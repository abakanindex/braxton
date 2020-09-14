<?php

use yii\db\Migration;

/**
 * Handles adding status to table `contacts`.
 */
class m180824_074256_add_status_column_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('contacts', 'status', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('contacts', 'status');
    }
}
