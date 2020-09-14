<?php

namespace app\modules\admin\models; 

use Yii; 
use yii\base\Model; 
use yii\data\ActiveDataProvider; 
use app\modules\admin\models\AuthItem;
use app\models\Company;

/** 
 * AuthItemSearch represents the model behind the search form of `app\modules\admin\models\AuthItem`. 
 */ 
class AuthItemSearch extends AuthItem 
{ 
    /** 
     * {@inheritdoc} 
     */ 
    public function rules() 
    { 
        return [ 
            [['name', 'type', 'description', 'rule_name', 'data', 'created_at'], 'safe'],
            [['updated_at', 'company_id'], 'integer'], 
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
            $query = AuthItem::find()->where(['!=', 'name', 'Owner'])->andWhere(['type' => '1']); 
        } else {   
            $query = AuthItem::find()
            ->where(['!=', 'name', 'Owner'])
            ->andWhere(['type' => '1', 'company_id' => $companyId]); 

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
            'updated_at' => $this->updated_at,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'rule_name', $this->rule_name])
            ->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider; 
    } 
} 