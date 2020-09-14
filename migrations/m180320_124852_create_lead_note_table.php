<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_note`.
 */
class m180320_124852_create_lead_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('lead_note', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'lead_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-lead_note-lead_id',
            'lead_note',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-lead_note-lead_id',
            'lead_note',
            'lead_id',
            'leads',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-lead_note-lead_id',
            'lead_note'
        );

        $this->dropIndex(
            'idx-lead_note-lead_id',
            'lead_note'
        );

        $this->dropTable('lead_note');
    }
}
