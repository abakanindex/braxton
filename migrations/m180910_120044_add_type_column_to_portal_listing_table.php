<?php

use yii\db\Migration;

/**
 * Handles adding type to table `portal_listing`.
 */
class m180910_120044_add_type_column_to_portal_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('portal_listing', 'type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('portal_listing', 'type');
    }
}
