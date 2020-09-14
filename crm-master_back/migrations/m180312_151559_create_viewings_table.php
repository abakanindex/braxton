<?php

use yii\db\Migration;

/**
 * Handles the creation of table `viewings`.
 */
class m180312_151559_create_viewings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('viewings', [
            'id' => $this->primaryKey(),
            'date' => $this->datetime(),
            'agent_id' => $this->integer(),
            'request_viewing_pack_id' => $this->integer(),
            'listing_ref' => $this->string(),
            'status' => $this->integer(),
            'client_name' => $this->string(),
            'ref' => $this->string()->notNull(),
            'note' => $this->text(),
        ]);

        $this->createIndex(
            'idx-viewings-request_viewing_pack_id',
            'viewings',
            'request_viewing_pack_id'
        );

        $this->addForeignKey(
            'fk-viewings-request_viewing_pack_id',
            'viewings',
            'request_viewing_pack_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-viewings-agent_id',
            'viewings',
            'agent_id'
        );

        $this->addForeignKey(
            'fk-viewings-agent_id',
            'viewings',
            'agent_id',
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
        $this->dropTable('viewings');
    }
}
