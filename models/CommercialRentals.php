<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%commercial_rentals}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $ref
 * @property int $completion_status
 * @property int $category
 * @property int $beds
 * @property int $bath
 * @property int $emirate
 * @property string $permit
 * @property int $location
 * @property int $sub_location
 * @property int $tenure
 * @property string $unit
 * @property string $type
 * @property string $street
 * @property string $floor
 * @property string $built
 * @property string $plot
 * @property string $view
 * @property int $furnished
 * @property int $price
 * @property string $parking
 * @property int $price_2
 * @property int $status
 * @property string $photos
 * @property string $floor_plans
 * @property int $language
 * @property string $title
 * @property string $description
 * @property string $portals
 * @property string $features
 * @property string $neighbourhood
 * @property int $property_status
 * @property int $source_listing
 * @property int $featured
 * @property string $dewa
 * @property string $str
 * @property string $available
 * @property int $remind
 * @property int $key_location
 * @property int $property
 * @property string $rented_at
 * @property string $rented_until
 * @property string $maintenance
 * @property int $managed
 * @property int $exclusive
 * @property int $invite
 * @property int $poa
 */
class CommercialRentals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%commercial_rentals}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[],'required'],
            [['user_id', 'ref', 'completion_status', 'category', 'beds', 'bath', 'emirate', 'location', 'sub_location', 'tenure', 'furnished', 'price', 'price_2', 'status', 'language', 'property_status', 'source_listing', 'featured', 'remind', 'key_location', 'property', 'managed', 'exclusive', 'invite', 'poa'], 'string'],
            [['description',  'neighbourhood'], 'string'],
            [['portals','features', 'photos', 'floor_plans'], 'safe'],
            [['permit', 'unit', 'type', 'street', 'floor', 'built', 'plot', 'view', 'parking', 'title', 'dewa', 'str', 'available', 'rented_at', 'rented_until', 'maintenance'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Assigned To'),
            'ref' => Yii::t('app', 'Ref'),
            'completion_status' => Yii::t('app', 'Completion Status'),
            'category' => Yii::t('app', 'Category'),
            'beds' => Yii::t('app', 'Beds'),
            'bath' => Yii::t('app', 'Bath'),
            'emirate' => Yii::t('app', 'Emirate'),
            'permit' => Yii::t('app', 'Permit'),
            'location' => Yii::t('app', 'Location'),
            'sub_location' => Yii::t('app', 'Sub Location'),
            'tenure' => Yii::t('app', 'Tenure'),
            'unit' => Yii::t('app', 'Unit'),
            'type' => Yii::t('app', 'Type'),
            'street' => Yii::t('app', 'Street'),
            'floor' => Yii::t('app', 'Floor'),
            'built' => Yii::t('app', 'Built'),
            'plot' => Yii::t('app', 'Plot'),
            'view' => Yii::t('app', 'View'),
            'furnished' => Yii::t('app', 'Furnished'),
            'price' => Yii::t('app', 'Price'),
            'parking' => Yii::t('app', 'Parking'),
            'price_2' => Yii::t('app', 'Price 2'),
            'status' => Yii::t('app', 'Status'),
            'photos' => Yii::t('app', 'Photos'),
            'floor_plans' => Yii::t('app', 'Floor Plans'),
            'language' => Yii::t('app', 'Language'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'portals' => Yii::t('app', 'Portals'),
            'features' => Yii::t('app', 'Features'),
            'neighbourhood' => Yii::t('app', 'Neighbourhood'),
            'property_status' => Yii::t('app', 'Property Status'),
            'source_listing' => Yii::t('app', 'Source Listing'),
            'featured' => Yii::t('app', 'Featured'),
            'dewa' => Yii::t('app', 'Dewa'),
            'str' => Yii::t('app', 'Str'),
            'available' => Yii::t('app', 'Available'),
            'remind' => Yii::t('app', 'Remind'),
            'key_location' => Yii::t('app', 'Key Location'),
            'property' => Yii::t('app', 'Property'),
            'rented_at' => Yii::t('app', 'Rented At'),
            'rented_until' => Yii::t('app', 'Rented Until'),
            'maintenance' => Yii::t('app', 'Maintenance'),
            'managed' => Yii::t('app', 'Managed'),
            'exclusive' => Yii::t('app', 'Exclusive'),
            'invite' => Yii::t('app', 'Invite'),
            'poa' => Yii::t('app', 'Poa'),
        ];
    }
}
