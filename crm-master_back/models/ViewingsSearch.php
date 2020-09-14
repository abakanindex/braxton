<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Viewings;

/**
 * ViewingsSearch represents the model behind the search form of `app\models\Viewings`.
 */
class ViewingsSearch extends Viewings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'agent_id', 'status'], 'integer'],
            [['date', 'client_name', 'note'], 'safe'],
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
        $this->load($params);

        $query = Viewings::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->pagination->pageSize = 10;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'agent_id' => $this->agent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
