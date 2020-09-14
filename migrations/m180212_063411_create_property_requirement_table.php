<?php

use yii\db\Migration;

/**
 * Handles the creation of table `property_requirement`.
 */
class m180212_063411_create_property_requirement_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('property_requirement', [
            'id' => $this->primaryKey(),
            'lead_id' => $this->integer()->notNull(),
            'category_id' => $this->integer(),
            'location' => $this->string(),
            'sub_location' => $this->string(),
            'min_beds' => $this->integer(2),
            'max_beds' => $this->integer(2),
            'min_price' => $this->integer(),
            'max_price' => $this->integer(),
            'min_area' => $this->integer(),
            'max_area' => $this->integer(),
            'unit_type' => $this->string(),
            'unit' => $this->string(),
            'company_id' => $this->integer(),

            'ref' => $this->string(),
            'size' => $this->string(),
            'min_baths' => $this->string(),
            'max_baths' => $this->string(),
            'street_no' => $this->string(),
            'floor_no' => $this->string(),
            'dewa_no' => $this->string(),
            'photos' => $this->string(),
            'cheques' => $this->string(),
            'fitted' => $this->string(),
            'prop_status' => $this->string(),
            'source_of_listing' => $this->string(),
            'available_date' => $this->string(),
            'furnished' => $this->string(),
            'featured' => $this->string(),
            'maintenance' => $this->string(),
            'strno' => $this->string(),
            'amount' => $this->string(),
            'tenanted' => $this->string(),
            'plot_size' => $this->string(),
            'name' => $this->string(),
            'view_id' => $this->string(),
            'commission' => $this->string(),
            'deposit' => $this->string(),
            'unit_size_price' => $this->string(),
            'dateadded' => $this->string(),
            'dateupdated' => $this->string(),
            'user_id' => $this->string(),
            'key_location' => $this->string(),
            'international' => $this->string(),
            'rand_key' => $this->string(),
            'development_unit_id' => $this->string(),
            'rera_permit' => $this->string(),
            'tenure' => $this->string(),
            'completion_status' => $this->string(),
            'DT_RowClass' => $this->string(),
            'DT_RowId' => $this->string(),
            'owner_mobile' => $this->string(),
            'owner_email' => $this->string(),
            'secondary_ref' => $this->string(),
            'terminal' => $this->string(),
            'other_title_2' => $this->string(),
            'invite' => $this->string(),
            'poa' => $this->string(),
            'description' => $this->string(),
            'language' => $this->string(),
            'portals' => $this->string(),
            'features' => $this->string(),
            'neighbourhood_info' => $this->string(),
        ]);

        $this->createIndex(
            'idx-property_requirement-lead_id',
            'property_requirement',
            'lead_id'
        );

        $this->addForeignKey(
            'fk-property_requirement-lead_id',
            'property_requirement',
            'lead_id',
            'leads',
            'id',
            'CASCADE'
        );

//        $this->createIndex(
//            'idx-property_requirement-company_id',
//            'property_requirement',
//            'company_id'
//        );
//
//        $this->addForeignKey(
//            'fk-property_requirement-company_id',
//            'property_requirement',
//            'company_id',
//            'company',
//            'id',
//            'CASCADE'
//        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
//        $this->dropForeignKey(
//            'fk-property_requirement-company_id',
//            'property_requirement'
//        );
//
//        $this->dropIndex(
//            'idx-property_requirement-company_id',
//            'property_requirement'
//        );

        $this->dropForeignKey(
            'fk-property_requirement-lead_id',
            'property_requirement'
        );

        $this->dropIndex(
            'idx-property_requirement-lead_id',
            'property_requirement'
        );

        $this->dropTable('property_requirement');
    }
}
