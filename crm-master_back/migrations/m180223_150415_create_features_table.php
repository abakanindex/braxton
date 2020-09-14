<?php

use yii\db\Migration;

/**
 * Handles the creation of table `features`.
 */
class m180223_150415_create_features_table extends Migration
{
    public $path;
    
    /**
     * {@inheritdoc}
     */
    public function Up()
    {
        $this->createTable('features', [
            'id' => $this->primaryKey(),
            'features' => $this->string(),
        ]);

        $this->path = 'migrations/_features.sql';
        $this->execute(file_get_contents($this->path));
    }

    /**
     * {@inheritdoc}
     */
    public function Down()
    {
        $this->dropTable('features');
    }
}
