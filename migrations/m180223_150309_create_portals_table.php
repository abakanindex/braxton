<?php

use yii\db\Migration;

/**
 * Handles the creation of table `portals`.
 */
class m180223_150309_create_portals_table extends Migration
{
    public $path;
    
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('portals', [
            'id' => $this->primaryKey(),
            'portals' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('portals');
    }
}
