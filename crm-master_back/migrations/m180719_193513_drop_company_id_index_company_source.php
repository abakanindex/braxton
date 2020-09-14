<?php

use yii\db\Migration;

/**
 * Class m180719_193513_drop_company_id_index_company_source
 */
class m180719_193513_drop_company_id_index_company_source extends Migration
{


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->dropForeignKey(
            'fk-company_source-company_id',
            'company_source'
        );

        $this->dropIndex(
            'idx-company_source-company_id',
            'company_source'
        );
    }

    public function down()
    {
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
}
