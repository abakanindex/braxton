<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Accounts;

/**
 * AccountsSearch represents the model behind the search form of `app\models\Accounts`.
 */
class AccountsSearch extends Accounts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['user_name', 'password', 'user_role', 'first_name', 'last_name', 'email', 'mobile_number', 'job_title', 'department', 'office_tel', 'hobbies', 'mobile', 'phone', 'rera_brn', 'rental_comm', 'sales_comm', 'languages_spoken', 'status', 'avatar', 'bio', 'edit_other_managers', 'permissions', 'excel_export', 'sms_allowed', 'listing_detail', 'can_assign_leads', 'show_owner', 'delete_data', 'edit_published_listings', 'access_time', 'hr_manager', 'agent_type', 'contact_lookup_broad_search', 'user_listing_sharing', 'user_screen_settings', 'enabled', 'imap', 'import_email_leads_email', 'import_email_leads_password', 'import_email_leads_port', 'categories', 'locations'], 'safe'],
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
        $this->load($params);
        $query = Accounts::find();

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
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'user_role', $this->user_role])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'job_title', $this->job_title])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'office_tel', $this->office_tel])
            ->andFilterWhere(['like', 'hobbies', $this->hobbies])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'rera_brn', $this->rera_brn])
            ->andFilterWhere(['like', 'rental_comm', $this->rental_comm])
            ->andFilterWhere(['like', 'sales_comm', $this->sales_comm])
            ->andFilterWhere(['like', 'languages_spoken', $this->languages_spoken])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'bio', $this->bio])
            ->andFilterWhere(['like', 'edit_other_managers', $this->edit_other_managers])
            ->andFilterWhere(['like', 'permissions', $this->permissions])
            ->andFilterWhere(['like', 'excel_export', $this->excel_export])
            ->andFilterWhere(['like', 'sms_allowed', $this->sms_allowed])
            ->andFilterWhere(['like', 'listing_detail', $this->listing_detail])
            ->andFilterWhere(['like', 'can_assign_leads', $this->can_assign_leads])
            ->andFilterWhere(['like', 'show_owner', $this->show_owner])
            ->andFilterWhere(['like', 'delete_data', $this->delete_data])
            ->andFilterWhere(['like', 'edit_published_listings', $this->edit_published_listings])
            ->andFilterWhere(['like', 'access_time', $this->access_time])
            ->andFilterWhere(['like', 'hr_manager', $this->hr_manager])
            ->andFilterWhere(['like', 'agent_type', $this->agent_type])
            ->andFilterWhere(['like', 'contact_lookup_broad_search', $this->contact_lookup_broad_search])
            ->andFilterWhere(['like', 'user_listing_sharing', $this->user_listing_sharing])
            ->andFilterWhere(['like', 'user_screen_settings', $this->user_screen_settings])
            ->andFilterWhere(['like', 'enabled', $this->enabled])
            ->andFilterWhere(['like', 'imap', $this->imap])
            ->andFilterWhere(['like', 'import_email_leads_email', $this->import_email_leads_email])
            ->andFilterWhere(['like', 'import_email_leads_password', $this->import_email_leads_password])
            ->andFilterWhere(['like', 'import_email_leads_port', $this->import_email_leads_port])
            ->andFilterWhere(['like', 'categories', $this->categories])
            ->andFilterWhere(['like', 'locations', $this->locations]);

        return $dataProvider;
    }
}
