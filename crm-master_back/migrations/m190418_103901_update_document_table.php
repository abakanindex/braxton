<?php

use yii\db\Migration;
use app\models\Document;

/**
 * Class m190418_103901_update_document_table
 */
class m190418_103901_update_document_table extends Migration
{
    public function up()
    {
        $this->addColumn(Document::tableName(), 'category', $this->integer());
    }

    public function down()
    {
        $this->dropColumn(Document::tableName(), 'category');
    }
}
