<?php
use app\models\Rentals;
use yii\db\Migration;

/**
 * Class m180917_094826_update_rental_table
 */
class m180917_094826_update_rental_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn(Rentals::tableName(), 'price_per_day',  $this->float());
        $this->addColumn(Rentals::tableName(), 'price_per_week', $this->float());
        $this->addColumn(Rentals::tableName(), 'price_per_month', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn(Rentals::tableName(), 'price_per_day');
        $this->dropColumn(Rentals::tableName(), 'price_per_week');
        $this->dropColumn(Rentals::tableName(), 'price_per_month');
    }
}
