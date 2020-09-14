<?php

use yii\db\Migration;

/**
 * Handles the creation of table `import_temp`.
 */
class m180115_142335_create_import_temp_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('import_temp', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'username' => $this->string(255),
            'password' => $this->string('255'),
            'xml_link' => $this->string()->unique(),
            'data' => $this->text(),
            'datetime' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('import_temp');
    }
}
