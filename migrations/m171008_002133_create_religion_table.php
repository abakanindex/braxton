<?php

use yii\db\Migration;

/**
 * Handles the creation of table `religion`.
 */
class m171008_002133_create_religion_table extends Migration
{
    public $path;
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('religion', [
            'id' => $this->primaryKey(),
            'religions' => $this->text(),
        ]);

        $this->path = 'migrations/_religions.sql';
        $this->execute(file_get_contents($this->path));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('religion');
    }
}
