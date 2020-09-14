<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lead_type`.
 */
class m180205_124909_create_lead_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lead_type', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'order' => $this->integer(2)->notNull()->unique()
        ]);

        $this->execute("INSERT INTO `lead_type` (`id`, `title`, `order`) VALUES
            (1, 'Tenant', 1),
            (2, 'Buyer', 2),
            (3, 'Landlord', 3),
            (4, 'Seller', 4),
            (5, 'Landlord+Seller', 5),
            (6, 'Not specified', 6),
            (7, 'Investor', 7),
            (8, 'Agent', 8);");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lead_type');
    }
}
