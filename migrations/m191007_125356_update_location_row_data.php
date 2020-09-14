<?php

use yii\db\Migration;
use \app\models\Locations;

/**
 * Class m191007_125356_update_location_row_data
 */
class m191007_125356_update_location_row_data extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        Yii::$app->db->createCommand()->update(Locations::tableName(), array(
            'name' => 'Opal Tower'
        ), 'name=:name', array(':name' => 'Opal'))->execute();
    }

    public function down()
    {
        Yii::$app->db->createCommand()->update(Locations::tableName(), array(
            'name' => 'Opal'
        ), 'name=:name', array(':name' => 'Opal Tower'))->execute();
    }
}
