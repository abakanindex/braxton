<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RentalsPending;
use app\modules\admin\models\OwnerManageGroup;

/**
 * RentalsPendingSearch represents the model behind the search form of `app\models\RentalsPending`.
 */
class RentalsPendingSearch extends RentalsPending
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['status', 'managed', 'exclusive', 'shared', 'ref', 'unit', 'category_id', 'region_id', 'area_location_id', 'sub_area_location_id', 'beds', 'size', 'price', 'agent_id', 'landlord_id', 'unit_type', 'baths', 'street_no', 'floor_no', 'dewa_no', 'photos', 'cheques', 'fitted', 'prop_status', 'source_of_listing', 'available_date', 'remind_me', 'floor_plans', 'furnished', 'featured', 'maintenance', 'strno', 'amount', 'tenanted', 'plot_size', 'name', 'view_id', 'commission', 'deposit', 'unit_size_price', 'dateadded', 'dateupdated', 'user_id', 'key_location', 'international', 'rand_key', 'development_unit_id', 'type', 'rera_permit', 'DT_RowClass', 'DT_RowId', 'tenure', 'completion_status', 'owner_mobile', 'owner_email', 'secondary_ref', 'terminal', 'other_title_2', 'invite', 'poa', 'rented_at', 'rented_until', 'description', 'language', 'slug', 'portals', 'features', 'neighbourhood_info'], 'safe'],
            [['latitude', 'longitude'], 'number'],
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

    private function getCompanyQuery()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = RentalsPending::find();
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = RentalsPending::find()->where([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = RentalsPending::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = RentalsPending::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['user_id' => Yii::$app->user->id]);
                }
            }
        }

        $query->alias('s');
        $query->joinWith(['category']);
        return $query;
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
        $query = $this->getCompanyQuery();
        $this->load($params);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['=', 'managed', $this->managed])
            ->andFilterWhere(['=', 'exclusive', $this->exclusive])
            ->andFilterWhere(['=', 'shared', $this->shared])
            ->andFilterWhere(['like', 'ref', $this->ref])
            ->andFilterWhere(['=', 'unit', $this->unit])
            ->andFilterWhere(['=', 'category_id', $this->category_id])
            ->andFilterWhere(['=', 'region_id', $this->region_id])
            ->andFilterWhere(['=', 'area_location_id', $this->area_location_id])
            ->andFilterWhere(['=', 'sub_area_location_id', $this->sub_area_location_id])
            ->andFilterWhere(['=', 'beds', $this->beds])
            ->andFilterWhere(['=', 'size', $this->size])
            ->andFilterWhere(['=', 'price', $this->price])
            ->andFilterWhere(['=', 'agent_id', $this->agent_id])
            ->andFilterWhere(['=', 'landlord_id', $this->landlord_id])
            ->andFilterWhere(['=', 'unit_type', $this->unit_type])
            ->andFilterWhere(['=', 'baths', $this->baths])
            ->andFilterWhere(['=', 'street_no', $this->street_no])
            ->andFilterWhere(['=', 'floor_no', $this->floor_no])
            ->andFilterWhere(['=', 'dewa_no', $this->dewa_no])
            ->andFilterWhere(['=', 'photos', $this->photos])
            ->andFilterWhere(['=', 'cheques', $this->cheques])
            ->andFilterWhere(['=', 'fitted', $this->fitted])
            ->andFilterWhere(['=', 'prop_status', $this->prop_status])
            ->andFilterWhere(['=', 'source_of_listing', $this->source_of_listing])
            ->andFilterWhere(['=', 'available_date', $this->available_date])
            ->andFilterWhere(['=', 'remind_me', $this->remind_me])
            ->andFilterWhere(['=', 'floor_plans', $this->floor_plans])
            ->andFilterWhere(['=', 'furnished', $this->furnished])
            ->andFilterWhere(['=', 'featured', $this->featured])
            ->andFilterWhere(['=', 'maintenance', $this->maintenance])
            ->andFilterWhere(['=', 'strno', $this->strno])
            ->andFilterWhere(['=', 'amount', $this->amount])
            ->andFilterWhere(['=', 'tenanted', $this->tenanted])
            ->andFilterWhere(['=', 'plot_size', $this->plot_size])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['=', 'view_id', $this->view_id])
            ->andFilterWhere(['=', 'commission', $this->commission])
            ->andFilterWhere(['=', 'deposit', $this->deposit])
            ->andFilterWhere(['=', 'unit_size_price', $this->unit_size_price])
            ->andFilterWhere(['=', 'dateadded', $this->dateadded])
            ->andFilterWhere(['=', 'dateupdated', $this->dateupdated])
            ->andFilterWhere(['=', 'user_id', $this->user_id])
            ->andFilterWhere(['=', 'key_location', $this->key_location])
            ->andFilterWhere(['=', 'international', $this->international])
            ->andFilterWhere(['=', 'rand_key', $this->rand_key])
            ->andFilterWhere(['=', 'development_unit_id', $this->development_unit_id])
            ->andFilterWhere(['=', 'type', $this->type])
            ->andFilterWhere(['like', 'rera_permit', $this->rera_permit])
            ->andFilterWhere(['=', 'DT_RowClass', $this->DT_RowClass])
            ->andFilterWhere(['=', 'DT_RowId', $this->DT_RowId])
            ->andFilterWhere(['=', 'tenure', $this->tenure])
            ->andFilterWhere(['=', 'completion_status', $this->completion_status])
            ->andFilterWhere(['like', 'owner_mobile', $this->owner_mobile])
            ->andFilterWhere(['like', 'owner_email', $this->owner_email])
            ->andFilterWhere(['=', 'secondary_ref', $this->secondary_ref])
            ->andFilterWhere(['=', 'terminal', $this->terminal])
            ->andFilterWhere(['like', 'other_title_2', $this->other_title_2])
            ->andFilterWhere(['=', 'invite', $this->invite])
            ->andFilterWhere(['=', 'poa', $this->poa])
            ->andFilterWhere(['=', 'rented_at', $this->rented_at])
            ->andFilterWhere(['=', 'rented_until', $this->rented_until])
            ->andFilterWhere(['=', 'description', $this->description])
            ->andFilterWhere(['=', 'language', $this->language])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['=', 'portals', $this->portals])
            ->andFilterWhere(['=', 'features', $this->features])
            ->andFilterWhere(['=', 'neighbourhood_info', $this->neighbourhood_info]);

        return $dataProvider;
    }
}
