<?php

namespace app\modules\deals\models;

use yii\db\ActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;
use app\interfaces\firstrecordmodel\IfirstRecordModel;
use yii\behaviors\SluggableBehavior;
use app\models\statusHistory\ArchiveHistory;
use app\models\Company;
use app\models\Sale;
use app\models\Rentals;
use app\modules\admin\models\OwnerManageGroup;
use yii\base\Model;

class DealsSearch extends Deals
{
    public $unit;
    public $street_no;
    public $beds;
    public $unit_type;
    public $floor_no;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [
                [
                    'id',
                    'ref',
                    'type',
                    'model_id',
                    'created_at',
                    'lead_id',
                    'seller_id',
                    'buyer_id',
                    'company_id',
                    'status',
                    'sub_status',
                    'source',
                    'deal_price',
                    'deposit',
                    'gross_commission',
                    'is_vat',
                    'is_external_referral',
                    'external_referral_name',
                    '$external_referral_type',
                    'external_referral_commission',
                    'your_company_commission',
                    'agent_1',
                    'agent_1_commission',
                    'agent_2',
                    'agent_2_commission',
                    'agent_3',
                    'agent_3_commission',
                    'cheques',
                    'estimated_date',
                    'actual_date',
                    'created_by',
                    'is_international',
                ], 'safe'
            ],

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
     * @return $this|\yii\db\ActiveQuery
     */
    private function getCompanyQuery()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = Deals::find()->where(['d.is_international' => 0]);
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = Deals::find()->where([
                    'd.company_id' => $companyId,
                    'd.is_international' => 0
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = Deals::find()
                        ->where([
                            'd.company_id' => $companyId,
                            'd.is_international' => 0
                        ])
                        ->andWhere(['created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = Deals::find()->where([
                        'd.company_id' => $companyId,
                        'd.is_international' => 0
                    ])->andWhere(['d.created_by' => Yii::$app->user->id]);
                }
            }
        }

        $query->alias('d');
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
        $query->joinWith('buyer ub')
            ->joinWith('seller us')
            ->joinWith('agent1 ua1')
            ->joinWith('agent2 ua2')
            ->joinWith('agent3 ua3')
            ->joinWith('lead l');
        $this->load($params);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'd.ref', $this->ref])
            ->andFilterWhere(['like', 'd.type', $this->type])
            ->andFilterWhere(['like', 'd.status', $this->status])
            ->andFilterWhere(['like', 'd.sub_status', $this->sub_status])
            ->andFilterWhere(['=', 'd.deal_price', $this->deal_price])
            ->andFilterWhere(['like', 'ub.username', $this->buyer_id])
            ->andFilterWhere(['like', 'us.username', $this->seller_id])
            ->andFilterWhere(['like', 'ua1.username', $this->agent_1])
            ->andFilterWhere(['=', 'd.agent_1_commission', $this->agent_1_commission])
            ->andFilterWhere(['like', 'ua2.username', $this->agent_2])
            ->andFilterWhere(['=', 'd.agent_2_commission', $this->agent_2_commission])
            ->andFilterWhere(['like', 'ua3.username', $this->agent_3])
            ->andFilterWhere(['=', 'd.agent_3_commission', $this->agent_3_commission])
            ->andFilterWhere(['=', 'l.source', $this->lead_id])
            ->andFilterWhere(['=', 'd.actual_date', $this->actual_date])
            ->andFilterWhere(['=', 'd.actual_date', $this->actual_date])
            ->andFilterWhere(['=', 'd.estimated_date', $this->estimated_date])
        ;

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied for international deals
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchInt($params)
    {
        $query = $this->getCompanyQueryInt();
        $this->load($params);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    /**
     * @return $this|\yii\db\ActiveQuery
     */
    private function getCompanyQueryInt()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = Deals::find()->where(['is_international' => 1]);
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = Deals::find()->where([
                    'company_id' => $companyId,
                    'is_international' => 1
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = Deals::find()
                        ->where([
                            'company_id' => $companyId,
                            'is_international' => 1
                        ])
                        ->andWhere(['created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = Deals::find()->where([
                        'company_id' => $companyId,
                        'is_international' => 1
                    ])->andWhere(['created_by' => Yii::$app->user->id]);
                }
            }
        }

        $query->alias('d');
        return $query;
    }
}