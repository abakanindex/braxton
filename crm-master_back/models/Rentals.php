<?php

namespace app\models;

use app\models\reference_books\PropertyCategory;
use Yii;
use yii\behaviors\SluggableBehavior;
use app\models\Company;
use app\interfaces\relationShip\iRelationShip;
use app\interfaces\firstrecordmodel\IfirstRecordModel;
use app\models\statusHistory\ArchiveHistory;
use app\modules\admin\models\OwnerManageGroup;
use yii\db\Query;

/**
 * This is the model class for table "rentals".
 *
 * @property int    $id
 * @property string $status
 * @property string $managed
 * @property string $exclusive
 * @property string $shared
 * @property string $ref
 * @property string $unit
 * @property string $category_id
 * @property string $region_id
 * @property string $area_location_id
 * @property string $sub_area_location_id
 * @property string $beds
 * @property string $size
 * @property string $price
 * @property string $agent_id
 * @property string $landlord_id
 * @property string $unit_type
 * @property string $baths
 * @property string $street_no
 * @property string $floor_no
 * @property string $dewa_no
 * @property string $photos
 * @property string $cheques
 * @property string $fitted
 * @property string $prop_status
 * @property string $source_of_listing
 * @property string $available_date
 * @property string $remind_me
 * @property string $floor_plans
 * @property string $furnished
 * @property string $featured
 * @property string $maintenance
 * @property string $strno
 * @property string $amount
 * @property string $tenanted
 * @property string $plot_size
 * @property string $name
 * @property string $view_id
 * @property string $commission
 * @property string $deposit
 * @property string $unit_size_price
 * @property string $dateadded
 * @property string $dateupdated
 * @property string $user_id
 * @property string $key_location
 * @property string $international
 * @property string $rand_key
 * @property string $development_unit_id
 * @property string $type
 * @property string $rera_permit
 * @property string $DT_RowClass
 * @property string $DT_RowId
 * @property string $tenure
 * @property string $completion_status
 * @property string $owner_mobile
 * @property string $owner_email
 * @property string $secondary_ref
 * @property string $terminal
 * @property string $other_title_2
 * @property string $slug
 * @property int    $company_id
 * @property double $latitude
 * @property double $longitude
 * @property double $price_per_day
 * @property double $price_per_week
 * @property double $price_per_month
 */
class Rentals extends \yii\db\ActiveRecord implements iRelationShip, IfirstRecordModel
{

    public $CommissionPercent;
    public $DepositPercent;
    public $number;
    public $month;
    public $countByMonth;
    public $countDeals;
    public $username;
    public $viewingStatus;
    public $priceCommon;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rentals';
    }

    /**
     * {@inheritdoc}
     * @param $insert
     * @return void
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (Yii::$app->controller->action->id === 'update') {

                $archive = new ArchiveHistory(self::findOne($this->id));
                $archive->addArchiveProperty(
                    $this->getDirtyAttributes(),
                    $this->getOldAttributes()
                );

            }
            return true;
        }
        return false;
    }

    public function behaviors()
    {
        return [
            [
                'class'     => SluggableBehavior::className(),
                'attribute' => 'ref',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['is_parsed'], 'boolean'],
            [['latitude', 'longitude', 'price_per_day', 'price_per_week', 'price_per_month'], 'number'],
            [
                [
                    'status', 
                    'managed', 
                    'invite', 
                    'portals', 
                    'features', 
                    'neighbourhood_info', 
                    'description', 
                    'language', 
                    'rented_at', 
                    'rented_until', 
                    'poa', 
                    'exclusive', 
                    'shared', 
                    'ref', 
                    'unit', 
                    'category_id', 
                    'region_id', 
                    'area_location_id', 
                    'sub_area_location_id', 
                    'beds', 
                    'size', 
                    'price', 
                    'agent_id', 
                    'landlord_id', 
                    'unit_type', 
                    'baths', 
                    'street_no', 
                    'floor_no', 
                    'dewa_no', 
                    'photos', 
                    'cheques', 
                    'fitted', 
                    'prop_status', 
                    'source_of_listing', 
                    'available_date', 
                    'remind_me', 
                    'furnished', 
                    'featured', 
                    'maintenance', 
                    'strno', 
                    'amount', 
                    'tenanted', 
                    'plot_size', 
                    'name', 
                    'view_id', 
                    'commission', 
                    'deposit', 
                    'unit_size_price', 
                    'dateadded', 
                    'dateupdated', 
                    'user_id', 
                    'key_location', 
                    'international', 
                    'rand_key', 
                    'development_unit_id', 
                    'type', 
                    'rera_permit', 
                    'tenure', 
                    'completion_status', 
                    'DT_RowClass', 
                    'DT_RowId', 
                    'owner_mobile', 
                    'owner_email', 
                    'secondary_ref', 
                    'terminal', 
                    'other_title_2', 
                    'slug'
                ], 'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'status'               => Yii::t('app', 'Status'),
            'managed'              => Yii::t('app', 'Managed'),
            'exclusive'            => Yii::t('app', 'Exclusive'),
            'shared'               => Yii::t('app', 'Shared'),
            'ref'                  => Yii::t('app', 'Ref'),
            'unit'                 => Yii::t('app', 'Unit No.'),
            'category_id'          => Yii::t('app', 'Category'),
            'region_id'            => Yii::t('app', 'Emirate'),
            'area_location_id'     => Yii::t('app', 'Location'),
            'sub_area_location_id' => Yii::t('app', 'Sub-Location'),
            'beds'                 => Yii::t('app', 'Beds'),
            'size'                 => Yii::t('app', 'BUA'),
            'price'                => Yii::t('app', 'Price'),
            'agent_id'             => Yii::t('app', 'Assigned To'),
            'landlord_id'          => Yii::t('app', 'Owner'),
            'unit_type'            => Yii::t('app', 'Unit Type'),
            'baths'                => Yii::t('app', 'Baths'),
            'street_no'            => Yii::t('app', 'Street No'),
            'floor_no'             => Yii::t('app', 'Floor'),
            'dewa_no'              => Yii::t('app', 'Dewa'),
            'photos'               => Yii::t('app', 'Photos'),
            'cheques'              => Yii::t('app', 'Cheques'),
            'fitted'               => Yii::t('app', 'Fitted'),
            'prop_status'          => Yii::t('app', 'Property Status'),
            'source_of_listing'    => Yii::t('app', 'Source Of Listing'),
            'available_date'       => Yii::t('app', 'Available Date'),
            'remind_me'            => Yii::t('app', 'Remind'),
            'furnished'            => Yii::t('app', 'Furnished'),
            'featured'             => Yii::t('app', 'Featured'),
            'maintenance'          => Yii::t('app', 'Maintenance'),
            'strno'                => Yii::t('app', 'STR'),
            'amount'               => Yii::t('app', 'Amount'),
            'tenanted'             => Yii::t('app', 'Tenanted'),
            'plot_size'            => Yii::t('app', 'Plot Size'),
            'name'                 => Yii::t('app', 'Title'),
            'view_id'              => Yii::t('app', 'View'),
            'commission'           => Yii::t('app', 'Commission'),
            'deposit'              => Yii::t('app', 'Deposit'),
            'unit_size_price'      => Yii::t('app', 'Price /'),
            'dateadded'            => Yii::t('app', 'Listed'),
            'dateupdated'          => Yii::t('app', 'Updated'),
            'user_id'              => Yii::t('app', 'Create By'),
            'key_location'         => Yii::t('app', 'Key Location'),
            'international'        => Yii::t('app', 'International'),
            'rand_key'             => Yii::t('app', 'Rand Key'),
            'development_unit_id'  => Yii::t('app', 'Development Unit'),
            'type'                 => Yii::t('app', 'Title AR'),
            'rera_permit'          => Yii::t('app', 'Rera Permit'),
            'tenure'               => Yii::t('app', 'Tenure'),
            'completion_status'    => Yii::t('app', 'Completion Status'),
            'DT_RowClass'          => Yii::t('app', 'Dt  Row Class'),
            'DT_RowId'             => Yii::t('app', 'Dt  Row ID'),
            'owner_mobile'         => Yii::t('app', 'Owner Mobile'),
            'owner_email'          => Yii::t('app', 'Owner Email'),
            'secondary_ref'        => Yii::t('app', 'Secondary Ref'),
            'terminal'             => Yii::t('app', 'Terminal'),
            'other_title_2'        => Yii::t('app', 'Other Title 2'),
            'invite'               => Yii::t('app', 'Invite'),
            'poa'                  => Yii::t('app', 'POA'),
            'rented_at'            => Yii::t('app', 'Rented at'),
            'rented_until'         => Yii::t('app', 'Rented until'),
            'description'          => Yii::t('app', 'description'),
            'language'             => Yii::t('app', 'Language'),
            'slug'                 => Yii::t('app', 'Slug'),
            'portals'              => Yii::t('app', 'Portals'),
            'features'             => Yii::t('app', 'Features'),
            'neighbourhood_info'   => Yii::t('app', 'Neighbourhood Info'),
            'company_id'           => Yii::t('app', 'Company ID'),
            'latitude'             => Yii::t('app', 'Latitude'),
            'longitude'            => Yii::t('app', 'Longitude'),
            'price_per_day'        => Yii::t('app', 'Price Per Day'),
            'price_per_week'       => Yii::t('app', 'Price Per Week'),
            'price_per_month'      => Yii::t('app', 'Price Per Month')
        ];
    }


    /*get columns for grid*/
    public static function getColumns($dataProvider)
    {
        return [
            'beds' => 'beds',
            'size' => 'size',
            'price' => 'price',
            'agent_id' => [
                'attribute' => 'agent_id',
                'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->agent_id)) {
                        return $dataProvider->assignedTo->username;
                    } else {
                        return $dataProvider->agent_id;
                    }
                }
            ],
            'landlord_id' => [
                'attribute' => 'landlord_id',
                'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->landlord_id)) {
                        return $dataProvider->owner->last_name . " " . $dataProvider->owner->first_name;
                    } else {
                        return $dataProvider->landlord_id;
                    }
                },
            ],
            'unit_type' => 'unit_type',
            'baths' => 'baths',
            'street_no' => 'street_no',
            'floor_no' => 'floor_no',
            'dewa_no' => 'dewa_no',
            'photos' => 'photos',
            'cheques' => 'cheques',
            'fitted' => 'fitted',
            'prop_status' => [
                'attribute' => 'prop_status',
                'value' => 'prop_status',
                'filter' => self::getPropertyStatuses(),
            ],
            'source_of_listing' => 'source_of_listing',
            'available_date' => 'available_date',
            'remind_me' => 'remind_me',
            'furnished' => 'furnished',
            'featured' => 'featured',
            'maintenance' => 'maintenance',
            'strno' => 'strno',
            'amount' => 'amount',
            'tenanted' => [
                'attribute' => 'tenanted',
                'value' => 'tenanted',
                'filter' => ['No' => 'No', 'Yes' => 'Yes'],
            ],
            'plot_size' => 'plot_size',
            'name' => 'name',
            'view_id' => 'view_id',
            'commission' => 'commission',
            'deposit' => 'deposit',
            'unit_size_price' => 'unit_size_price',
            'dateadded' => [
                'attribute' => 'dateadded',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->dateadded);
                },
                'format' => 'date',
                'filterType' => \kartik\grid\GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'headerOptions' => ['style' => 'min-width:200px;'],
                'hAlign' => 'center',
            ],
            'dateupdated' => [
                'attribute' => 'dateupdated',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->dateupdated);
                },
                'format' => 'date',
                'filterType' => \kartik\grid\GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'headerOptions' => ['style' => 'min-width:200px;'],
                'hAlign' => 'center',
            ],
//            'user_id' => 'user_id',
            'key_location' => 'key_location',
            'international' => 'international',
//            'development_unit_id' => 'development_unit_id',
            'type' => 'type',
            'rera_permit' => 'rera_permit',
            'tenure' => [
                'attribute' => 'tenure',
                'value' => 'tenure',
                'filter' => ['Freehold' => 'Freehold', 'Leasehold' => 'Leasehold'],
            ],
            'completion_status' => 'completion_status',
            'owner_mobile' => 'owner_mobile',
            'owner_email' => 'owner_email:email'
        ];
    }

    /**
     * Description: without ActiveRecord, faster, use it
     * @param $companyId
     */
    public static function getRentals($companyId) {
        $query = (new Query())->select('')->from(self::tableName());

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->createCommand()->queryAll();
    }

    /*
     * Description: deprecate use getRentals
     */
    public static function getAllRentals($companyId, $flagAll)
    {
        if ($companyId == 'main' or $companyId == 0) {
            $query = self::find();
        } else {
            $query = self::find();
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => Yii::$app->user->id]);
                }
            }
        }

        return ($flagAll) ? $query->all() : $query;
    }

    public static function getNotEmptyOwner($items)
    {
        return self::find()->where(['in', 'id', $items])->andWhere(['>', 'landlord_id', 0])->all();
    }

    public static function getMaxUpdateDateForPortal($portalId, $company)
    {
        $query = new Query();

        return $query
            ->select('r.dateupdated')
            ->from(self::tableName() . ' r')
            ->innerJoin(PortalListing::tableName() . ' pL', 'pL.ref = r.ref')
            ->orderBy('r.dateupdated desc')
            ->where([
                'r.company_id' => $company,
                'pL.portal_id' => $portalId
            ])
            ->one();
    }

    public static function getByLandlord($landlordId)
    {
        $companyId = Company::getCompanyIdBySubdomain();
        $query = self::find()->andWhere(['landlord_id' => $landlordId]);

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query;
    }

    //todo add company id everywhere
    public static function searchBy($value)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query
            ->select([
                'loc_region.name as region_name',
                'loc_area.name as area_name',
                'loc_sub_area.name as sub_area_name',
                's.*',
                'cat.title as category_title'
            ])
            ->from(self::tableName() . ' s')
            ->leftJoin(Locations::tableName() . ' loc_region', 'loc_region.id = s.region_id')
            ->leftJoin(Locations::tableName() . ' loc_area', 'loc_area.id = s.area_location_id')
            ->leftJoin(Locations::tableName() . ' loc_sub_area', 'loc_sub_area.id = s.sub_area_location_id')
            ->leftJoin(PropertyCategory::tableName() . ' cat', 'cat.id = s.category_id')
            ->andWhere([
                'or',
                ['like', 'loc_region.name', $value],
                ['like', 'loc_area.name', $value],
                ['like', 'loc_sub_area.name', $value],
                ['like', 's.ref', $value],
                ['like', 's.beds', $value],
                ['like', 's.size', $value],
                ['like', 's.price', $value],
                ['like', 's.baths', $value],
                ['like', 's.features', $value],
                ['like', 's.description', $value],
                ['like', 'cat.title', $value]
            ])
            ->all();
    }

    //todo add company id everywhere
    public static function getMatchWithLead($propertyRequirement, $flagExact, $userId, $emirate, $location)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->andWhere([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        $query
            ->select([
                'loc_region.name as region_name',
                'loc_area.name as area_name',
                'loc_sub_area.name as sub_area_name',
                's.*',
                'cat.title as category_title'])
            ->from(self::tableName() . ' s')
            ->leftJoin(Locations::tableName() . ' loc_region', 'loc_region.id = s.region_id')
            ->leftJoin(Locations::tableName() . ' loc_area', 'loc_area.id = s.area_location_id')
            ->leftJoin(Locations::tableName() . ' loc_sub_area', 'loc_sub_area.id = s.sub_area_location_id')
            ->leftJoin(PropertyCategory::tableName() . ' cat', 'cat.id = s.category_id');

        $query->andWhere(['and',
            ['=', 's.region_id', $propertyRequirement->emirate],
            ['=', 's.area_location_id', $propertyRequirement->location],
            ['=', 's.category_id', $propertyRequirement->category_id]
        ]);

        if ($flagExact) {
            $query->andWhere(['and',
                ['<=', 's.price', $propertyRequirement->min_price],
                ['<=', 's.beds', $propertyRequirement->min_beds],
                ['<=', 's.size', $propertyRequirement->min_area],
                ['<=', 's.baths', $propertyRequirement->min_baths],
                ['=', 's.sub_area_location_id', $propertyRequirement->sub_location]
            ]);

        } else {
            $query->andWhere(['or',
                ['<=', 's.price', $propertyRequirement->min_price],
                ['<=', 's.beds', $propertyRequirement->min_beds],
                ['<=', 's.size', $propertyRequirement->min_area],
                ['<=', 's.baths', $propertyRequirement->min_baths],
                ['=', 's.sub_area_location_id', $propertyRequirement->sub_location]
            ]);
        }

        return $query->all();
    }

    //todo add company id everywhere
    public static function getCountByStatus($status)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->from(self::tableName() . ' s')->andWhere(['s.status' => $status])->count();
    }

    //todo add company id everywhere
    public static function getTopLocation($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) AS total', 's.area_location_id', 'loc.name'])
            ->from(self::tableName() . ' s')
            ->leftJoin(Locations::tableName() . ' loc', 'loc.id = s.area_location_id')
            ->groupBy('s.area_location_id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    //todo add company id everywhere
    public static function getTopRegions($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) AS total', 's.region_id', 'loc.name'])
            ->from(self::tableName() . ' s')
            ->leftJoin(Locations::tableName() . ' loc', 'loc.id = s.region_id')
            ->groupBy('s.region_id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    //todo add company id everywhere
    public static function getByPriceInRange($minPrice, $maxPrice)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        $query->from(self::tableName() . ' s');

        if ($maxPrice)
            $query->andWhere(['>=', 'price', $minPrice])->andWhere(['<', 'price', $maxPrice]);
        else
            $query->andWhere(['>=', 'price', $minPrice]);

        return $query->count();
    }

    //todo add company id everywhere
    public static function getTotalWithCategories()
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->from(self::tableName() . ' s')->andWhere(['>', 'category_id', 0])->count();
    }

    //todo add company id everywhere
    public static function getTopAgent($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) as total', 's.user_id', 'u.last_name', 'u.first_name'])
            ->from(self::tableName() . ' s')
            ->leftJoin(User::tableName() . ' u', 'u.id = s.user_id')
            ->groupBy('s.user_id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    //todo add company id everywhere
    public static function getTopCategories($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) as total', 'pC.title', 's.category_id'])
            ->from(self::tableName() . ' s')
            ->leftJoin(PropertyCategory::tableName() . ' pC', 'pC.id = s.category_id')
            ->groupBy('s.category_id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getBySlug($slug)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();
        $query = self::find()->where(['slug' => $slug]);

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->andWhere([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => Yii::$app->user->id]);
                }
            }
        }

        return $query->one();
    }

     /**
     *
     * This method returns the first record of model Leads
     * 
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $id = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$id) {
                empty(self::find()->one()) ? $firstRecord = $this : $firstRecord = self::find()->one();
            } else {
                $firstRecord = self::find()->where([
                    'id'         => $id
                ])->one();
            }
        } else {
            if ((new OwnerManageGroup())->getViewsByGroup()) {
                if (Yii::$app->controller->action->id === 'index') {
                    self::find()->where([
                        'company_id'         => $companyId,
                        'user_id' => (new OwnerManageGroup())->getViewsByGroup()
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'company_id'         => $companyId,
                            'user_id' => (new OwnerManageGroup())->getViewsByGroup()
                        ])->one()
                        : $firstRecord = $this;
                } else {
                    self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'id'         => $id,
                            'company_id' => $companyId
                        ])->one()
                        : $firstRecord = $this;
                }
            } else {
                if (Yii::$app->controller->action->id === 'index') {

                    self::find()->where([
                        'company_id'         => $companyId,
                        'user_id' => Yii::$app->user->id
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'company_id'         => $companyId,
                            'user_id' => Yii::$app->user->id
                        ])->one()
                        : $firstRecord = $this;
                } else {
                    self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one() ?
                        $firstRecord = self::find()->where([
                            'id'         => $id,
                            'company_id' => $companyId
                        ])->one()
                        : $firstRecord = $this;
                }
            }
        }

        return $firstRecord;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAgent()
    {
        return $this->hasOne(User::className(), ['id' => 'agent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getContact()
    {
        return $this->hasOne(Contacts::className(), ['id' => 'landlord_id']);
    }

    public function getPortalListing()
    {
        return $this->hasMany(PortalListing::className(), ['ref' => 'ref']);
    }

    public function getFeatureListing()
    {
        return $this->hasMany(FeatureListing::className(), ['ref' => 'ref'])->with('feature');
    }

    public function getEmirate()
    {
        return $this->hasOne(Locations::className(), ['id' => 'region_id']);
    }

    public function getLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'area_location_id']);
    }

    public function getSubLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'sub_area_location_id']);
    }

    public function getAssignedTo()
    {
        return $this->hasOne(User::className(), ['id' => 'agent_id']);
    }

    public function getOwner()
    {
        return $this->hasOne(Contacts::className(), ['id' => 'landlord_id']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getGallery()
    {
        return $this->hasMany(Gallery::className(), ['ref' => 'ref']);
    }

    public static function find()
    {
        return parent::find()
            ->with('emirate')
            ->with('location')
            ->with('subLocation')
            ->with('category')
            ->with('gallery')
            ->with('agent')
            ->with('portalListing')
            ->with('contact')
            ->with('featureListing');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCategoryRel()
    {
        if ($this->category_id)
            return $this->category->title;
        else return '';
    }

    /**
     * Undocumented function
     *
     * @param $ref
     * @return void
     */
    public static function getByRef($ref)
    {
        return Rentals::find()->where(['ref' => $ref])->with('agent')->with('contact')->with('gallery')->one();
    }

    public static function getRentalsByMonth()
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' || $companyId == 0) {
            $result = self::find()
                ->select(['MONTH(dateadded) AS month', 'COUNT(*) AS countByMonth'])
                ->where('YEAR(dateadded) = YEAR(NOW())')
                ->groupBy(['month'])
                ->all();
        } else {
            $result = self::find()
                ->select(['MONTH(dateadded) AS month', 'COUNT(*) AS countByMonth'])
                ->where(['company_id' => $companyId])
                ->andWhere('YEAR(dateadded) = YEAR(NOW())')
                ->groupBy(['month'])
                ->all();
        }

        return $result;
    }

    public static function getStatuses() : array
    {
        $statuses[self::STATUS_DRAFT]       = Yii::t('app', 'Draft');
        $statuses[self::STATUS_PENDING]     = Yii::t('app', 'Pending');
        $statuses[self::STATUS_PUBLISHED]   = Yii::t('app', 'Published');
        $statuses[self::STATUS_UNPUBLISHED] = Yii::t('app', 'Unpublished');
        return $statuses;
    }

    public static function getPropertyStatuses() : array
    {
        $statuses[self::PROPERTY_STATUS_AVAILABLE] = self::PROPERTY_STATUS_AVAILABLE;
        $statuses[self::PROPERTY_STATUS_OFF_PLAN]  = self::PROPERTY_STATUS_OFF_PLAN;
        $statuses[self::PROPERTY_STATUS_PENDING]   = self::PROPERTY_STATUS_PENDING;
        $statuses[self::PROPERTY_STATUS_RESERVED]  = self::PROPERTY_STATUS_RESERVED;
        $statuses[self::PROPERTY_STATUS_SOLD]      = self::PROPERTY_STATUS_SOLD;
        $statuses[self::PROPERTY_STATUS_UPCOMING]  = self::PROPERTY_STATUS_UPCOMING;
        return $statuses;
    }
}
