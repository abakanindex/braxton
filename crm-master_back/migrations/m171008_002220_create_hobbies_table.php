<?php

use yii\db\Migration;

/**
 * Handles the creation of table `hobbies`.
 */
class m171008_002220_create_hobbies_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hobbies', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('hobbies');
    }
}
