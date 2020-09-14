<?php

namespace app\models;

use app\models\reference_books\PropertyCategory;
use Yii;
use yii\behaviors\SluggableBehavior;

class Rentals extends \yii\db\ActiveRecord
{


    public $CommissionPercent;
    public $DepositPercent;    
    public $number;

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'ref',
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rentals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'ref', 'completion_status', 'emirate', 'location', 'sub_location', 'tenure', 'furnished', 'price_2', 'status', 'language', 'property_status', 'source_listing', 'featured', 'remind', 'key_location', 'property', 'managed', 'exclusive', 'invite', 'poa'], 'string'],
            [['description',  'neighbourhood', 'deposit', 'commission', 'owner'], 'string'],
            [['portals','features', 'photos', 'floor_plans'], 'safe'],
            [['permit', 'unit', 'type', 'street', 'floor', 'built', 'plot', 'view', 'parking', 'title', 'dewa', 'str', 'available', 'rented_at', 'rented_until', 'maintenance'], 'safe'],
            [['beds', 'bath', 'area'], 'integer'],
            [['price'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Assigned To',
            'ref' => 'Ref',
            'completion_status' => 'Completion Status',
            'category_id' => 'Category',
            'beds' => 'Beds',
            'bath' => 'Bath',
            'emirate' => 'Emirate',
            'permit' => 'Permit',
            'location' => 'Location',
            'sub_location' => 'Sub Location',
            'tenure' => 'Tenure',
            'unit' => 'Unit',
            'type' => 'Type',
            'street' => 'Street',
            'floor' => 'Floor',
            'built' => 'Built-up area',
            'plot' => 'Plot',
            'view' => 'View',
            'furnished' => 'Furnished',
            'price' => 'Price (AED)',
            'parking' => 'Parking',
            'price_2' => 'Price/',
            'commission' => 'Commission(AED)',
            'deposit' => 'Deposit(AED)',
            'status' => 'Status',
            'photos' => 'Photos',
            'floor_plans' => 'Floor Plans',
            'language' => 'Language',
            'title' => 'Title',
            'description' => 'Description',
            'portals' => 'Portals',
            'features' => 'Features',
            'neighbourhood' => 'Neighbourhood',
            'property_status' => 'Property Status',
            'source_listing' => 'Source Listing',
            'featured' => 'Featured',
            'dewa' => 'DEWA Number',
            'str' => 'STR #',
            'available' => 'Next available',
            'remind' => 'Remind',
            'key_location' => 'Key Location',
            'property' => 'Property',
            'rented_at' => 'Rented At',
            'rented_until' => 'Rented Until',
            'maintenance' => 'Maintenance',
            'managed' => 'Managed',
            'exclusive' => 'Exclusive',
            'invite' => 'Invite',
            'poa' => 'Poa',
            'owner' => 'Owner'
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'category_id']);
    }

    public function getCategoryRel()
    {
        if ($this->category_id)
            return $this->category->title;
        else return '';
    }
}
