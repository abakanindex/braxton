<?php

use yii\db\Migration;
use app\models\Gallery;

/**
 * Class m181126_123214_add_field_gallery_table
 */
class m181126_123214_add_field_gallery_table extends Migration
{
    public function up()
    {
        $this->addColumn(Gallery::tableName(), 'path_thumbnail', $this->string());
    }

    public function down()
    {
        $this->dropColumn(Gallery::tableName(), 'path_thumbnail');
    }
}
