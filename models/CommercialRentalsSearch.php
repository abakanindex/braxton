<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CommercialRentals;

/**
 * CommercialRentalsSearch represents the model behind the search form of `app\models\CommercialRentals`.
 */
class CommercialRentalsSearch extends CommercialRentals
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'ref', 'completion_status', 'category', 'beds', 'bath', 'emirate', 'location', 'sub_location', 'tenure', 'furnished', 'price', 'price_2', 'status', 'language', 'property_status', 'source_listing', 'featured', 'remind', 'key_location', 'property', 'managed', 'exclusive', 'invite', 'poa'], 'integer'],
            [['permit', 'unit', 'type', 'street', 'floor', 'built', 'plot', 'view', 'parking', 'photos', 'floor_plans', 'title', 'description', 'portals', 'features', 'neighbourhood', 'dewa', 'str', 'available', 'rented_at', 'rented_until', 'maintenance'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CommercialRentals::find();

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
            'user_id' => $this->user_id,
            'ref' => $this->ref,
            'completion_status' => $this->completion_status,
            'category' => $this->category,
            'beds' => $this->beds,
            'bath' => $this->bath,
            'emirate' => $this->emirate,
            'location' => $this->location,
            'sub_location' => $this->sub_location,
            'tenure' => $this->tenure,
            'furnished' => $this->furnished,
            'price' => $this->price,
            'price_2' => $this->price_2,
            'status' => $this->status,
            'language' => $this->language,
            'property_status' => $this->property_status,
            'source_listing' => $this->source_listing,
            'featured' => $this->featured,
            'remind' => $this->remind,
            'key_location' => $this->key_location,
            'property' => $this->property,
            'managed' => $this->managed,
            'exclusive' => $this->exclusive,
            'invite' => $this->invite,
            'poa' => $this->poa,
        ]);

        $query->andFilterWhere(['like', 'permit', $this->permit])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'floor', $this->floor])
            ->andFilterWhere(['like', 'built', $this->built])
            ->andFilterWhere(['like', 'plot', $this->plot])
            ->andFilterWhere(['like', 'view', $this->view])
            ->andFilterWhere(['like', 'parking', $this->parking])
            ->andFilterWhere(['like', 'photos', $this->photos])
            ->andFilterWhere(['like', 'floor_plans', $this->floor_plans])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'portals', $this->portals])
            ->andFilterWhere(['like', 'features', $this->features])
            ->andFilterWhere(['like', 'neighbourhood', $this->neighbourhood])
            ->andFilterWhere(['like', 'dewa', $this->dewa])
            ->andFilterWhere(['like', 'str', $this->str])
            ->andFilterWhere(['like', 'available', $this->available])
            ->andFilterWhere(['like', 'rented_at', $this->rented_at])
            ->andFilterWhere(['like', 'rented_until', $this->rented_until])
            ->andFilterWhere(['like', 'maintenance', $this->maintenance]);

        return $dataProvider;
    }
}
