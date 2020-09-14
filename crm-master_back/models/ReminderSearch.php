<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reminder;

/**
 * ReminderSearch represents the model behind the search form of `app\models\Reminder`.
 */
class ReminderSearch extends Reminder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'time', 'key', 'key_id', 'interval_type', 'created_at'], 'integer'],
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
        $this->load($params);
        $query = Reminder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'time' => $this->time,
            'key' => $this->key,
            'key_id' => $this->key_id,
            'interval_type' => $this->interval_type,
            'created_at' => $this->created_at,
            'user_id' => Yii::$app->user->id,
        ]);

        return $dataProvider;
    }
}
