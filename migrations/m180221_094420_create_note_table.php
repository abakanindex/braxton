<?php

use yii\db\Migration;

/**
 * Handles the creation of table `note`.
 */
class m180221_094420_create_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('note', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-note-user_id',
            'note',
            'user_id'
        );

        $this->addForeignKey(
            'fk-note-user_id',
            'note',
            'user_id',
            'user',
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
            'fk-note-user_id',
            'note'
        );

        $this->dropIndex(
            'idx-note-user_id',
            'note'
        );

        $this->dropTable('note');
    }
}
