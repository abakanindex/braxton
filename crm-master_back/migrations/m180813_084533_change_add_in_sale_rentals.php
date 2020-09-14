<?php

use yii\db\Migration;
use app\models\{
    Sale, SaleArchive, SalePending,
    Rentals, RentalsArchive, RentalsPending
};

/**
 * Class m180813_084533_change_add_in_sale_rentals
 */
class m180813_084533_change_add_in_sale_rentals extends Migration
{
    public function up()
    {
        $this->alterColumn(Sale::tableName(), 'description', $this->text());
        $this->alterColumn(SaleArchive::tableName(), 'description', $this->text());
        $this->alterColumn(SalePending::tableName(), 'description', $this->text());

        $this->alterColumn(Rentals::tableName(), 'description', $this->text());
        $this->alterColumn(RentalsArchive::tableName(), 'description', $this->text());
        $this->alterColumn(RentalsPending::tableName(), 'description', $this->text());
    }

    public function down()
    {
        $this->alterColumn(Sale::tableName(), 'description', $this->string());
        $this->alterColumn(SaleArchive::tableName(), 'description', $this->string());
        $this->alterColumn(SalePending::tableName(), 'description', $this->string());

        $this->alterColumn(Rentals::tableName(), 'description', $this->string());
        $this->alterColumn(RentalsArchive::tableName(), 'description', $this->string());
        $this->alterColumn(RentalsPending::tableName(), 'description', $this->string());
    }
}
