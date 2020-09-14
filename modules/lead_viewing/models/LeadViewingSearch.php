<?php

namespace app\modules\lead_viewing\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lead_viewing\models\LeadViewing;

/**
 * LeadViewingSearch represents the model behind the search form of `app\modules\lead_viewing\models\LeadViewing`.
 */
class LeadViewingSearch extends LeadViewing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'lead_id', 'time', 'created_at'], 'integer'],
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
        $query = LeadViewing::find();

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
            'user_id' => Yii::$app->user->id,
            'lead_id' => $this->lead_id,
            'time' => $this->time,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}