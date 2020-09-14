<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contacts;
use app\models\Company;

/**
 * ContactsSearch represents the model behind the search form of `app\models\Contacts`.
 */
class ContactsSearch extends Contacts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['assigned_to', 'ref', 'title', 'first_name', 'last_name', 'gender', 'date_of_birth', 'nationalities', 'religion', 'languagesd', 'hobbies', 'mobile', 'phone', 'email', 'address', 'fb', 'tw', 'linkedin', 'skype', 'googlplus', 'wechat', 'in', 'contact_source', 'company_name', 'designation', 'contact_type', 'created_by', 'notes', 'documents'], 'safe'],
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
        $companyId = Company::getCompanyIdBySubdomain(); 

        if ($companyId == 'main') {
            $query = Contacts::find();
        } else {   
            $query = Contacts::find()->where([
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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'assigned_to', $this->assigned_to])
            ->andFilterWhere(['like', 'ref', $this->ref])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'date_of_birth', $this->date_of_birth])
           // ->andFilterWhere(['like', 'nationalities', $this->nationalities])
            ->andFilterWhere(['like', 'religion', $this->religion])
          //  ->andFilterWhere(['like', 'languagesd', $this->languagesd])
         //   ->andFilterWhere(['like', 'hobbies', $this->hobbies])
         //   ->andFilterWhere(['like', 'mobile', $this->mobile])
         //   ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'fb', $this->fb])
            ->andFilterWhere(['like', 'tw', $this->tw])
            ->andFilterWhere(['like', 'linkedin', $this->linkedin])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'googlplus', $this->googlplus])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'in', $this->in])
            ->andFilterWhere(['like', 'contact_source', $this->contact_source])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'contact_type', $this->contact_type])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'documents', $this->documents]);

        return $dataProvider;
    }
}
