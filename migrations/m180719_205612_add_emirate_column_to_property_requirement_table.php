<?php

use yii\db\Migration;

/**
 * Handles adding emirate to table `property_requirement`.
 */
class m180719_205612_add_emirate_column_to_property_requirement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('property_requirement', 'emirate', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('property_requirement', 'emirate');
    }
}
