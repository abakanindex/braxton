<?php

use yii\db\Migration;

/**
 * Handles the creation of table `property_category`.
 */
class m180205_130345_create_property_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('property_category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'order' => $this->integer(2)->notNull()->unique(),
        ]);

        $this->execute("INSERT INTO `property_category` (`id`, `title`, `order`) VALUES
            (1, 'Apartment', 1),
            (2, 'Office', 2),
            (3, 'Villa', 3),
            (4, 'Retail', 4),
            (5, 'Hotel Apartment', 5),
            (6, 'Warehouse', 6),
            (7, 'Land Commercial', 7),
            (8, 'Labour Camp', 8),
            (9, 'Residential Building', 9),
            (10, 'Multiple Sale Units', 10),
            (15, 'Land Residential', 11),
            (16, 'Commercial Full Building', 12),
            (17, 'Penthouse', 13),
            (18, 'Duplex', 14),
            (19, 'Loft Apartment', 15),
            (20, 'Townhouse', 16),
            (21, 'Hotel', 17),
            (22, 'Land Mixed Use', 18),
            (23, 'Compound', 19),
            (24, 'Half Floor', 20),
            (25, 'Full Floor', 21),
            (28, 'Commercial Villa', 22),
            (29, 'Bungalow', 23),
            (30, 'Factory', 24),
            (31, 'Staff Accommodation', 25),
            (32, 'Multiple Rental Units', 26),
            (33, 'Residential Full Floor', 27),
            (34, 'Commercial Full Floor', 28),
            (35, 'Residential Half Floor', 29),
            (36, 'Commercial Half Floor', 30),
            (37, 'Completed', 31)
            ");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('property_category');
    }
}
