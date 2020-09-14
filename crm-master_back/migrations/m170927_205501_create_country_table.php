<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country`.
 */
class m170927_205501_create_country_table extends Migration
{
    public $path;

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('country', [
            'country_id' => $this->integer(11),
            'ru' => $this->string(60)->null(),
            'ua' => $this->string(60)->null(),
            'be' => $this->string(60)->null(),
            'en' => $this->string(60)->null(),
            'es' => $this->string(60)->null(),
            'pt' => $this->string(60)->null(),
            'de' => $this->string(60)->null(),
            'fr' => $this->string(60)->null(),
            'it' => $this->string(60)->null(),
            'pl' => $this->string(60)->null(),
            'ja' => $this->string(60)->null(),
            'lt' => $this->string(60)->null(),
            'lv' => $this->string(60)->null(),
            'cz' => $this->string(60)->null(),
        ]);

        $this->path = 'migrations/_countries.sql';
        $this->execute(file_get_contents($this->path));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('country');
    }
}

