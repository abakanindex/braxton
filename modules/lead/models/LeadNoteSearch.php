<?php

namespace app\modules\lead\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lead\models\LeadNote;

/**
 * LeadNoteSearch represents the model behind the search form of `app\modules\lead\models\LeadNote`.
 */
class LeadNoteSearch extends LeadNote
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lead_id'], 'integer'],
            [['text'], 'safe'],
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
        $query = LeadNote::find();

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
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
