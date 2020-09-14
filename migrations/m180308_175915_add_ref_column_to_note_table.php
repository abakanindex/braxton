<?php

use yii\db\Migration;

/**
 * Handles adding ref to table `note`.
 */
class m180308_175915_add_ref_column_to_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('note', 'ref', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('note', 'ref');
    }
}
