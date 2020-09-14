<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contact_Source`.
 */
class m171008_002416_create_contact_source_table extends Migration
{
    public $path;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('contact_source', [
            'id' => $this->primaryKey(),
            'source' => $this->text(),
        ]);

        $this->path = 'migrations/_contact_source.sql';
        $this->execute(file_get_contents($this->path));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('contact_source');
    }
}
