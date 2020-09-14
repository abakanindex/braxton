<?php

namespace app\models;

use Yii;
use app\models\reference_books\PropertyCategory;
use app\modules\lead\models\PropertyRequirement;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\OwnerManageGroup;


/**
 * SaleSearch represents the model behind the search form of `app\models\Sale`.
 */
class SaleSearch extends Sale
{
    public $category;
    public $location;
    public $sub_location;
    public $min_beds;
    public $max_beds;
    public $min_price;
    public $max_price;
    public $min_area;
    public $max_area;
    public $min_baths;
    public $max_baths;
    public $all_requirements;
    public $propertyRequirementLeadId;
    public $requirement;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['status', 'managed', 'exclusive', 'shared', 'ref', 'unit', 'category_id', 'region_id', 'area_location_id', 'sub_area_location_id', 'beds', 'size', 'price', 'agent_id', 'landlord_id', 'unit_type', 'baths', 'street_no', 'floor_no', 'dewa_no', 'photos', 'cheques', 'fitted', 'prop_status', 'source_of_listing', 'available_date', 'remind_me', 'furnished', 'featured', 'maintenance', 'strno', 'amount', 'tenanted', 'plot_size', 'name', 'view_id', 'commission', 'deposit', 'unit_size_price', 'dateadded', 'dateupdated', 'user_id', 'key_location', 'international', 'rand_key', 'development_unit_id', 'type', 'rera_permit', 'tenure', 'completion_status', 'DT_RowClass', 'DT_RowId', 'owner_mobile', 'owner_email', 'secondary_ref', 'terminal', 'other_title_2', 'slug'], 'safe'],
            [['location', 'sub_location', 'category', 'requirement', 'propertyRequirementLeadId', 'all_requirements', 'price', 'min_beds', 'max_beds', 'min_price', 'max_price', 'min_area', 'max_area'], 'safe'],
            [['min_baths', 'max_baths'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    private function getCompanyQuery()
    {
        $companyId = Company::getCompanyIdBySubdomain(); 
        if ($companyId == 'main' or $companyId == 0) {
            $query = Sale::find();
        } else {   
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = Sale::find()->where([
                    's.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = Sale::find()->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = Sale::find()->where([
                        's.company_id' => $companyId
                    ])->andWhere(['s.user_id' => Yii::$app->user->id]);
                }
            }
        }

        $query->alias('s');
        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $status = false)
    {
        $this->load($params);

        $query = $this->getCompanyQuery();
        $query->joinWith('assignedTo ua');
        $query->joinWith('owner uo');
        $query = $this->getCommonFieldsQuery($query, $status);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ]
        ]);


        return $dataProvider;
    }

    private function getCommonFieldsQuery($query, $status = false)
    {
        $query->andFilterWhere(['=', 's.category_id', $this->category_id])
            ->andFilterWhere(['=', 's.beds', $this->beds])
            ->andFilterWhere(['=', 's.price', $this->price])
            //   ->andFilterWhere(['=', 's.area', $this->area])
            ->andFilterWhere(['=', 's.baths', $this->baths])
            ->andFilterWhere(['=', 's.status', ($status) ? $status : $this->status])
            ->andFilterWhere(['=', 's.area_location_id', $this->location])
            ->andFilterWhere(['=', 's.sub_area_location_id', $this->sub_location])
            ->andFilterWhere(['=', 's.managed', $this->managed])
            ->andFilterWhere(['=', 's.exclusive', $this->exclusive])
            ->andFilterWhere(['=', 's.shared', $this->shared])
            ->andFilterWhere(['like', 's.ref', $this->ref])
            ->andFilterWhere(['=', 's.unit', $this->unit])
            ->andFilterWhere(['=', 's.region_id', $this->region_id])
            ->andFilterWhere(['=', 's.area_location_id', $this->area_location_id])
            ->andFilterWhere(['=', 's.sub_area_location_id', $this->sub_area_location_id])
            ->andFilterWhere(['=', 's.size', $this->size])
            ->andFilterWhere(['like', 'ua.username', $this->agent_id])
            ->andFilterWhere(['like', 'CONCAT(uo.last_name, " ", uo.first_name)', $this->landlord_id])
            ->andFilterWhere(['like', 's.unit_type', $this->unit_type])
            ->andFilterWhere(['like', 's.street_no', $this->street_no])
            ->andFilterWhere(['=', 's.floor_no', $this->floor_no])
            ->andFilterWhere(['=', 's.dewa_no', $this->dewa_no])
            ->andFilterWhere(['=', 's.photos', $this->photos])
            ->andFilterWhere(['=', 's.cheques', $this->cheques])
            ->andFilterWhere(['like', 's.fitted', $this->fitted])
            ->andFilterWhere(['=', 's.prop_status', $this->prop_status])
            ->andFilterWhere(['like', 's.source_of_listing', $this->source_of_listing])
            ->andFilterWhere(['like', 's.available_date', $this->available_date])
            ->andFilterWhere(['like', 's.remind_me', $this->remind_me])
            ->andFilterWhere(['=', 's.furnished', $this->furnished])
            ->andFilterWhere(['=', 's.featured', $this->featured])
            ->andFilterWhere(['like', 's.maintenance', $this->maintenance])
            ->andFilterWhere(['like', 's.strno', $this->strno])
            ->andFilterWhere(['=', 's.amount', $this->amount])
            ->andFilterWhere(['=', 's.tenanted', $this->tenanted])
            ->andFilterWhere(['=', 's.plot_size', $this->plot_size])
            ->andFilterWhere(['like', 's.name', $this->name])
            ->andFilterWhere(['like', 's.view_id', $this->view_id])
            ->andFilterWhere(['=', 's.commission', $this->commission])
            ->andFilterWhere(['=', 's.deposit', $this->deposit])
            ->andFilterWhere(['like', 's.unit_size_price', $this->unit_size_price])
            ->andFilterWhere(['=', 's.dateadded', $this->dateadded])
            ->andFilterWhere(['=', 's.dateupdated', $this->dateupdated])
//            ->andFilterWhere(['=', 's.user_id', $this->user_id])
            ->andFilterWhere(['like', 's.key_location', $this->key_location])
            ->andFilterWhere(['=', 's.international', $this->international])
            ->andFilterWhere(['=', 's.rand_key', $this->rand_key])
//            ->andFilterWhere(['=', 's.development_unit_id', $this->development_unit_id])
            ->andFilterWhere(['=', 's.type', $this->type])
            ->andFilterWhere(['like', 's.rera_permit', $this->rera_permit])
            ->andFilterWhere(['=', 's.tenure', $this->tenure])
            ->andFilterWhere(['=', 's.completion_status', $this->completion_status])
            ->andFilterWhere(['=', 's.DT_RowClass', $this->DT_RowClass])
            ->andFilterWhere(['=', 's.DT_RowId', $this->DT_RowId])
            ->andFilterWhere(['like', 's.owner_mobile', $this->owner_mobile])
            ->andFilterWhere(['like', 's.owner_email', $this->owner_email])
            ->andFilterWhere(['=', 's.secondary_ref', $this->secondary_ref])
            ->andFilterWhere(['=', 's.terminal', $this->terminal])
            ->andFilterWhere(['like', 's.other_title_2', $this->other_title_2])
            ->andFilterWhere(['like', 's.slug', $this->slug]);
        return $query;
    }

    private function filterRequirementQuery($query)
    {
        $query->andFilterWhere(['s.category_id' => $this->category_id]);
        $query = $this->filterMinMaxAttribute($query, 'beds', 'min_beds', 'max_beds');
        $query = $this->filterMinMaxAttribute($query, 'price', 'min_price', 'max_price');
       // $query = $this->filterMinMaxAttribute($query, 'area', 'min_area', 'max_area');
        $query = $this->filterMinMaxAttribute($query, 'baths', 'min_baths', 'max_baths');
        $query = $this->getCommonFieldsQuery($query);
        return $query;
    }

    private function filterMinMaxAttribute($query, $attr, $min_attr, $max_attr)
    {
        if ($this->{$min_attr} && $this->{$max_attr}) {
            $query->andFilterWhere(['between', $attr, $this->{$min_attr}, $this->{$max_attr}]);
        }
        elseif ($this->{$min_attr} && !$this->{$max_attr}) {
            $query->andFilterWhere(['>=', $attr, $this->{$min_attr}]);
        }
        elseif (!$this->{$min_attr} && $this->{$max_attr}) {
            $query->andFilterWhere(['<=', $attr, $this->{$max_attr}]);
        }
        return $query;
    }

    public function searchAllPropertyRequirements($propertyRequirementLeadId)
    {
        $propertyRequirements = PropertyRequirement::find()->where(['lead_id' => $propertyRequirementLeadId])->orderBy(['id' => SORT_DESC])->all();
        $dataProviders = [];
        foreach ($propertyRequirements as $propertyRequirement) {
            $this->category_id = $propertyRequirement->category_id;
            $this->location = $propertyRequirement->location;
            $this->sub_location = $propertyRequirement->sub_location;
            $this->unit_type = $propertyRequirement->unit_type;
            $this->unit = $propertyRequirement->unit;
            $this->min_area = $propertyRequirement->min_area;
            $this->max_area = $propertyRequirement->max_area;
            $this->min_price = $propertyRequirement->min_price;
            $this->max_price = $propertyRequirement->max_price;
            $this->min_beds = $propertyRequirement->min_beds;
            $this->max_beds = $propertyRequirement->max_beds;
            $this->min_baths = $propertyRequirement->min_baths;
            $this->max_baths = $propertyRequirement->max_baths;

            $this->size = $propertyRequirement->size;
            $this->street_no = $propertyRequirement->street_no;
            $this->floor_no = $propertyRequirement->floor_no;
            $this->dewa_no = $propertyRequirement->dewa_no;
            $this->cheques = $propertyRequirement->cheques;
            $this->fitted = $propertyRequirement->fitted;
            $this->prop_status = $propertyRequirement->prop_status;
            $this->source_of_listing = $propertyRequirement->source_of_listing;
            $this->furnished = $propertyRequirement->furnished;
            $this->featured = $propertyRequirement->featured;
            $this->maintenance = $propertyRequirement->maintenance;
            $this->strno = $propertyRequirement->strno;
            $this->amount = $propertyRequirement->amount;
            $this->tenanted = $propertyRequirement->tenanted;
            $this->plot_size = $propertyRequirement->plot_size;
            $this->name = $propertyRequirement->name;
            $this->commission = $propertyRequirement->commission;
            $this->tenure = $propertyRequirement->tenure;

            $query = $this->getCompanyQuery();
            $query = $this->filterRequirementQuery($query);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
            ]);
            $dataProvider->pagination->pageSize = 2;
            $dataProviders[] = $dataProvider;
        }
        return $dataProviders;
    }
}