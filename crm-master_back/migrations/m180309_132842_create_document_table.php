<?php

use yii\db\Migration;

/**
 * Handles the creation of table `document`.
 */
class m180309_132842_create_document_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('document', [
            'id' => $this->primaryKey(),
            'ref' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'path' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->datetime()
        ]);

        $this->createIndex(
            'idx-document-user_id',
            'document',
            'user_id'
        );

        $this->addForeignKey(
            'fk-document-user_id',
            'document',
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
        $this->dropTable('document');
    }
}
