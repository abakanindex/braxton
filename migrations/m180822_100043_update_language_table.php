<?php

use yii\db\Migration;
use app\models\Language;

/**
 * Class m180822_100043_update_language_table
 */
class m180822_100043_update_language_table extends Migration
{
    public $path;

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn(Language::tableName(), 'name', $this->string());

        $this->path = "migrations/_languages.sql";
        $this->execute(file_get_contents($this->path));
    }

    public function down()
    {
        $this->dropColumn(Language::tableName(), 'name');

        $table = Language::tableName();
        Yii::$app->db->createCommand("delete from $table")->execute();
    }

}
