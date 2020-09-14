<?php

use yii\db\Migration;

/**
 * Handles the creation of table `nationalities`.
 */
class m171007_201057_create_nationalities_table extends Migration
{
    public $path;
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('nationalities', [
            'id' => $this->primaryKey(),
            'national' => $this->text(),
        ]);

        $this->path = 'migrations/_nationalities.sql';
        $this->execute(file_get_contents($this->path));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('nationalities');
    }
}
