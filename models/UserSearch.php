<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\modules\admin\models\OwnerManageGroup;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'phone_number', 'company_id'], 'integer'],
            [['username', 'first_name', 'last_name', 'job_title', 'office_no', 'country_dialing', 'mobile_no', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'role', 'activation', 'country'], 'safe'],
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

    public function getByRole($role)
    {
//        $query = $this->getCompanyQueryUser();


        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == 0) {
            $query = self::find();
        } else {
            $query = self::find()->where([
                'company_id' => $companyId
            ]);
        }
//        return $query;

        $query->andWhere(['role' => $role]);
        return $query->all();
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
            $query = User::find();
        } else {   
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = User::find()->where([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = User::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['id' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = User::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['id' => Yii::$app->user->id]);
                }
            }
        }

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'phone_number' => $this->phone_number,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'job_title', $this->job_title])
            ->andFilterWhere(['like', 'office_no', $this->office_no])
            ->andFilterWhere(['like', 'country_dialing', $this->country_dialing])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'activation', $this->activation])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param string $role
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchByRole($role, $params)
    {
//        $companyId = Company::getCompanyIdBySubdomain();
//        if ($companyId == 'main' or $companyId == 0) {
            $query = User::find();
//        } else {
//            $query = User::find()->where(['company_id' => $companyId]);
//        }

        $query->andWhere(['role' => $role]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'phone_number' => $this->phone_number,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'job_title', $this->job_title])
            ->andFilterWhere(['like', 'office_no', $this->office_no])
            ->andFilterWhere(['like', 'country_dialing', $this->country_dialing])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'activation', $this->activation])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }
}
