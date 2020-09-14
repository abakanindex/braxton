<?php

namespace app\modules\reports\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\reports\models\Reports;

/**
 * UserReportsSearch represents the model behind the search form of `app\modules\reports\models\Reports`.
 */
class UserReportsSearch extends Reports
{
    /**
     * @inheritdoc
     */
    public $report_type;
    public $interval;

    public function rules()
    {
        return [
            [['id', 'type', 'user_id', 'created_at', 'date_type', 'report_type'], 'integer'],
            [['date_from', 'date_to', 'url_id'], 'string'],
            [['description', 'name', 'report_type', 'interval'], 'safe'],
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

        if ($this->type) {
            switch ($this->type) {
                case self::SECTION_REPORTS_LISTINGS:
                     $query->andFilterWhere(['type' => Reports::$listingTypes]);
                    break;
                case self::SECTION_REPORTS_LEADS:
                    $query->andFilterWhere(['type' => Reports::$leadTypes]);
                    break;
                case self::SECTION_REPORTS_DEALS:
                    $query->andFilterWhere(['type' => Reports::$dealsTypes]);
                    break;
                case self::SECTION_REPORTS_TO_DO_TASKS:
                    $query->andFilterWhere(['type' => Reports::$tasksTypes]);
                    break;
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => Yii::$app->user->id,
            'created_at' => $this->created_at,
            'date_type' => $this->date_type,
            'url_id' => $this->url_id,
        ]);

        if ($this->interval) {
            $dates = explode(" ", $this->interval);
            $this->date_from = $dates[0];
            $this->date_to = $dates[2];
//            $query->andFilterWhere(['and', "date_from>=$this->date_from", "date_to<=$this->date_to"]);
        }

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
