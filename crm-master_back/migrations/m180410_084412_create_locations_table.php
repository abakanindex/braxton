<?php

use yii\db\Migration;

/**
 * Handles the creation of table `locations`.
 */
class m180410_084412_create_locations_table extends Migration
{
    public $path;

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('locations', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type' => $this->integer(),
            'parent_id' => $this->integer()
        ]);

        $this->path = 'migrations/_locations.sql';
        $this->execute(file_get_contents($this->path));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('locations');
    }
}
