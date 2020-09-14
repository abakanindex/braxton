<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feature_listing`.
 */
class m180905_075945_create_feature_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('feature_listing', [
            'id' => $this->primaryKey(),
            'ref' => $this->string(),
            'feature_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-feature_listing-feature_id',
            'feature_listing',
            'feature_id'
        );

        $this->addForeignKey(
            'fk-feature_listing-feature_id',
            'feature_listing',
            'feature_id',
            \app\models\reference_books\Features::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('feature_listing');
    }
}
