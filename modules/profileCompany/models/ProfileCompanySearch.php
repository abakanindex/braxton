<?php

namespace app\modules\profileCompany\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\profileCompany\models\ProfileCompany;

/**
 * ProfileCompanySearch represents the model behind the search form of `app\modules\profileCompany\models\ProfileCompany`.
 */
class ProfileCompanySearch extends ProfileCompany
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['company_name', 'rera_orn', 'trn', 'address', 'office_tel', 'office_fax', 'primary_email', 'website', 'company_profile', 'logo', 'watermark'], 'safe'],
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
        $query = ProfileCompany::find();

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

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'rera_orn', $this->rera_orn])
            ->andFilterWhere(['like', 'trn', $this->trn])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'office_tel', $this->office_tel])
            ->andFilterWhere(['like', 'office_fax', $this->office_fax])
            ->andFilterWhere(['like', 'primary_email', $this->primary_email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'company_profile', $this->company_profile])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'watermark', $this->watermark]);

        return $dataProvider;
    }
}
