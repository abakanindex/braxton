<?php

namespace app\modules\lead\models;

use app\models\Company;
use app\models\Leads;
use app\models\Locations;
use app\models\reference_books\PropertyCategory;
use app\models\User;
use app\modules\admin\Users;
use Yii;
use yii\db\Query;
use app\modules\admin\models\OwnerManageGroup;

/**
 * This is the model class for table "property_requirement".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $category_id
 * @property string $location
 * @property string $sub_location
 * @property int $min_beds
 * @property int $max_beds
 * @property int $min_price
 * @property int $max_price
 * @property int $min_area
 * @property int $max_area
 * @property string $unit_type
 * @property string $unit
 * @property int $company_id
 * @property string $ref
 * @property string $size
 * @property string $min_baths
 * @property string $max_baths
 * @property string $street_no
 * @property string $floor_no
 * @property string $dewa_no
 * @property string $photos
 * @property string $cheques
 * @property string $fitted
 * @property string $prop_status
 * @property string $source_of_listing
 * @property string $available_date
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
 * @property string $description
 * @property string $language
 * @property string $portals
 * @property string $features
 * @property string $neighbourhood_info
 * @property string $emirate
 *
 * @property Leads $lead
 */
class PropertyRequirement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_requirement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'lead_id'], 'required'],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
            [['lead_id', 'category_id', 'min_beds', 'max_beds', 'min_price', 'max_price', 'min_area', 'max_area', 'company_id'], 'integer'],
            [['location', 'sub_location', 'unit_type', 'unit', 'ref', 'size', 'min_baths', 'max_baths', 'street_no', 'floor_no', 'dewa_no', 'photos', 'cheques', 'fitted', 'prop_status', 'source_of_listing', 'available_date', 'furnished', 'featured', 'maintenance', 'strno', 'amount', 'tenanted', 'plot_size', 'name', 'view_id', 'commission', 'deposit', 'unit_size_price', 'dateadded', 'dateupdated', 'user_id', 'key_location', 'international', 'rand_key', 'development_unit_id', 'rera_permit', 'tenure', 'completion_status', 'DT_RowClass', 'DT_RowId', 'owner_mobile', 'owner_email', 'secondary_ref', 'terminal', 'other_title_2', 'invite', 'poa', 'description', 'language', 'portals', 'features', 'neighbourhood_info', 'emirate'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lead_id' => Yii::t('app', 'Lead'),
            'category_id' => Yii::t('app', 'Category'),
            'location' => Yii::t('app', 'Location'),
            'sub_location' => Yii::t('app', 'Sub Location'),
            'min_beds' => Yii::t('app', 'Min Beds'),
            'max_beds' => Yii::t('app', 'Max Beds'),
            'min_price' => Yii::t('app', 'Min price'),
            'max_price' => Yii::t('app', 'Max price'),
            'min_area' => Yii::t('app', 'Min Area'),
            'max_area' => Yii::t('app', 'Max Area'),
            'unit_type' => Yii::t('app', 'Unit Type'),
            'unit' => Yii::t('app', 'Unit'),

            'ref' => Yii::t('app', 'Reference'),
            'size' => Yii::t('app', 'Size'),
            'min_baths' => Yii::t('app', 'Min baths'),
            'max_baths' => Yii::t('app', 'Max baths'),
            'street_no' => Yii::t('app', 'Street No'),
            'floor_no' => Yii::t('app', 'Floor No'),
            'dewa_no' => Yii::t('app', 'Dewa No'),
            'photos' => Yii::t('app', 'Photos'),
            'cheques' => Yii::t('app', 'Cheques'),
            'fitted' => Yii::t('app', 'Fitted'),
            'prop_status' => Yii::t('app', 'Prop Status'),
            'source_of_listing' => Yii::t('app', 'Source of Listing'),
            'available_date' => Yii::t('app', 'Available Date'),
            'furnished' => Yii::t('app', 'Furnished'),
            'featured' => Yii::t('app', 'Featured'),
            'maintenance' => Yii::t('app', 'Maintance'),
            'strno' => Yii::t('app', 'strno'),
            'amount' => Yii::t('app', 'Amount'),
            'tenanted' => Yii::t('app', 'Tenanted'),
            'plot_size' => Yii::t('app', 'Plot Size'),
            'name' => Yii::t('app', 'Name'),
            'view_id' => Yii::t('app', 'View Id'),
            'commission' => Yii::t('app', 'Commission'),
            'deposit' => Yii::t('app', 'Deposit'),
            'unit_size_price' => Yii::t('app', 'Unit Size Price'),
            'dateadded' => Yii::t('app', 'Dateadded'),
            'dateupdated' => Yii::t('app', 'Dateupdated'),
            'user_id' => Yii::t('app', 'User Id'),
            'key_location' => Yii::t('app', 'Key Location'),
            'international' => Yii::t('app', 'International'),
            'rand_key' => Yii::t('app', 'Rand Key'),
            'development_unit_id' => Yii::t('app', ''),
            'rera_permit' => Yii::t('app', 'Development Unit Id'),
            'tenure' => Yii::t('app', 'Tenure'),
            'completion_status' => Yii::t('app', 'Completion Status'),
            'DT_RowClass' => Yii::t('app', 'DT RowClass'),
            'DT_RowId' => Yii::t('app', 'DT RowId'),
            'owner_mobile' => Yii::t('app', 'Owner Mobile'),
            'owner_email' => Yii::t('app', 'Owner Email'),
            'secondary_ref' => Yii::t('app', 'Secondary Ref'),
            'terminal' => Yii::t('app', 'Termonal'),
            'other_title_2' => Yii::t('app', 'Other Title 2'),
            'invite' => Yii::t('app', 'Invite'),
            'poa' => Yii::t('app', 'Poa'),
            'description' => Yii::t('app', 'Description'),
            'language' => Yii::t('app', 'Language'),
            'portals' => Yii::t('app', 'Portals'),
            'features' => Yii::t('app', 'Features'),
            'neighbourhood_info' => Yii::t('app', 'Neighbourhood Info'),
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id']);
    }

    public function getSalesAttributes()
    {
        $attributes = $this->attributes;
        $salesAttributes = [];
        foreach ($attributes as $k=>$v)
            $salesAttributes["SaleSearch[$k]"] = $v;
        return $salesAttributes;
    }

    public function getRentalsAttributes()
    {
        $attributes = $this->attributes;
        $salesAttributes = [];
        foreach ($attributes as $k=>$v)
            $salesAttributes["RentalsSearch[$k]"] = $v;
        return $salesAttributes;
    }

    public static function getMatchLeads($beds, $baths, $category, $emirate, $location, $subLocation, $size, $price, $myLeads)
    {
        $query = new Query();
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query->andWhere([
                    'l.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {
                    $query->andWhere([
                        'l.company_id' => $companyId
                    ]);

                } else {
                    $query->andWhere([
                        'l.company_id' => $companyId
                    ]);
                }
            }
        }

        if ($myLeads)
            $query->innerJoin(LeadAgent::tableName() . ' lA', 'lA.user_id = ' . Yii::$app->user->id);
        else {
            $query->leftJoin(LeadAgent::tableName() . ' lA', 'lA.lead_id = pr.lead_id');
        }

        return $query
            ->select([
                'pr.lead_id',
                'pr.min_beds',
                'pr.max_beds',
                'pr.min_baths',
                'pr.max_baths',
                'pr.min_area',
                'pr.max_area',
                'pr.min_price',
                'pr.max_price',
                'pr.category_id',
                'l.reference',
                'l.company_id',
                'l.created_by_user_id',
                'l.last_name',
                'l.first_name',
                'l.mobile_number',
                'cat.title as category_title',
                'emirate.name as emirate',
                'location.name as location',
                'subLocation.name as subLocation',
                'u.username as agentName'
            ])
            ->from(PropertyRequirement::tableName() . ' pr')
            ->andWhere(['and',
                ['=', 'pr.emirate', $emirate],
                ['=', 'pr.location', $location],
                ['=', 'pr.category_id', $category]
            ])
            ->andWhere(['or',
                ['>=', 'pr.min_price', $price],
                ['>=', 'pr.min_beds', $beds],
                ['>=', 'pr.min_area', $size],
                ['>=', 'pr.min_baths', $baths],
                ['=',  'pr.sub_location', $subLocation]
            ])
            ->innerJoin(Leads::tableName() . ' l', 'l.id = pr.lead_id')
            ->leftJoin(PropertyCategory::tableName() . ' cat', 'cat.id = pr.category_id')
            ->leftJoin(Locations::tableName() . ' emirate', 'emirate.id = pr.emirate')
            ->leftJoin(Locations::tableName() . ' location', 'location.id = pr.location')
            ->leftJoin(Locations::tableName() . ' subLocation', 'subLocation.id = pr.sub_location')
            ->leftJoin(User::tableName() . ' u', 'u.id = lA.user_id')
            ->all();
    }

    public static function getForLead($leadId)
    {
        return self::find()->where(['lead_id' => $leadId])->all();
    }

    public function getEmirateRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'emirate']);
    }

    public function getLocationRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'location']);
    }

    public function getSubLocationRecord()
    {
        return $this->hasOne(Locations::className(), ['id' => 'sub_location']);
    }

    public static function find()
    {
        return parent::find()
            ->with('emirateRecord')
            ->with('locationRecord')
            ->with('category')
            ->with('lead')
            ->with('subLocationRecord');
    }
}
