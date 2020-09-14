<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leads;
use app\models\Company;
use app\modules\admin\models\OwnerManageGroup;

/**
 * LeadsSearch represents the model behind the search form of `app\models\Leads`.
 */
class LeadsSearch extends Leads
{
    public $auto;
    public $finance;
    public $updated;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'agents', 'email_opt_out', 'phone_opt_out', 'created_by_user_id'], 'safe'],
            [['agent_1', 'agent_2', 'agent_3', 'agent_4', 'agent_5'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [
                [
                    'activity',
                    'type_id',
                    'status',
                    'sub_status_id',
                    'priority',
                    'category_id',
                    'source',
                    'finance_type',
                    'updated_time',
                    'origin'
                ], 'integer'
            ],
            [['max_price'], 'number'],
            [
                [
                    'hot_lead',
                    'emirate',
                    'shared_leads',
                    'agent_referrala',
                    'listing_ref',
                    'socialMediaContacts',
                    'additionalEmails',
                    'reference',
                    'enquiry_time',
                    'activity',
                    'location',
                    'sub_location',
                    'created_at',
                    'reminder',
                    'notesAttr',
                    'max_beds',
                    'min_beds',
                    'max_price',
                    'min_price',
                    'min_area',
                    'max_area'
                ], 'safe'
            ],
            [['reference'], 'string', 'max' => 20],
            [['first_name', 'last_name', 'contract_company', 'email'], 'string', 'max' => 100],
            [['mobile_number'], 'string', 'max' => 30],
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
        $query->joinWith('createdByUser');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $query->andFilterWhere(['=', 'l.id', $this->id])
            ->andFilterWhere(['like', 'l.reference', $this->reference])
            ->andFilterWhere(['=', 'l.type_id', $this->type_id])
            ->andFilterWhere(['=', 'l.status', $this->status])
            ->andFilterWhere(['=', 'l.sub_status_id', $this->sub_status_id])
            ->andFilterWhere(['like', 'l.priority', $this->priority])
            ->andFilterWhere(['like', 'l.first_name', $this->first_name])
            ->andFilterWhere(['like', 'l.last_name', $this->last_name])
            ->andFilterWhere(['like', 'l.mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'u2.username', $this->created_by_user_id])
            ->andFilterWhere(['=', 'l.source', $this->source])
            ->andFilterWhere(['=', 'l.origin', $this->origin])
            ->andFilterWhere(['=', 'l.enquiry_time', $this->enquiry_time])
            ->andFilterWhere(['=', 'l.updated_time', $this->updated_time])
            ->andFilterWhere(['like', 'l.contract_company', $this->contract_company])
            ->andFilterWhere(['like', 'l.listing_ref', $this->listing_ref])
            ->andFilterWhere(['like', 'l.email', $this->email])
        ;

        return $dataProvider;
    }
}
