<?php

use yii\db\Migration;

/**
 * Handles the creation of table `commercial_sales`.
 */
class m171031_213835_create_commercial_sales_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('commercial_sales', [
            'id' => $this->primaryKey(),
            'user_id' => $this->string(),
            'ref' => $this->string(),
            'completion_status' => $this->string(),
            'category' => $this->string(),
            'beds' => $this->string(),
            'bath' => $this->string(),
            'emirate' => $this->string(),
            'permit' => $this->string(),
            'location' => $this->string(),
            'sub_location' => $this->string(),
            'tenure' => $this->string(),
            'unit' => $this->string(),
            'type' => $this->string(),
            'street' => $this->string(),
            'floor' => $this->string(),
            'built' => $this->string(),
            'plot' => $this->string(),
            'view' => $this->string(),
            'furnished' => $this->string(),
            'price' => $this->string(),
            'parking' => $this->string(),
            'price_2' => $this->string(),
            'status' => $this->string(),
            'photos' => $this->text(),
            'floor_plans' => $this->text(),
            'language' => $this->string(),
            'title' => $this->string(),
            'description' => $this->text(),
            'portals' => $this->text(),
            'features' => $this->text(),
            'neighbourhood' => $this->text(),
            'property_status' => $this->string(),
            'source_listing' => $this->string(),
            'featured' => $this->string(),
            'dewa' => $this->string(),
            'str' => $this->string(),
            'available' => $this->string(),
            'remind' => $this->string(),
            'key_location' => $this->string(),
            'property' => $this->string(),
            'rented_at' => $this->string(),
            'rented_until' => $this->string(),
            'maintenance' => $this->string(),
            'managed' => $this->string(),
            'exclusive' => $this->string(),
            'invite' => $this->string(),
            'poa' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('commercial_sales');
    }
}
