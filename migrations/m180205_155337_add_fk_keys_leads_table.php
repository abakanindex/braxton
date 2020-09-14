<?php

use yii\db\Migration;

/**
 * Class m180205_155337_add_fk_keys_leads_table
 */
class m180205_155337_add_fk_keys_leads_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createIndex(
            'idx-leads-sub_status_id',
            'leads',
            'sub_status_id'
        );

        $this->addForeignKey(
            'fk-leads-sub_status_id',
            'leads',
            'sub_status_id',
            'lead_sub_status',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-leads-type',
            'leads',
            'type_id'
        );

        $this->addForeignKey(
            'fk-leads-type',
            'leads',
            'type_id',
            'lead_type',
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
            'fk-leads-type',
            'leads'
        );

        $this->dropIndex(
            'idx-leads-type',
            'leads'
        );

        $this->dropForeignKey(
            'fk-leads-sub_status_id',
            'leads'
        );

        $this->dropIndex(
            'idx-leads-sub_status_id',
            'leads'
        );

    }
}
