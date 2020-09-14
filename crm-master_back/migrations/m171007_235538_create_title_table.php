<?php

use yii\db\Migration;

/**
 * Handles the creation of table `title`.
 */
class m171007_235538_create_title_table extends Migration
{
    public $path;
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('title', [
            'id' => $this->primaryKey(),
            'titles' => $this->text(),
        ]);

        $this->path = 'migrations/_title.sql';
        $this->execute(file_get_contents($this->path));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('title');
    }
}
