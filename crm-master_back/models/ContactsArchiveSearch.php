<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ContactsArchive;
use app\modules\admin\models\OwnerManageGroup;


/**
 * ContactsArchiveSearch represents the model behind the search form of `app\models\ContactsArchive`.
 */
class ContactsArchiveSearch extends ContactsArchive
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['ref', 'gender', 'first_name', 'last_name', 'home_address_1', 'home_address_2', 'home_city', 'home_state', 'home_country', 'home_zip_code', 'personal_phone', 'work_phone', 'home_fax', 'home_po_box', 'personal_mobile', 'personal_email', 'work_email', 'date_of_birth', 'designation', 'nationality', 'religion', 'title', 'work_mobile', 'assigned_to', 'updated', 'other_phone', 'other_mobile', 'work_fax', 'other_fax', 'other_email', 'website', 'facebook', 'twitter', 'linkedin', 'google', 'instagram', 'wechat', 'skype', 'company_po_box', 'company_address_1', 'company_address_2', 'company_city', 'company_state', 'company_country', 'company_zip_code', 'native_language', 'second_language', 'contact_source', 'contact_type', 'created_date', 'created_by', 'type'], 'safe'],
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

        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = ContactsArchive::find();
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = ContactsArchive::find()->where([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = ContactsArchive::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = ContactsArchive::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by' => Yii::$app->user->id]);
                }
            }
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

        $query->andFilterWhere(['like', 'ref', $this->ref])
            ->andFilterWhere(['=', 'gender', $this->gender])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'home_address_1', $this->home_address_1])
            ->andFilterWhere(['like', 'home_address_2', $this->home_address_2])
            ->andFilterWhere(['like', 'home_city', $this->home_city])
            ->andFilterWhere(['like', 'home_state', $this->home_state])
            ->andFilterWhere(['like', 'home_country', $this->home_country])
            ->andFilterWhere(['like', 'home_zip_code', $this->home_zip_code])
            ->andFilterWhere(['like', 'personal_phone', $this->personal_phone])
            ->andFilterWhere(['like', 'work_phone', $this->work_phone])
            ->andFilterWhere(['like', 'home_fax', $this->home_fax])
            ->andFilterWhere(['like', 'home_po_box', $this->home_po_box])
            ->andFilterWhere(['like', 'personal_mobile', $this->personal_mobile])
            ->andFilterWhere(['like', 'personal_email', $this->personal_email])
            ->andFilterWhere(['like', 'work_email', $this->work_email])
            ->andFilterWhere(['=', 'date_of_birth', $this->date_of_birth])
            ->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['=', 'nationality', $this->nationality])
            ->andFilterWhere(['=', 'religion', $this->religion])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'work_mobile', $this->work_mobile])
            ->andFilterWhere(['=', 'assigned_to', $this->assigned_to])
            ->andFilterWhere(['=', 'updated', $this->updated])
            ->andFilterWhere(['like', 'other_phone', $this->other_phone])
            ->andFilterWhere(['like', 'other_mobile', $this->other_mobile])
            ->andFilterWhere(['like', 'work_fax', $this->work_fax])
            ->andFilterWhere(['like', 'other_fax', $this->other_fax])
            ->andFilterWhere(['like', 'other_email', $this->other_email])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'linkedin', $this->linkedin])
            ->andFilterWhere(['like', 'google', $this->google])
            ->andFilterWhere(['like', 'instagram', $this->instagram])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'company_po_box', $this->company_po_box])
            ->andFilterWhere(['like', 'company_address_1', $this->company_address_1])
            ->andFilterWhere(['like', 'company_address_2', $this->company_address_2])
            ->andFilterWhere(['like', 'company_city', $this->company_city])
            ->andFilterWhere(['like', 'company_state', $this->company_state])
            ->andFilterWhere(['like', 'company_country', $this->company_country])
            ->andFilterWhere(['like', 'company_zip_code', $this->company_zip_code])
            ->andFilterWhere(['like', 'native_language', $this->native_language])
            ->andFilterWhere(['like', 'second_language', $this->second_language])
            ->andFilterWhere(['like', 'contact_source', $this->contact_source])
            ->andFilterWhere(['like', 'contact_type', $this->contact_type])
            ->andFilterWhere(['like', 'created_date', $this->created_date])
            ->andFilterWhere(['=', 'created_by', $this->created_by])
            ->andFilterWhere(['=', 'type', $this->type]);

        return $dataProvider;
    }
}
