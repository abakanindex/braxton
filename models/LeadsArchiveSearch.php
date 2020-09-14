<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LeadsArchive;
use app\modules\admin\models\OwnerManageGroup;

/**
 * LeadsArchiveSearch represents the model behind the search form of `app\models\LeadsArchive`.
 */
class LeadsArchiveSearch extends LeadsArchive
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'status', 'sub_status_id', 'priority', 'category_id', 'min_beds', 'max_beds', 'min_price', 'max_price', 'min_area', 'max_area', 'source', 'created_by_user_id', 'finance_type', 'enquiry_time', 'updated_time', 'activity', 'email_opt_out', 'phone_opt_out', 'is_imported', 'company_id'], 'integer'],
            [['reference', 'hot_lead', 'first_name', 'last_name', 'mobile_number', 'emirate', 'location', 'sub_location', 'unit_type', 'unit_number', 'listing_ref', 'agent_referrala', 'shared_leads', 'contract_company', 'email', 'slug', 'notes', 'agent_1', 'agent_2', 'agent_3', 'agent_4', 'agent_5'], 'safe'],
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

    private function getCompanyQuery()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = LeadsArchive::find();
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = LeadsArchive::find()->where([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = LeadsArchive::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by_user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = LeadsArchive::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by_user_id' => Yii::$app->user->id]);
                }
            }
        }

        $query->alias('s');
        $query->joinWith(['category']);
        return $query;
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
        $query = $this->getCompanyQuery();
        $this->load($params);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'status' => $this->status,
            'sub_status_id' => $this->sub_status_id,
            'priority' => $this->priority,
            'category_id' => $this->category_id,
            'min_beds' => $this->min_beds,
            'max_beds' => $this->max_beds,
            'min_price' => $this->min_price,
            'max_price' => $this->max_price,
            'min_area' => $this->min_area,
            'max_area' => $this->max_area,
            'source' => $this->source,
            'created_by_user_id' => $this->created_by_user_id,
            'finance_type' => $this->finance_type,
            'enquiry_time' => $this->enquiry_time,
            'updated_time' => $this->updated_time,
            'activity' => $this->activity,
            'email_opt_out' => $this->email_opt_out,
            'phone_opt_out' => $this->phone_opt_out,
            'is_imported' => $this->is_imported,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'hot_lead', $this->hot_lead])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'emirate', $this->emirate])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'sub_location', $this->sub_location])
            ->andFilterWhere(['like', 'unit_type', $this->unit_type])
            ->andFilterWhere(['like', 'unit_number', $this->unit_number])
            ->andFilterWhere(['like', 'listing_ref', $this->listing_ref])
            ->andFilterWhere(['like', 'agent_referrala', $this->agent_referrala])
            ->andFilterWhere(['like', 'shared_leads', $this->shared_leads])
            ->andFilterWhere(['like', 'contract_company', $this->contract_company])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'agent_1', $this->agent_1])
            ->andFilterWhere(['like', 'agent_2', $this->agent_2])
            ->andFilterWhere(['like', 'agent_3', $this->agent_3])
            ->andFilterWhere(['like', 'agent_4', $this->agent_4])
            ->andFilterWhere(['like', 'agent_5', $this->agent_5]);

        return $dataProvider;
    }
}
