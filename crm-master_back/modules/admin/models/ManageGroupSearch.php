<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\ManageGroup;
use app\models\Company;

/**
 * ManageGroupSearch represents the model behind the search form of `app\modules\admin\models\ManageGroup`.
 */
class ManageGroupSearch extends ManageGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['group_name', 'description'], 'safe'],
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
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main') {
            $query = ManageGroup::find();
        } else {   
            $query = ManageGroup::find()->where([
                'company_id' => $companyId
            ]);
        }

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
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'group_name', $this->group_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
