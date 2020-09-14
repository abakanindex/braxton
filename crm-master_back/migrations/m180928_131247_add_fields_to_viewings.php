<?php

use yii\db\Migration;
use app\models\Viewings;

/**
 * Class m180928_131247_add_fields_to_viewings
 */
class m180928_131247_add_fields_to_viewings extends Migration
{
    public function up()
    {
        $this->addColumn(Viewings::tableName(), 'report_cancellations', $this->tinyInteger(1)->defaultValue(0));
        $this->addColumn(Viewings::tableName(), 'report_cancellation_date', $this->dateTime());
        $this->addColumn(Viewings::tableName(), 'report_title', $this->string(255));
        $this->addColumn(Viewings::tableName(), 'report_description', $this->text());
        $this->addColumn(Viewings::tableName(), 'is_report_complete', $this->tinyInteger(1)->defaultValue(0));
        $this->addColumn(Viewings::tableName(), 'is_sent_to_creator', $this->tinyInteger(1)->defaultValue(0));

        $this->createIndex(
            'idx-viewings-created_by',
            Viewings::tableName(),
            'created_by'
        );

        $this->addForeignKey(
            'fk-viewings-created_by',
            Viewings::tableName(),
            'created_by',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropColumn(Viewings::tableName(), 'report_cancellations');
        $this->dropColumn(Viewings::tableName(), 'report_cancellation_date');
        $this->dropColumn(Viewings::tableName(), 'report_title');
        $this->dropColumn(Viewings::tableName(), 'report_description');
        $this->dropColumn(Viewings::tableName(), 'is_report_complete');
        $this->dropColumn(Viewings::tableName(), 'is_sent_to_creator');
    }
}
