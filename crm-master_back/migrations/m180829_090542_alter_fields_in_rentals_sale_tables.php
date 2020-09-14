<?php

use yii\db\Migration;
use app\models\{Sale, Rentals};

/**
 * Class m180829_090542_alter_fields_in_rentals_sale_tables
 */
class m180829_090542_alter_fields_in_rentals_sale_tables extends Migration
{
    public function up()
    {
        $this->alterColumn(Sale::tableName(), 'dateadded', $this->timestamp()->null());
        $this->alterColumn(Sale::tableName(), 'dateupdated', $this->timestamp()->null());

        $this->alterColumn(Rentals::tableName(), 'dateadded', $this->timestamp()->null());
        $this->alterColumn(Rentals::tableName(), 'dateupdated', $this->timestamp()->null());
    }

    public function down()
    {
        $this->alterColumn(Sale::tableName(), 'dateadded', $this->string());
        $this->alterColumn(Sale::tableName(), 'dateupdated', $this->string());

        $this->alterColumn(Rentals::tableName(), 'dateadded', $this->string());
        $this->alterColumn(Rentals::tableName(), 'dateupdated', $this->string());
    }
}
