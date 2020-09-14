<?php

use yii\db\Migration;

/**
 * Class m180806_133552_add_column_to_sale_rental
 */
class m180806_133552_add_column_to_sale_rental extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('rentals', 'is_parsed', $this->boolean());
        $this->addColumn('rentals_archive', 'is_parsed', $this->boolean());
        $this->addColumn('rentals_pending', 'is_parsed', $this->boolean());
        $this->addColumn('sale', 'is_parsed', $this->boolean());
        $this->addColumn('sale_archive', 'is_parsed', $this->boolean());
        $this->addColumn('sale_pending', 'is_parsed', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('rentals', 'is_parsed');
        $this->dropColumn('rentals_archive', 'is_parsed');
        $this->dropColumn('rentals_pending', 'is_parsed');
        $this->dropColumn('sale', 'is_parsed');
        $this->dropColumn('sale_archive', 'is_parsed');
        $this->dropColumn('sale_pending', 'is_parsed');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180806_133552_add_column_to_sale_rental cannot be reverted.\n";

        return false;
    }
    */
}
