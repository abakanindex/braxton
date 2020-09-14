<?php

namespace app\models;

use app\interfaces\relationShip\iRelationShip;
use app\models\reference_books\Portals;
use app\models\reference_books\PropertyCategory;
use Yii;

/**
 * This is the model class for table "portal_listing".
 *
 * @property int $id
 * @property string $ref
 * @property int $portal_id
 * @property int $type
 *
 * @property Portals $portal
 */
class PortalListing extends \yii\db\ActiveRecord
{
    const TYPE_SALE   = 1;
    const TYPE_RENTAL = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'portal_listing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portal_id', 'type'], 'integer'],
            [['ref'], 'string', 'max' => 255],
            [['portal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portals::className(), 'targetAttribute' => ['portal_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'ref'       => 'Ref',
            'portal_id' => 'Portal ID',
            'type'      => 'Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortal()
    {
        return $this->hasOne(Portals::className(), ['id' => 'portal_id']);
    }

    public static function deleteByRef($ref)
    {
        self::deleteAll(['ref' => $ref]);
    }

    public static function getForXml($portalId, $company, $isHourlyUpdate)
    {
        $tablePortalListing = self::tableName();
        $tableRental        = Rentals::tableName();
        $tableSale          = Sale::tableName();
        $tableLocation      = Locations::tableName();
        $tableCategory      = PropertyCategory::tableName();
        $tableUser          = User::tableName();
        $tableGallery       = Gallery::tableName();
        $published          = iRelationShip::STATUS_PUBLISHED;
        $checkDateUpdated   = ($isHourlyUpdate) ? ' and (tR.dateupdated >= now() - interval 1 day or tS.dateupdated >= now() - interval 1 day) ' : '';

        $query = "select
        tPL.type as listingType,
        if(tR.ref is null or tR.ref = '', tS.ref, tR.ref) as ref,
        if(tR.price is null or tR.price = '', tS.price, tR.price) as price,
        tR.price_per_month as price_per_month,
        tR.price_per_week as price_per_week,
        tR.price_per_day as price_per_day,
        if(tR.dateupdated is null or tR.dateupdated = '', tS.dateupdated, tR.dateupdated) as dateupdated,
        if(tR.rera_permit is null or tR.rera_permit = '', tS.rera_permit, tR.rera_permit) as rera_permit,
        if(tR.plot_size is null or tR.plot_size = '', tS.plot_size, tR.plot_size) as plot_size,
        if(tR.size is null or tR.size = '', tS.size, tR.size) as size,
        if(tR.beds is null or tR.beds = '', tS.beds, tR.beds) as beds,
        if(tR.baths is null or tR.baths = '', tS.baths, tR.baths) as baths,
        if(tR.floor_no is null or tR.floor_no = '', tS.floor_no, tR.floor_no) as floor_no,
        if(tR.name is null or tR.name = '', tS.name, tR.name) as name,
        if(tR.description is null or tR.description = '', tS.description, tR.description) as description,
        if(tLR.name is null or tLR.name = '', tLS.name, tLR.name) as region_name,
        if(tALR.name is null or tALR.name = '', tALS.name, tALR.name) as area_location_name,
        if(tSALR.name is null or tSALR.name = '', tSALS.name, tSALR.name) as sub_area_location_name,
        if(tCatR.title is null or tCatR.title = '', tCatS.title, tCatR.title) as property_category_title,
        if(tUserR.id is null or tUserR.id = '', tUserS.id, tUserR.id) as agent_id,
        if(tUserR.last_name is null or tUserR.last_name = '', tUserS.last_name, tUserR.last_name) as agent_last_name,
        if(tUserR.first_name is null or tUserR.first_name = '', tUserS.first_name, tUserR.first_name) as agent_first_name,
        if(tUserR.email is null or tUserR.email = '', tUserS.email, tUserR.email) as agent_email,
        if(tUserR.mobile_no is null or tUserR.mobile_no = '', tUserS.mobile_no, tUserR.mobile_no) as agent_mobile_no,
        if(tUserR.country_dialing is null or tUserR.country_dialing = '', tUserS.country_dialing, tUserR.country_dialing) as agent_country_dialing,
        if(tR.status is null, tS.status, tR.status) as status,
        if(tR.latitude is null, tS.latitude, tR.latitude) as latitude,
        if(tR.longitude is null, tS.longitude, tR.longitude) as longitude,
        if(tR.dateupdated is null, tS.dateupdated, tR.dateupdated) as dateupdated,
        group_concat(tGal.path) as imagesPath

        from `$tablePortalListing` tPL

        left join `$tableRental` tR on tR.ref = tPL.ref
        left join `$tableSale`   tS on tS.ref = tPL.ref

        left join `$tableLocation` tLR on tLR.id = tR.region_id
        left join `$tableLocation` tLS on tLS.id = tS.region_id

        left join `$tableLocation` tALR on tALR.id = tR.area_location_id
        left join `$tableLocation` tALS on tALS.id = tS.area_location_id

        left join `$tableLocation` tSALR on tSALR.id = tR.sub_area_location_id
        left join `$tableLocation` tSALS on tSALS.id = tS.sub_area_location_id

        left join `$tableCategory` tCatR on tCatR.id = tR.category_id
        left join `$tableCategory` tCatS on tCatS.id = tS.category_id

        left join $tableUser tUserR on tUserR.id = tR.agent_id
        left join $tableUser tUserS on tUserS.id = tS.agent_id

        left join $tableGallery tGal on tGal.ref = (case when (tR.ref is not null and tR.ref <> '') then tR.ref else tS.ref end )

        where tPL.portal_id = '$portalId'
        and (tR.status = '$published' or tS.status = '$published')
        $checkDateUpdated
        and (tR.company_id = '$company' or tS.company_id = '$company')
        group by tPL.ref";

        return Yii::$app->db->createCommand($query)->queryAll();
    }
}
