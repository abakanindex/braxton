<?php

namespace app\modules\reports\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\reports\models\Reports;

/**
 * ReportsSearch represents the model behind the search form of `app\modules\reports\models\Reports`.
 */
class ReportsSearch extends Reports
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'user_id', 'created_at', 'date_type', 'date_from', 'date_to', 'url_id'], 'integer'],
            [['description', 'name'], 'safe'],
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
        $query = Reports::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'type' => $this->type,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'date_type' => $this->date_type,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'url_id' => $this->url_id,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
