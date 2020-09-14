<?php

use yii\db\Migration;

/**
 * Handles the creation of table `language`.
 */
class m171008_002158_create_language_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('language', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('language');
    }
}
