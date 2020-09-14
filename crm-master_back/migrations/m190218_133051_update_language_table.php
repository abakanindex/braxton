<?php

use yii\db\Migration;
use app\models\Language;

/**
 * Class m190218_133051_update_language_table
 */
class m190218_133051_update_language_table extends Migration
{
    public $path;

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->delete(Language::tableName());
        $this->path = 'migrations/_languages.sql';
        $this->execute(file_get_contents($this->path));
    }

    public function down()
    {
        $this->delete(Language::tableName());
    }
}
