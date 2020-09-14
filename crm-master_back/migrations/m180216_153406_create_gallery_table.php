<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gallery`.
 */
class m180216_153406_create_gallery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('gallery', [
            'id' => $this->primaryKey(),
            'ref' => $this->string(),
            'path' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('gallery');
    }
}
