<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contacts;
use app\models\Company;
use app\modules\admin\models\OwnerManageGroup;

/**
 * ContactsSearch represents the model behind the search form of `app\models\Contacts`.
 */
class ContactsSearch extends Contacts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['ref', 'gender', 'first_name', 'last_name', 'home_address_1', 'home_address_2', 'home_city', 'home_state', 'home_country', 'home_zip_code', 'personal_phone', 'work_phone', 'home_fax', 'home_po_box', 'personal_mobile', 'personal_email', 'work_email', 'date_of_birth', 'designation', 'nationality', 'religion', 'title', 'work_mobile', 'assigned_to', 'updated', 'other_phone', 'other_mobile', 'work_fax', 'other_fax', 'other_email', 'website', 'facebook', 'twitter', 'linkedin', 'google', 'instagram', 'wechat', 'skype', 'company_po_box', 'company_address_1', 'company_address_2', 'company_city', 'company_state', 'company_country', 'company_zip_code', 'native_language', 'second_language', 'contact_source', 'contact_type', 'created_date', 'created_by', 'type', 'postal_code', 'po_box'], 'safe'],
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
    public function search($params, $status = false)
    {
        $this->load($params);

        $companyId = Company::getCompanyIdBySubdomain(); 
        if ($companyId == 'main' or $companyId == 0) {
            $query = Contacts::find();
        } else {   
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = Contacts::find()->where([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = Contacts::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = Contacts::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by' => Yii::$app->user->id]);
                }
            }
        }

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $query->alias('c');
        $query->andFilterWhere(['like', 'c.ref', $this->ref])
            ->andFilterWhere(['=', 'c.gender', $this->gender])
            ->andFilterWhere(['like', 'c.first_name', $this->first_name])
            ->andFilterWhere(['like', 'c.last_name', $this->last_name])
            ->andFilterWhere(['like', 'c.home_address_1', $this->home_address_1])
            ->andFilterWhere(['like', 'c.home_address_2', $this->home_address_2])
            ->andFilterWhere(['like', 'c.home_city', $this->home_city])
            ->andFilterWhere(['like', 'c.home_state', $this->home_state])
            ->andFilterWhere(['like', 'c.home_country', $this->home_country])
            ->andFilterWhere(['like', 'c.home_zip_code', $this->home_zip_code])
            ->andFilterWhere(['like', 'c.personal_phone', $this->personal_phone])
            ->andFilterWhere(['like', 'c.work_phone', $this->work_phone])
            ->andFilterWhere(['like', 'c.home_fax', $this->home_fax])
            ->andFilterWhere(['like', 'c.home_po_box', $this->home_po_box])
            ->andFilterWhere(['like', 'c.personal_mobile', $this->personal_mobile])
            ->andFilterWhere(['like', 'c.personal_email', $this->personal_email])
            ->andFilterWhere(['like', 'c.work_email', $this->work_email])
            ->andFilterWhere(['like', 'c.date_of_birth', $this->date_of_birth])
            ->andFilterWhere(['like', 'c.designation', $this->designation])
            ->andFilterWhere(['=', 'c.nationality', $this->nationality])
            ->andFilterWhere(['=', 'c.religion', $this->religion])
            ->andFilterWhere(['=', 'c.title', $this->title])
            ->andFilterWhere(['like', 'c.work_mobile', $this->work_mobile])
            ->andFilterWhere(['=', 'c.assigned_to', $this->assigned_to])
            ->andFilterWhere(['=', 'c.updated', $this->updated])
            ->andFilterWhere(['like', 'c.other_phone', $this->other_phone])
            ->andFilterWhere(['like', 'c.other_mobile', $this->other_mobile])
            ->andFilterWhere(['like', 'c.work_fax', $this->work_fax])
            ->andFilterWhere(['like', 'c.other_fax', $this->other_fax])
            ->andFilterWhere(['like', 'c.other_email', $this->other_email])
            ->andFilterWhere(['like', 'c.website', $this->website])
            ->andFilterWhere(['like', 'c.facebook', $this->facebook])
            ->andFilterWhere(['like', 'c.twitter', $this->twitter])
            ->andFilterWhere(['like', 'c.linkedin', $this->linkedin])
            ->andFilterWhere(['like', 'c.google', $this->google])
            ->andFilterWhere(['like', 'c.instagram', $this->instagram])
            ->andFilterWhere(['like', 'c.wechat', $this->wechat])
            ->andFilterWhere(['like', 'c.skype', $this->skype])
            ->andFilterWhere(['like', 'c.company_po_box', $this->company_po_box])
            ->andFilterWhere(['like', 'c.company_address_1', $this->company_address_1])
            ->andFilterWhere(['like', 'c.company_address_2', $this->company_address_2])
            ->andFilterWhere(['like', 'c.company_city', $this->company_city])
            ->andFilterWhere(['like', 'c.company_state', $this->company_state])
            ->andFilterWhere(['like', 'c.company_country', $this->company_country])
            ->andFilterWhere(['like', 'c.company_zip_code', $this->company_zip_code])
            ->andFilterWhere(['like', 'c.native_language', $this->native_language])
            ->andFilterWhere(['like', 'c.second_language', $this->second_language])
            ->andFilterWhere(['like', 'c.contact_source', $this->contact_source])
            ->andFilterWhere(['=', 'c.contact_type', $this->contact_type])
            ->andFilterWhere(['like', 'c.created_date', $this->created_date])
            ->andFilterWhere(['=', 'c.created_by', $this->created_by])
            ->andFilterWhere(['=', 'c.type', $this->type])
            ->andFilterWhere(['=', 'c.status', ($status) ? $status : $this->status])
            ->andFilterWhere(['like', 'c.postal_code', $this->postal_code])
            ->andFilterWhere(['like', 'c.po_box', $this->po_box])
        ;

        return $dataProvider;
    }
}
