<?php

namespace app\modules\reports\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\reports\models\ReportsMenuItem;

/**
 * ReportsMenuItemSearch represents the model behind the search form of `app\modules\reports\models\ReportsMenuItem`.
 */
class ReportsMenuItemSearch extends ReportsMenuItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'uri', 'parent_id', 'sort_order'], 'safe'],
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
        $query = ReportsMenuItem::find();

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'uri', $this->uri])
            ->andFilterWhere(['like', 'parent_id', $this->parent_id])
            ->andFilterWhere(['like', 'sort_order', $this->sort_order]);

        return $dataProvider;
    }
}
