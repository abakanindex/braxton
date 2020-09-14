<?php

namespace app\models; 

use Yii; 
use yii\base\Model; 
use yii\data\ActiveDataProvider; 
use app\models\Rentals; 
use app\models\Company;

/** 
 * RentalsSearch represents the model behind the search form of `app\models\Rentals`. 
 */ 
class RentalsSearch extends Rentals 
{ 
    /** 
     * {@inheritdoc} 
     */ 
    public function rules() 
    { 
        return [ 
            [['id', 'company_id'], 'integer'],
            [['status', 'managed', 'exclusive', 'shared', 'ref', 'unit', 'category_id', 'region_id', 'area_location_id', 'sub_area_location_id', 'beds', 'size', 'price', 'agent_id', 'landlord_id', 'unit_type', 'baths', 'street_no', 'floor_no', 'dewa_no', 'photos', 'cheques', 'fitted', 'prop_status', 'source_of_listing', 'available_date', 'remind_me', 'floor_plans', 'furnished', 'featured', 'maintenance', 'strno', 'amount', 'tenanted', 'plot_size', 'name', 'view_id', 'commission', 'deposit', 'unit_size_price', 'dateadded', 'dateupdated', 'user_id', 'key_location', 'international', 'rand_key', 'development_unit_id', 'type', 'rera_permit', 'DT_RowClass', 'DT_RowId', 'tenure', 'completion_status', 'owner_mobile', 'owner_email', 'secondary_ref', 'terminal', 'other_title_2', 'slug'], 'safe'],
        ]; 
    } 

    /** 
     * {@inheritdoc} 
     */ 
    public function scenarios() 
    { 
        // bypass scenarios() implementation in the parent class 
        return Model::scenarios(); 
    } 

    /** 
     * Creates data provider instance with search query applied 
     * 
     * @param array $params 
     * 
     * @return ActiveDataProvider 
     */ 
    public function search($params) 
    { 
        $companyId = Company::getCompanyIdBySubdomain(); 

        if ($companyId == 'main') {
            $query = Rentals::find();
        } else {   
            $query = Rentals::find()->where([
                'company_id' => $companyId
            ]);
        }

        // add conditions that should always apply here 

        $dataProvider = new ActiveDataProvider([ 
            'query' => $query, 
        ]); 

        $this->load($params); 

        if (!$this->validate()) { 
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1'); 
            return $dataProvider; 
        } 

        // grid filtering conditions 
        $query->andFilterWhere([
            'id' => $this->id,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'managed', $this->managed])
            ->andFilterWhere(['like', 'exclusive', $this->exclusive])
            ->andFilterWhere(['like', 'shared', $this->shared])
            ->andFilterWhere(['like', 'ref', $this->ref])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['like', 'region_id', $this->region_id])
            ->andFilterWhere(['like', 'area_location_id', $this->area_location_id])
            ->andFilterWhere(['like', 'sub_area_location_id', $this->sub_area_location_id])
            ->andFilterWhere(['like', 'beds', $this->beds])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'agent_id', $this->agent_id])
            ->andFilterWhere(['like', 'landlord_id', $this->landlord_id])
            ->andFilterWhere(['like', 'unit_type', $this->unit_type])
            ->andFilterWhere(['like', 'baths', $this->baths])
            ->andFilterWhere(['like', 'street_no', $this->street_no])
            ->andFilterWhere(['like', 'floor_no', $this->floor_no])
            ->andFilterWhere(['like', 'dewa_no', $this->dewa_no])
            ->andFilterWhere(['like', 'photos', $this->photos])
            ->andFilterWhere(['like', 'cheques', $this->cheques])
            ->andFilterWhere(['like', 'fitted', $this->fitted])
            ->andFilterWhere(['like', 'prop_status', $this->prop_status])
            ->andFilterWhere(['like', 'source_of_listing', $this->source_of_listing])
            ->andFilterWhere(['like', 'available_date', $this->available_date])
            ->andFilterWhere(['like', 'remind_me', $this->remind_me])
            ->andFilterWhere(['like', 'floor_plans', $this->floor_plans])
            ->andFilterWhere(['like', 'furnished', $this->furnished])
            ->andFilterWhere(['like', 'featured', $this->featured])
            ->andFilterWhere(['like', 'maintenance', $this->maintenance])
            ->andFilterWhere(['like', 'strno', $this->strno])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'tenanted', $this->tenanted])
            ->andFilterWhere(['like', 'plot_size', $this->plot_size])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'view_id', $this->view_id])
            ->andFilterWhere(['like', 'commission', $this->commission])
            ->andFilterWhere(['like', 'deposit', $this->deposit])
            ->andFilterWhere(['like', 'unit_size_price', $this->unit_size_price])
            ->andFilterWhere(['like', 'dateadded', $this->dateadded])
            ->andFilterWhere(['like', 'dateupdated', $this->dateupdated])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'key_location', $this->key_location])
            ->andFilterWhere(['like', 'international', $this->international])
            ->andFilterWhere(['like', 'rand_key', $this->rand_key])
            ->andFilterWhere(['like', 'development_unit_id', $this->development_unit_id])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'rera_permit', $this->rera_permit])
            ->andFilterWhere(['like', 'DT_RowClass', $this->DT_RowClass])
            ->andFilterWhere(['like', 'DT_RowId', $this->DT_RowId])
            ->andFilterWhere(['like', 'tenure', $this->tenure])
            ->andFilterWhere(['like', 'completion_status', $this->completion_status])
            ->andFilterWhere(['like', 'owner_mobile', $this->owner_mobile])
            ->andFilterWhere(['like', 'owner_email', $this->owner_email])
            ->andFilterWhere(['like', 'secondary_ref', $this->secondary_ref])
            ->andFilterWhere(['like', 'terminal', $this->terminal])
            ->andFilterWhere(['like', 'other_title_2', $this->other_title_2])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider; 
    } 
} 