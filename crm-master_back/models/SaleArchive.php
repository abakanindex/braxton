<?php

namespace app\models;

use Yii;
use app\models\reference_books\PropertyCategory;
use app\interfaces\relationShip\iRelationShip;
use app\interfaces\firstrecordmodel\IfirstRecordModel;
use app\models\Company;
use yii\db\Query;
use app\modules\admin\models\OwnerManageGroup;

/**
 * This is the model class for table "sale_archive".
 *
 * @property int $id
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
 * @property string $tenure
 * @property string $completion_status
 * @property string $DT_RowClass
 * @property string $DT_RowId
 * @property string $owner_mobile
 * @property string $owner_email
 * @property string $secondary_ref
 * @property string $terminal
 * @property string $other_title_2
 * @property string $invite
 * @property string $poa
 * @property string $rented_at
 * @property string $rented_until
 * @property string $description
 * @property string $language
 * @property string $slug
 * @property string $portals
 * @property string $features
 * @property string $neighbourhood_info
 * @property int $company_id
 * @property double $latitude
 * @property double $longitude
 */
class SaleArchive extends \yii\db\ActiveRecord implements iRelationShip, IfirstRecordModel
{
    public $CommissionPercent;
    public $DepositPercent;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_archive';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['is_parsed'], 'boolean'],
            [['latitude', 'longitude'], 'number'],
            [['status', 'managed', 'exclusive', 'shared', 'ref', 'unit', 'category_id', 'region_id', 'area_location_id', 'sub_area_location_id', 'beds', 'size', 'price', 'agent_id', 'landlord_id', 'unit_type', 'baths', 'street_no', 'floor_no', 'dewa_no', 'photos', 'cheques', 'fitted', 'prop_status', 'source_of_listing', 'available_date', 'remind_me', 'furnished', 'featured', 'maintenance', 'strno', 'amount', 'tenanted', 'plot_size', 'name', 'view_id', 'commission', 'deposit', 'unit_size_price', 'dateadded', 'dateupdated', 'user_id', 'key_location', 'international', 'rand_key', 'development_unit_id', 'type', 'rera_permit', 'tenure', 'completion_status', 'DT_RowClass', 'DT_RowId', 'owner_mobile', 'owner_email', 'secondary_ref', 'terminal', 'other_title_2', 'invite', 'poa', 'rented_at', 'rented_until', 'description', 'language', 'slug', 'portals', 'features', 'neighbourhood_info'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'managed' => 'Managed',
            'exclusive' => 'Exclusive',
            'shared' => 'Shared',
            'ref' => 'Ref',
            'unit' => 'Unit',
            'category_id' => 'Category ID',
            'region_id' => 'Region ID',
            'area_location_id' => 'Area Location ID',
            'sub_area_location_id' => 'Sub Area Location ID',
            'beds' => 'Beds',
            'size' => 'Size',
            'price' => 'Price',
            'agent_id' => 'Agent ID',
            'landlord_id' => 'Landlord ID',
            'unit_type' => 'Unit Type',
            'baths' => 'Baths',
            'street_no' => 'Street No',
            'floor_no' => 'Floor No',
            'dewa_no' => 'Dewa No',
            'photos' => 'Photos',
            'cheques' => 'Cheques',
            'fitted' => 'Fitted',
            'prop_status' => 'Prop Status',
            'source_of_listing' => 'Source Of Listing',
            'available_date' => 'Available Date',
            'remind_me' => 'Remind Me',
            'furnished' => 'Furnished',
            'featured' => 'Featured',
            'maintenance' => 'Maintenance',
            'strno' => 'Strno',
            'amount' => 'Amount',
            'tenanted' => 'Tenanted',
            'plot_size' => 'Plot Size',
            'name' => 'Name',
            'view_id' => 'View ID',
            'commission' => 'Commission',
            'deposit' => 'Deposit',
            'unit_size_price' => 'Unit Size Price',
            'dateadded' => 'Dateadded',
            'dateupdated' => 'Dateupdated',
            'user_id' => 'User ID',
            'key_location' => 'Key Location',
            'international' => 'International',
            'rand_key' => 'Rand Key',
            'development_unit_id' => 'Development Unit ID',
            'type' => 'Type',
            'rera_permit' => 'Rera Permit',
            'tenure' => 'Tenure',
            'completion_status' => 'Completion Status',
            'DT_RowClass' => 'Dt  Row Class',
            'DT_RowId' => 'Dt  Row ID',
            'owner_mobile' => 'Owner Mobile',
            'owner_email' => 'Owner Email',
            'secondary_ref' => 'Secondary Ref',
            'terminal' => 'Terminal',
            'other_title_2' => 'Other Title 2',
            'invite' => 'Invite',
            'poa' => 'Poa',
            'rented_at' => 'Rented At',
            'rented_until' => 'Rented Until',
            'description' => 'Description',
            'language' => 'Language',
            'slug' => 'Slug',
            'portals' => 'Portals',
            'features' => 'Features',
            'neighbourhood_info' => 'Neighbourhood Info',
            'company_id' => 'Company ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    public static function getColumns($dataProvider)
    {
        return [
            'beds' => 'beds',
            'size' => 'size',
            'price' => 'price',
            'agent_id' => [
                'attribute' => 'assignedTo',
                'value' => function($dataProvider) {
                        if (is_numeric($dataProvider->agent_id)) {
                            return $dataProvider->assignedTo->username;
                        } else {
                            return $dataProvider->agent_id;
                        }
                    }
            ],
            'landlord_id' => [
                'attribute' => 'owner',
                'value' => function($dataProvider) {
                        if (is_numeric($dataProvider->landlord_id)) {
                            return $dataProvider->owner->last_name . " " . $dataProvider->owner->first_name;
                        } else {
                            return $dataProvider->landlord_id;
                        }
                    }
            ],
            'unit_type' => 'unit_type',
            'baths' => 'baths',
            'street_no' => 'street_no',
            'floor_no' => 'floor_no',
            'dewa_no' => 'dewa_no',
            'photos' => 'photos',
            'cheques' => 'cheques',
            'fitted' => 'fitted',
            'prop_status' => 'prop_status',
            'source_of_listing' => 'source_of_listing',
            'available_date' => 'available_date',
            'remind_me' => 'remind_me',
            'furnished' => 'furnished',
            'featured' => 'featured',
            'maintenance' => 'maintenance',
            'strno' => 'strno',
            'amount' => 'amount',
            'tenanted' => 'tenanted',
            'plot_size' => 'plot_size',
            'name' => 'name',
            'view_id' => 'view_id',
            'commission' => 'commission',
            'deposit' => 'deposit',
            'unit_size_price' => 'unit_size_price',
            'dateadded' => 'dateadded',
            'dateupdated' => 'dateupdated',
            'user_id' => 'user_id',
            'key_location' => 'key_location',
            'international' => 'international',
            'development_unit_id' => 'development_unit_id',
            'type' => 'type',
            'rera_permit' => 'rera_permit',
            'tenure' => 'tenure',
            'completion_status' => 'completion_status',
            'owner_mobile' => 'owner_mobile',
            'owner_email' => 'owner_email:email'
        ];
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

    /**
     *
     * This method returns the first record of model Rentals
     *
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $id = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (Yii::$app->controller->action->id === 'index') {
                empty(self::find()->one()) ? $firstRecord = $this : $firstRecord = self::find()->one();
            } else {
                $firstRecord = self::findOne($id);
            }
        } else {
            if (Yii::$app->controller->action->id === 'index') {
                self::find()->where([
                    'company_id' => $companyId
                ])->one() ?
                    $firstRecord = self::find()->where([
                        'company_id' => $companyId
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
     * Undocumented function
     *
     * @return void
     */
    public function getContact()
    {
        return $this->hasOne(Contacts::className(), ['id' => 'landlord_id']);
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
            ->with('agent');
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
