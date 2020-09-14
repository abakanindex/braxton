<?php

namespace app\modules\calendar\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\calendar\models\Event;

/**
 * EventSearch represents the model behind the search form of `app\modules\calendar\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'start', 'end', 'type', 'created_at', 'rentals_id', 'sale_id', 'lead_viewing_id'], 'integer'],
            [['title', 'location', 'description'], 'safe'],
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
        $query = Event::find();

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
            'owner_id' => $this->owner_id,
            'start' => $this->start,
            'end' => $this->end,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'rentals_id' => $this->rentals_id,
            'sale_id' => $this->sale_id,
            'lead_viewing_id' => $this->lead_viewing_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
