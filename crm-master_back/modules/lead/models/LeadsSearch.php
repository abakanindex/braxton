<?php

namespace app\modules\lead\models;

use app\models\Company;
use app\models\User;
use DateTime;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leads;
use yii\db\Expression;
use app\modules\admin\models\OwnerManageGroup;

/**
 * LeadsSearch represents the model behind the search form of `app\models\Leads`.
 */
class LeadsSearch extends Leads
{
    public $type;
    public $subStatus;
    public $category;
    public $source;
    public $created_by_user;
    public $agent;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_imported', 'status', 'type_id', 'sub_status_id', 'priority', 'category_id', 'source', 'created_by_user_id', 'company_id', 'finance_type', 'origin'], 'integer'],
            [['shared_leads', 'agent_referrala', 'listing_ref', 'emirate', 'reference', 'first_name', 'last_name', 'mobile_number', 'location', 'sub_location', 'unit_type', 'unit_number', 'contract_company', 'email'], 'safe'],
            [['agent', 'enquiry_time', 'updated_time', 'type', 'subStatus', 'category', 'source', 'created_by_user'], 'safe'],
            [['max_beds', 'min_beds', 'max_price', 'min_price', 'min_area', 'max_area', 'agent_1', 'agent_2', 'agent_3', 'agent_4', 'agent_5'], 'safe'],
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
    public function search($params, $status = false)
    {
        $this->load($params);

        $companyId = Company::getCompanyIdBySubdomain(); 
        if ($companyId == 'main' or $companyId == 0) {
            $query = Leads::find();
        } else {   
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = Leads::find()->where([
                    'l.company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = Leads::find()->where([
                        'l.company_id' => $companyId
                    ])->andWhere(['l.created_by_user_id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = Leads::find()->where([
                        'l.company_id' => $companyId
                    ])->andWhere(['l.created_by_user_id' => Yii::$app->user->id]);
                }
            }
        }
        $query->alias('l');
        // add conditions that should always apply here
        $query->joinWith(['leadType', 'subStatus', 'category', 'companySource', 'createdByUser.userProfile', 'leadAgents.agent']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'l.type_id' => $this->type_id,
            'l.status' => ($status) ? $status : $this->status,
            'l.sub_status_id' => $this->sub_status_id,
            'l.category_id'   => $this->category_id,
            'l.priority' => $this->priority,
            'l.finance_type' => $this->finance_type,
            'l.emirate' => $this->emirate,
            'l.location' => $this->location,
            'l.min_price' => $this->min_price,
            'l.max_price' => $this->max_price,
            'l.max_beds' => $this->max_beds,
            'l.min_beds' => $this->min_beds,
            'l.min_area' => $this->min_area,
            'l.max_area' => $this->max_area,
            'l.listing_ref' => $this->listing_ref,
            'l.is_imported' => $this->is_imported,
        ]);

        $query->andFilterWhere(['like', 'reference', $this->reference])
            ->andFilterWhere(['like', 'l.first_name', $this->first_name])
            ->andFilterWhere(['like', 'l.last_name', $this->last_name])
            ->andFilterWhere(['like', 'l.mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'l.location', $this->location])
            ->andFilterWhere(['like', 'l.sub_location', $this->sub_location])
            ->andFilterWhere(['like', 'l.unit_type', $this->unit_type])
            ->andFilterWhere(['like', 'l.unit_number', $this->unit_number])
            ->andFilterWhere(['like', 'l.contract_company', $this->contract_company])
            ->andFilterWhere(['like', 'l.agent_referrala', $this->agent_referrala])
            ->andFilterWhere(['like', 'l.shared_leads', $this->shared_leads])
            ->andFilterWhere(['like', 'l.agent_1', $this->agent_1])
            ->andFilterWhere(['like', 'l.agent_2', $this->agent_2])
            ->andFilterWhere(['like', 'l.agent_3', $this->agent_3])
            ->andFilterWhere(['like', 'l.agent_4', $this->agent_4])
            ->andFilterWhere(['like', 'l.agent_5', $this->agent_5])
            ->andFilterWhere(['like', 'l.email', $this->email])
            ->andFilterWhere(['=', 'l.origin', $this->origin]);

        $query->andFilterWhere(['like', 'lead_type.id', $this->type]);
        $query->andFilterWhere(['like', 'lead_sub_status.id', $this->subStatus]);
        $query->andFilterWhere(['like', 'property_category.id', $this->category]);
        $query->andFilterWhere(['like', 'company_source.id', $this->source]);
        $query->andFilterWhere(['like', 'l.created_by_user_id', $this->created_by_user]);
        if ($this->agent) {
            $leadIds = LeadAgent::find()->where(['user_id' => $this->agent])->select(['lead_id'])->column();
            if (count($leadIds) > 0)
                $query->andFilterWhere(['in', 'l.id', $leadIds]);
            else
                $query->andFilterWhere(['in', 'l.id', (new Expression('Null'))]);
        }
        if ($this->enquiry_time) {
            $enquiryDateTime = DateTime::createFromFormat('d-m-Y', $this->enquiry_time);
            $enquiryTime = $enquiryDateTime->getTimestamp();
            $enquiryMidnight = strtotime("midnight", $enquiryTime);
            $enquiryTommorow = strtotime("tomorrow", $enquiryTime);
            $query->andFilterWhere(['between', 'enquiry_time', $enquiryMidnight, $enquiryTommorow]);
        }
        if ($this->updated_time) {
            $updatedDateTime = DateTime::createFromFormat('d-m-Y', $this->updated_time);
            $updatedTime = $updatedDateTime->getTimestamp();
            $updatedMidnight = strtotime("midnight", $updatedTime);
            $updatedTommorow = strtotime("tomorrow", $updatedTime);
            $query->andFilterWhere(['between', 'updated_time', $updatedMidnight, $updatedTommorow]);
        }

        return $dataProvider;
    }
}
