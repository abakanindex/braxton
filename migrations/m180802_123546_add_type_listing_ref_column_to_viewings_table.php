<?php

use yii\db\Migration;

/**
 * Handles adding type_listing_ref to table `viewings`.
 */
class m180802_123546_add_type_listing_ref_column_to_viewings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('viewings', 'type_listing_ref', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('viewings', 'type_listing_ref');
    }
}
