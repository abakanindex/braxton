<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaskManager;
use app\models\Company;
use app\modules\admin\models\OwnerManageGroup;

/**
 * TaskManagerSearch represents the model behind the search form of `app\models\TaskManager`.
 */
class TaskManagerSearch extends TaskManager
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id'], 'integer'],
//            [['title', 'description', 'responsible', 'deadline', 'remind', 'repeat'], 'safe'],
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
        $query = self::getQueryByCompanyRolesGroups();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'responsible', $this->responsible])
            ->andFilterWhere(['like', 'deadline', $this->deadline])
            ->andFilterWhere(['like', 'remind', $this->remind])
            ->andFilterWhere(['like', 'repeat', $this->repeat]);



        return $dataProvider;
    }

    /**
     * @return $this|\yii\db\ActiveQuery
     */
    public static function getQueryByCompanyRolesGroups()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = TaskManager::find();
        } else {
            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = TaskManager::find()->where([
                    'company_id' => $companyId
                ]);
            } elseif((new OwnerManageGroup())->getViewsByGroup()) {
                $query = TaskManager::find()
                    ->joinWith('responsibleUsers')
                    ->where(['company_id' => $companyId])
                    ->andWhere(['or',
                        ['owner_id' => (new OwnerManageGroup())->getViewsByGroup()],
                        ['user_id' => Yii::$app->user->id]
                    ]);
            } else {
                $query = TaskManager::find()
                    ->joinWith('responsibleUsers')
                    ->where(['company_id' => $companyId])
                    ->andWhere(['or',
                        ['owner_id' => Yii::$app->user->id],
                        ['user_id' => Yii::$app->user->id]
                    ]);
            }
        }

        return $query;
    }
}
