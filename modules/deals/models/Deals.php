<?php

namespace app\modules\deals\models;

use yii\db\ActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;
use app\interfaces\firstrecordmodel\{IfirstRecordModel, IfirstInternationalRecordModel};
use app\interfaces\deals\{iDeals, iDealsInt};
use yii\behaviors\SluggableBehavior;
use app\models\statusHistory\ArchiveHistory;
use app\models\Company;
use app\models\Leads;
use app\models\Sale;
use app\models\Rentals;
use app\models\Locations;
use app\models\User;
use app\models\reference_books\PropertyCategory;
use app\models\reference_books\ContactSource;
use app\modules\admin\models\OwnerManageGroup;
use yii\db\Query;

/**
 * This is the model class for table "deals".
 *
 * @property int $id
 * @property string $ref
 * @property int $type
 * @property int $model_id
 * @property int $created_at
 * @property int $lead_id
 * @property int $seller_id
 * @property int $buyer_id
 * @property int $company_id
 * @property int $status
 * @property int $sub_status
 * @property string $source
 * @property int $deal_price
 * @property int $deposit
 * @property int $gross_commission
 * @property int $is_vat
 * @property int $is_external_referral
 * @property string $external_referral_name
 * @property int $external_referral_type
 * @property int $external_referral_commission
 * @property int $your_company_commission
 * @property int $agent_1
 * @property int $agent_1_commission
 * @property int $agent_2
 * @property int $agent_2_commission
 * @property int $agent_3
 * @property int $agent_3_commission
 * @property int $cheques
 * @property int $estimated_date
 * @property int $actual_date
 * @property int $created_by
 * @property int $is_international
 */
class Deals extends ActiveRecord implements iDeals, iDealsInt, IfirstRecordModel, IfirstInternationalRecordModel
{
    const TYPE_RENTAL = 1;
    const TYPE_SALES = 2;
    const TYPE_NOT_SPECIFIED = 3;

    const STATUS_DRAFT = 1;
    const STATUS_PENDING = 2;
    const STATUS_CLOSED = 3;

    const SUB_STATUS_SUCCESSFUL = 1;
    const SUB_STATUS_UNSUCCESSFUL = 2;
    const SUB_STATUS_NOT_SPECIFIED = 3;

    const INTERNATIONAL = 1;
    const NOT_INTERNATIONAL = 0;

    public $slug;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deals';
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
                'class'     => SluggableBehavior::class,
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
            [['model_id', 'lead_id'], 'required'],
            [
                [
                    'id',
                    'ref',
                    'type',
                    'created_at',
                    'seller_id',
                    'buyer_id',
                    'company_id',
                    'status',
                    'sub_status',
                    'source',
                    'deal_price',
                    'deposit',
                    'gross_commission',
                    'is_vat',
                    'is_external_referral',
                    'external_referral_name',
                    '$external_referral_type',
                    'external_referral_commission',
                    'your_company_commission',
                    'agent_1',
                    'agent_1_commission',
                    'agent_2',
                    'agent_2_commission',
                    'agent_3',
                    'agent_3_commission',
                    'cheques',
                    'estimated_date',
                    'actual_date',
                    'created_by',
                    'is_international',
                    'model_id',
                    'lead_id',
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
            'ref'                  => Yii::t('app', 'Reference'),
            'actual_date'          => Yii::t('app', 'Deal Date'),
            'estimated_date'       => Yii::t('app', 'Estimated Deal Date'),
            'agent_1_commission'   => Yii::t('app', 'Agent 1 Commission'),
            'agent_2_commission'   => Yii::t('app', 'Agent 2 Commission'),
            'agent_3_commission'   => Yii::t('app', 'Agent 3 Commission'),
            'deal_price'           => Yii::t('app', 'Deal Price'),
            'deposit'              => Yii::t('app', 'Deposit'),
            'gross_commission'     => Yii::t('app', 'Gross Commission'),
        ];
    }

    /**
     *
     * This method returns the first record of model Deals
     *
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $id = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$id) {
                $checkRecord = self::find()->where(['is_international' => 0])->one();
                empty($checkRecord) ? $firstRecord = $this : $firstRecord = $checkRecord;
            } else {
                $firstRecord = self::find()->where([
                    'id'         => $id
                ])->one();
            }
        } else {
            $viewsByGroup = (new OwnerManageGroup())->getViewsByGroup();
            if ($viewsByGroup) {
                if (Yii::$app->controller->action->id === 'index') {
                    $checkRecord = self::find()->where([
                        'company_id'       => $companyId,
                        'created_by'       => $viewsByGroup,
                        'is_international' => 0
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                } else {
                    $checkRecord = self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                }
            } else {
                if (Yii::$app->controller->action->id === 'index') {
                    $checkRecord = self::find()->where([
                        'company_id' => $companyId,
                        'created_by'    => Yii::$app->user->id,
                        'is_international' => 0
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                } else {
                    $checkRecord = self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                }
            }
        }
        return $firstRecord;
    }

    /**
     * @return array
     */
    public static function getTypes() : array
    {
        $types[self::TYPE_RENTAL]        = Yii::t('app', 'Rental');
        $types[self::TYPE_SALES]         = Yii::t('app', 'Sales');
//        $types[self::TYPE_NOT_SPECIFIED] = Yii::t('app', 'Not Specified');
        return $types;
    }

    /**
     * @return array
     */
    public static function getStatuses() : array
    {
        $statuses[self::STATUS_DRAFT]   = Yii::t('app', 'Draft');
        $statuses[self::STATUS_PENDING] = Yii::t('app', 'Pending');
        $statuses[self::STATUS_CLOSED]  = Yii::t('app', 'Closed');
        return $statuses;
    }

    /**
     * @return array
     */
    public static function getSubStatuses() : array
    {
        $subStatuses[self::SUB_STATUS_SUCCESSFUL]    = Yii::t('app', 'Successful');
        $subStatuses[self::SUB_STATUS_UNSUCCESSFUL]  = Yii::t('app', 'Unsuccessful');
        $subStatuses[self::SUB_STATUS_NOT_SPECIFIED] = Yii::t('app', 'Not Specified');
        return $subStatuses;
    }

    /**
     * @return Rentals or Sale.
     * @throws \Exception When $unitModel is null.
     */
    public function getUnitModel()
    {
        $unitModel = null;

        if ($this->type == self::TYPE_RENTAL) {
            $unitModel = Rentals::findOne($this->model_id);
        } elseif ($this->type == self::TYPE_SALES) {
            $unitModel = Sale::findOne($this->model_id);
        } else {
            $unitModel = new Sale();
        }

        return $unitModel;
    }

    public function getLeadModel()
    {
        if ($this->lead_id && $lead = Leads::findOne($this->lead_id)) {
            return $lead;
        }

        return new Leads();
    }

    /**
     * @param $dataProvider
     * @return array
     */
    public static function getColumns($dataProvider)
    {
        return [
            'agent_1_commission' => 'agent_1_commission',
            'agent_2' => [
                'label' => Yii::t('app', 'Agent 2'),
                'attribute' => 'agent_2',
                'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->agent_2)) {
                        return $dataProvider->agent2->username;
                    } else {
                        return $dataProvider->agent_2;
                    }
                }
            ],
            'agent_2_commission' => 'agent_2_commission',
            'agent_3' => [
                'label' => Yii::t('app', 'Agent 3'),
                'attribute' => 'agent_3',
                'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->agent_3)) {
                        return $dataProvider->agent3->username;
                    } else {
                        return $dataProvider->agent_3;
                    }
                }
            ],
            'agent_3_commission' => 'agent_3_commission',
            'actual_date' => [
                'attribute' => 'actual_date',
                'value' => function($dataProvider) {
                    return $dataProvider->getActualDateByPattern('d-m-Y');
                },
            ],
            'estimated_date' => [
                'attribute' => 'actual_date',
                'value' => function($dataProvider) {
                    return $dataProvider->getEstimatedDateByPattern('d-m-Y');
                },
            ],
        ];
    }

    public static function getTopCategories($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) as total', 'pC.title', 'pC.id'])
            ->from(self::tableName() . ' d')
            ->leftJoin(Sale::tableName() . ' s', 'd.model_id = s.id')
            ->leftJoin(Rentals::tableName() . ' r', 'd.model_id = r.id')
            ->leftJoin(PropertyCategory::tableName() . ' pC', '(pC.id = s.category_id) OR (pC.id = r.category_id)')
            ->andWhere(['d.is_international' => 0])
            ->groupBy('pC.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getTopLocation($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) AS total', 'loc.id', 'loc.name'])
            ->from(self::tableName() . ' d')
            ->leftJoin(Sale::tableName() . ' s', 'd.model_id = s.id')
            ->leftJoin(Rentals::tableName() . ' r', 'd.model_id = r.id')
            ->leftJoin(Locations::tableName() . ' loc', '(loc.id = s.area_location_id) OR (loc.id = r.area_location_id)')
            ->andWhere(['d.is_international' => 0])
            ->groupBy('loc.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getTopRegions($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) AS total', 'loc.id', 'loc.name'])
            ->from(self::tableName() . ' d')
            ->leftJoin(Sale::tableName() . ' s', 'd.model_id = s.id')
            ->leftJoin(Rentals::tableName() . ' r', 'd.model_id = r.id')
            ->leftJoin(Locations::tableName() . ' loc', '(loc.id = s.region_id) OR (loc.id = r.region_id)')
            ->andWhere(['d.is_international' => 0])
            ->groupBy('loc.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getTopAgent($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) as total', 'd.created_by', 'u.last_name', 'u.first_name'])
            ->from(self::tableName() . ' d')
            ->leftJoin(User::tableName() . ' u', 'u.id = d.created_by')
            ->andWhere(['d.is_international' => 0])
            ->groupBy('d.created_by')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getByPriceInRange($minPrice, $maxPrice)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        $query->from(self::tableName() . ' d')
            ->andWhere(['d.is_international' => 0]);

        if ($maxPrice)
            $query->andWhere(['>=', 'deal_price', $minPrice])->andWhere(['<', 'deal_price', $maxPrice]);
        else
            $query->andWhere(['>=', 'deal_price', $minPrice]);

        return $query->count();
    }

    public static function getCountByStatus()
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->from(self::tableName() . ' d')
            ->andWhere(['d.is_international' => 0])
            ->count();
    }

    public static function find()
    {
        return parent::find()
            ->with('buyer')
            ->with('seller')
            ->with('agent1');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(User::class, ['id' => 'buyer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(User::class, ['id' => 'seller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent1()
    {
        return $this->hasOne(User::class, ['id' => 'agent_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent2()
    {
        return $this->hasOne(User::class, ['id' => 'agent_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent3()
    {
        return $this->hasOne(User::class, ['id' => 'agent_3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSourceModel()
    {
        return $this->hasOne(ContactSource::class, ['id' => 'source']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::class, ['id' => 'lead_id']);
    }

    /**
     *
     * This method returns the first record of model Deals for international deals
     *
     * @param  string $id
     * @return iterable
     */
    public function getFirstIntRecordModel(?string $id = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$id) {
                $checkRecord = self::find()->where(['is_international' => 1])->one();
                empty($checkRecord) ? $firstRecord = $this : $firstRecord = $checkRecord;
            } else {
                $firstRecord = self::find()->where([
                    'id'         => $id
                ])->one();
            }
        } else {
            $viewsByGroup = (new OwnerManageGroup())->getViewsByGroup();
            if ($viewsByGroup) {
                if (Yii::$app->controller->action->id === 'index') {
                    $checkRecord = self::find()->where([
                        'company_id'       => $companyId,
                        'created_by'       => $viewsByGroup,
                        'is_international' => 1
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                } else {
                    $checkRecord = self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                }
            } else {
                if (Yii::$app->controller->action->id === 'index') {
                    $checkRecord = self::find()->where([
                        'company_id' => $companyId,
                        'created_by'    => Yii::$app->user->id,
                        'is_international' => 1
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                } else {
                    $checkRecord = self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                }
            }
        }

        return $firstRecord;
    }

    public static function getTopCategoriesInt($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) as total', 'pC.title', 'pC.id'])
            ->from(self::tableName() . ' d')
            ->leftJoin(Sale::tableName() . ' s', 'd.model_id = s.id')
            ->leftJoin(Rentals::tableName() . ' r', 'd.model_id = r.id')
            ->leftJoin(PropertyCategory::tableName() . ' pC', '(pC.id = s.category_id) OR (pC.id = r.category_id)')
            ->andWhere(['d.is_international' => 1])
            ->groupBy('pC.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getTopLocationInt($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) AS total', 'loc.id', 'loc.name'])
            ->from(self::tableName() . ' d')
            ->leftJoin(Sale::tableName() . ' s', 'd.model_id = s.id')
            ->leftJoin(Rentals::tableName() . ' r', 'd.model_id = r.id')
            ->leftJoin(Locations::tableName() . ' loc', '(loc.id = s.area_location_id) OR (loc.id = r.area_location_id)')
            ->andWhere(['d.is_international' => 1])
            ->groupBy('loc.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getTopRegionsInt($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) AS total', 'loc.id', 'loc.name'])
            ->from(self::tableName() . ' d')
            ->leftJoin(Sale::tableName() . ' s', 'd.model_id = s.id')
            ->leftJoin(Rentals::tableName() . ' r', 'd.model_id = r.id')
            ->leftJoin(Locations::tableName() . ' loc', '(loc.id = s.region_id) OR (loc.id = r.region_id)')
            ->andWhere(['d.is_international' => 1])
            ->groupBy('loc.id')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getTopAgentInt($limit)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->select(['COUNT(*) as total', 'd.created_by', 'u.last_name', 'u.first_name'])
            ->from(self::tableName() . ' d')
            ->leftJoin(User::tableName() . ' u', 'u.id = d.created_by')
            ->andWhere(['d.is_international' => 1])
            ->groupBy('d.created_by')
            ->orderBy(['total' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getByPriceInRangeInt($minPrice, $maxPrice)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        $query->from(self::tableName() . ' d')
            ->andWhere(['d.is_international' => 1]);

        if ($maxPrice)
            $query->andWhere(['>=', 'deal_price', $minPrice])->andWhere(['<', 'deal_price', $maxPrice]);
        else
            $query->andWhere(['>=', 'deal_price', $minPrice]);

        return $query->count();
    }

    public static function getCountByStatusInt()
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->where([
                    'd.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query->where([
                        'd.company_id' => $companyId
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        return $query->from(self::tableName() . ' d')
            ->andWhere(['d.is_international' => 1])
            ->count();
    }

    /**
     * @param string $pattern
     * @return string
     */
    public function getActualDateByPattern(string $pattern) : string
    {
        if ($this->actual_date) {
            return date($pattern, $this->actual_date);
        }
    }

    /**
     * @param string $pattern
     * @return string
     */
    public function getEstimatedDateByPattern(string $pattern) : string
    {
        if ($this->actual_date) {
            return date($pattern, $this->estimated_date);
        }
    }
}
