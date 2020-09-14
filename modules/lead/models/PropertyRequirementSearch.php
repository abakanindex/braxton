<?php

namespace app\modules\lead\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PropertyRequirementSearch represents the model behind the search form of `app\modules\lead_viewing\models\PropertyRequirement`.
 */
class PropertyRequirementSearch extends PropertyRequirement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lead_id', 'category_id', 'min_beds', 'max_beds', 'min_area', 'max_area', 'min_baths', 'max_baths'], 'integer'],
            [['emirate', 'location', 'sub_location', 'unit_type', 'unit'], 'safe'],
            [['min_price', 'max_price'], 'number'],
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
        $query = PropertyRequirement::find();

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
            'lead_id' => $this->lead_id,
            'category_id' => $this->category_id,
            'min_beds' => $this->min_beds,
            'max_beds' => $this->max_beds,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'min_area' => $this->min_area,
            'max_area' => $this->max_area,
            'min_baths' => $this->min_baths,
            'max_baths' => $this->max_baths
        ]);

        $query
            ->andFilterWhere(['=', 'emirate', $this->emirate])
            ->andFilterWhere(['=', 'location', $this->location])
            ->andFilterWhere(['=', 'sub_location', $this->sub_location])
            ->andFilterWhere(['like', 'unit_type', $this->unit_type])
            ->andFilterWhere(['like', 'unit', $this->unit]);

        return $dataProvider;
    }
}
