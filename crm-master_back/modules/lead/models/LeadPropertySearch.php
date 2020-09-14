<?php

namespace app\modules\lead\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lead\models\LeadProperty;

/**
 * LeadPropertySearch represents the model behind the search form of `app\modules\lead\models\LeadProperty`.
 */
class LeadPropertySearch extends LeadProperty
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lead_id', 'property_id', 'type'], 'integer'],
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
        $query = LeadProperty::find();

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
            'property_id' => $this->property_id,
            'type' => $this->type,
        ]);

        return $dataProvider;
    }
}
