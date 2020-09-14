<?php

use yii\db\Migration;

/**
 * Handles adding type to table `feature_listing`.
 */
class m180910_121359_add_type_column_to_feature_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('feature_listing', 'type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('feature_listing', 'type');
    }
}
