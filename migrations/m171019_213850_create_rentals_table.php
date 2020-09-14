<?php

use yii\db\Migration;

/**
 * Class m171019_213850_create_rentals_table
 */
class m171019_213850_create_rentals_table extends Migration
{
    public $path;
    
    public function up()
    {
        $this->createTable('rentals', [
            'id'                   => $this->primaryKey(),
            'status'               => $this->string(),
            'managed'              => $this->string(),
            'exclusive'            => $this->string(),
            'shared'               => $this->string(),
            'ref'                  => $this->string(),
            'unit'                 => $this->string(),
            'category_id'          => $this->string(),
            'region_id'            => $this->string(),
            'area_location_id'     => $this->string(),
            'sub_area_location_id' => $this->string(),
            'beds'                 => $this->string(),
            'size'                 => $this->string(),
            'price'                => $this->string(),
            'agent_id'             => $this->string(),
            'landlord_id'          => $this->string(),
            'unit_type'            => $this->string(),
            'baths'                => $this->string(),
            'street_no'            => $this->string(),
            'floor_no'             => $this->string(),
            'dewa_no'              => $this->string(),
            'photos'               => $this->string(),
            'cheques'              => $this->string(),
            'fitted'               => $this->string(),
            'prop_status'          => $this->string(),
            'source_of_listing'    => $this->string(),
            'available_date'       => $this->string(),
            'remind_me'            => $this->string(),
            'floor_plans'          => $this->string(),
            'furnished'            => $this->string(),
            'featured'             => $this->string(),
            'maintenance'          => $this->string(),
            'strno'                => $this->string(),
            'amount'               => $this->string(),
            'tenanted'             => $this->string(),
            'plot_size'            => $this->string(),
            'name'                 => $this->string(),
            'view_id'              => $this->string(),
            'commission'           => $this->string(),
            'deposit'              => $this->string(),
            'unit_size_price'      => $this->string(),
            'dateadded'            => $this->string(),
            'dateupdated'          => $this->string(),
            'user_id'              => $this->string(),
            'key_location'         => $this->string(),
            'international'        => $this->string(),
            'rand_key'             => $this->string(),
            'development_unit_id'  => $this->string(),
            'type'                 => $this->string(),
            'rera_permit'          => $this->string(),
            'DT_RowClass'          => $this->string(),
            'DT_RowId'             => $this->string(),
            'tenure'               => $this->string(),
            'completion_status'    => $this->string(),
            'owner_mobile'         => $this->string(),
            'owner_email'          => $this->string(),
            'secondary_ref'        => $this->string(),
            'terminal'             => $this->string(),
            'other_title_2'        => $this->string(),
            'invite'               => $this->string(),
            'poa'                  => $this->string(),
            'rented_at'            => $this->string(),
            'rented_until'         => $this->string(),
            'description'          => $this->string(),
            'language'             => $this->string(),
            'slug'                 => $this->string(),
            'portals'              => $this->string(),
            'features'             => $this->string(),
            'neighbourhood_info'   => $this->string(),
            'company_id'           => $this->integer(),
            'latitude'             => $this->float(),
            'longitude'            => $this->float(),
        ]);


        /*$this->path = 'migrations/_rentals.sql';
        $this->execute(file_get_contents($this->path));*/
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('rentals');
    }
    
}
