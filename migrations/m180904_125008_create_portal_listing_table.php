<?php

use yii\db\Migration;

/**
 * Handles the creation of table `portal_listing`.
 */
class m180904_125008_create_portal_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('portal_listing', [
            'id' => $this->primaryKey(),
            'ref' => $this->string(),
            'portal_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-portal_listing-portal_id',
            'portal_listing',
            'portal_id'
        );

        $this->addForeignKey(
            'fk-portal_listing-portal_id',
            'portal_listing',
            'portal_id',
            \app\models\reference_books\Portals::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('portal_listing');
    }
}
