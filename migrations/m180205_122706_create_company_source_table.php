<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_source`.
 */
class m180205_122706_create_company_source_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company_source', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'company_id' => $this->integer()->notNull(),
            'order' => $this->integer(2)->notNull()->unique()
        ]);

        $this->createIndex(
            'idx-company_source-company_id',
            'company_source',
            'company_id'
        );

        $this->addForeignKey(
            'fk-company_source-company_id',
            'company_source',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-company_source-company_id',
            'company_source'
        );

        $this->dropIndex(
            'idx-company_source-company_id',
            'company_source'
        );
        $this->dropTable('company_source');
    }
}
