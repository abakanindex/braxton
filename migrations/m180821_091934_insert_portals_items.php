<?php

use yii\db\Migration;
use app\models\reference_books\Portals;

/**
 * Class m180821_091934_insert_portals_items
 */
class m180821_091934_insert_portals_items extends Migration
{

    public $path;

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $table = Portals::tableName();
        Yii::$app->db->createCommand("delete from $table")->execute();

        $this->path = 'migrations/_portals.sql';
        $this->execute(file_get_contents($this->path));
    }

    public function down()
    {
        $table = Portals::tableName();
        Yii::$app->db->createCommand("delete from $table")->execute();
    }
}
