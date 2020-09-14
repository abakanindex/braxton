<?php

namespace app\modules\deals\models;

use yii\db\ActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;
use app\interfaces\firstrecordmodel\IfirstRecordModel;
use yii\behaviors\SluggableBehavior;
use app\models\statusHistory\ArchiveHistory;
use app\models\Company;
use app\models\User;
use app\models\reference_books\PropertyCategory;
use app\models\reference_books\ContactSource;
use app\modules\admin\models\OwnerManageGroup;
use yii\db\Query;

/**
 * This is the model class for table "templates".
 *
 * @property int $id
 * @property int $type
 * @property string $content
 * @property string $title
 * @property int $created_at
 * @property int $created_by
 * @property int $company_id
 * @property int $updated_at
 */

class Templates extends ActiveRecord implements IfirstRecordModel
{
    const TYPE_INVOICE = 1;
    const TYPE_RECEIPT = 2;
    const TYPE_INVOICE_NEW = 3;
    const TYPE_RECEIPT_NEW = 4;
    const TYPE_TENANCY_CONTRACT = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'templates';
    }

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
                    'created_by',
                    'type',
                    'content',
                    'title',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'company_id',
                ], 'safe'
            ],

        ];
    }

    /**
     * {@inheritdoc}
     * @param $insert
     * @return void
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (Yii::$app->controller->action->id === 'update') {
                $archive = new ArchiveHistory(self::findOne($this->id));
                $archive->addArchiveProperty(
                    $this->getDirtyAttributes(),
                    $this->getOldAttributes()
                );
            }
            return true;
        }
        return false;
    }

    /**
     *
     * This method returns the first record of model Templates
     *
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $id = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$id) {
                $checkRecord = self::find()->one();
                empty($checkRecord) ? $firstRecord = $this : $firstRecord = $checkRecord;
            } else {
                $firstRecord = self::find()->where([
                    'id'         => $id
                ])->one();
            }
        } else {
            $viewsByGroup = (new OwnerManageGroup())->getViewsByGroup();
            if ($viewsByGroup) {
                if (Yii::$app->controller->action->id === 'index') {
                    $checkRecord = self::find()->where([
                        'company_id' => $companyId,
                        'created_by'    => $viewsByGroup
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                } else {
                    $checkRecord = self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                }
            } else {
                if (Yii::$app->controller->action->id === 'index') {
                    $checkRecord = self::find()->where([
                        'company_id' => $companyId,
                        'created_by'    => Yii::$app->user->id
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                } else {
                    $checkRecord = self::find()->where([
                        'id'         => $id,
                        'company_id' => $companyId
                    ])->one();
                    $firstRecord = $checkRecord ? $checkRecord : $this;
                }
            }
        }

        return $firstRecord;
    }

    /**
     * @return array
     */
    public static function getTypes() : array
    {
        $types[self::TYPE_INVOICE]          = Yii::t('app', 'Invoice');
        $types[self::TYPE_RECEIPT]          = Yii::t('app', 'Receipt');
        $types[self::TYPE_INVOICE_NEW]      = Yii::t('app', 'Invoice New');
        $types[self::TYPE_RECEIPT_NEW]      = Yii::t('app', 'Receipt New');
        $types[self::TYPE_TENANCY_CONTRACT] = Yii::t('app', 'Tenancy Contract');
        return $types;
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
    private function getCompanyQuery()
    {
        $companyId = Company::getCompanyIdBySubdomain();
        if ($companyId == 'main' or $companyId == 0) {
            $query = self::find();
        } else {
//            $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            if (yii::$app->user->can('Admin') or yii::$app->user->can('Owner')) {
                $query = self::find()->where([
                    'company_id' => $companyId
                ]);
            } else {
                if ((new OwnerManageGroup())->getViewsByGroup()) {

                    $query = self::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by' => (new OwnerManageGroup())->getViewsByGroup()]);

                } else {
                    $query = self::find()->where([
                        'company_id' => $companyId
                    ])->andWhere(['created_by' => Yii::$app->user->id]);
                }
            }
        }

        $query->alias('t');
        return $query;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}