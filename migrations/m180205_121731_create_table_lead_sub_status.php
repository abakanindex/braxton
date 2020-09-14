<?php

use yii\db\Migration;

/**
 * Class m180205_121731_create_table_lead_sub_status
 */
class m180205_121731_create_table_lead_sub_status extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lead_sub_status', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'order' => $this->integer(2)->notNull()->unique()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lead_sub_status');
    }

}
