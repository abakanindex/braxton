<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_contact_note`.
 */
class m180320_111503_create_lead_contact_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('lead_contact_note', [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer(),
            'user_id' => $this->integer(),
            'note' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-lead_contact_note-user_id',
            'lead_contact_note',
            'user_id'
        );

        $this->addForeignKey(
            'fk-lead_contact_note-user_id',
            'lead_contact_note',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-lead_contact_note-lead_id',
            'lead_contact_note',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-lead_contact_note-lead_id',
            'lead_contact_note',
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
            'fk-lead_contact_note-user_id',
            'lead_contact_note'
        );

        $this->dropIndex(
            'idx-lead_contact_note-user_id',
            'lead_contact_note'
        );

        $this->dropForeignKey(
            'fk-lead_contact_note-lead_id',
            'lead_contact_note'
        );

        $this->dropIndex(
            'idx-lead_contact_note-lead_id',
            'lead_contact_note'
        );

        $this->dropTable('lead_contact_note');
    }
}
