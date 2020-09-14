<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_viewing`.
 */
class m171218_124146_create_user_viewing_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_viewing', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-user_viewing_id',
            'user_viewing',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_viewing_id',
            'user_viewing',
            'user_id',
            'user',
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
            'fk-user_viewing_id',
            'user_viewing'
        );

        $this->dropIndex(
            'idx-user_viewing_id',
            'user_viewing'
        );

        $this->dropTable('user_viewing');
    }
}
