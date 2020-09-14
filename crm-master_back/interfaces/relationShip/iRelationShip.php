<?php
namespace app\interfaces\relationShip;

interface iRelationShip
{
    const STATUS_PUBLISHED   = 'Published';
    const STATUS_UNPUBLISHED = 'Unpublished';
    const STATUS_PENDING     = 'Pending';
    const STATUS_DRAFT       = 'Draft';

    const PROPERTY_STATUS_AVAILABLE = 'Available';
    const PROPERTY_STATUS_OFF_PLAN  = 'Off-Plan';
    const PROPERTY_STATUS_PENDING   = 'Pending';
    const PROPERTY_STATUS_RESERVED  = 'Reserved';
    const PROPERTY_STATUS_SOLD      = 'Sold';
    const PROPERTY_STATUS_UPCOMING  = 'Upcoming';

    const XML_PROPERTY_FINDER_TYPE_SALE   = "RS";
    const XML_PROPERTY_FINDER_TYPE_RENTAL = "RR";
    const XML_DUBIZZLE_TYPE_SALE          = "SP";
    const XML_DUBIZZLE_TYPE_RENTAL        = "RP";
    const XML_BAYUT_TYPE_SALE             = "Buy";
    const XML_BAYUT_TYPE_RENTAL           = "Rent";
    const XML_DUBIZZLE_RENT_TERM_YEAR     = "YR";
    const XML_DUBIZZLE_RENT_TERM_MONTH    = "MO";

    public function getCategory();

    public function getAgent();

    public function getContact();

    public function getGallery();

    public function getEmirate();

    public function getLocation();

    public function getSubLocation();

    public function getAssignedTo();

    public function getOwner();

    public static function getColumns($dataProvider);

    public static function getCountByStatus($status);

    public static function getTopLocation($limit);

    public static function getTopAgent($limit);

    public static function getTopCategories($limit);

    public static function getTopRegions($limit);

    public static function getByPriceInRange($minPrice, $maxPrice);

    public static function getTotalWithCategories();

    public static function getMatchWithLead($propertyRequirement, $flagExact, $userId, $emirate, $location);

    public static function getStatuses();

    public static function getPropertyStatuses();
}