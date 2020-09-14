<?php

use yii\db\Migration;

/**
 * Handles the creation of table `upload_log`.
 */
class m170925_112928_create_upload_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('upload_log', [
            'id' => $this->primaryKey(),
            'timestamp' => $this->timestamp(),
            'user_id' => $this->integer(11),
            'file_name' => $this->string(90),
            'random_int' => $this->integer(5)->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('upload_log');
    }


}
