<?php

namespace app\modules\admin\models;

use Yii;
use app\models\Company;
use app\modules\admin\models\ManageGroupChild;

/**
 * This is the model class for table "manage_group".
 *
 * @property int $id
 * @property string $group_name
 * @property string $description
 * @property string $group_owner
 * @property int $company_id
 */
class ManageGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manage_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_name'], 'string'],
            [['company_id'], 'integer'],
            [['description', 'user_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group_name'  => Yii::t('app', 'Group Name'),
            'description' => Yii::t('app', 'Description'),
            'user_id'     => Yii::t('app', 'Group Owner'),
            'company_id'  => Yii::t('app', 'Company ID'),
        ];
    }

    /**
     *
     * This method returns the first record of model 
     * 
     * @param  string $id
     * @return iterable
     */
    public function getFirstRecordModel(?string $name = null): ?iterable
    {
        $companyId = Company::getCompanyIdBySubdomain();

        if ($companyId == 'main' or $companyId == '') {
            if (!$name) {
                empty(self::find()->one()) ? $firstRecord = $this : $firstRecord = self::find()->one();
            } else {
                $firstRecord = self::findOne($name);
            }
        } else {
            if (
                Yii::$app->controller->action->id === 'manage-group'
            ) {
                self::find()->where([
                        'company_id' => $companyId
                ])->one() ?
                    $firstRecord = self::find()->where([
                        'company_id' => $companyId
                    ])->one() 
                    : $firstRecord = $this;
            } else {
                $firstRecord = self::find()->where([
                    'group_name' => $name,
                    'company_id' => $companyId
                ])->one();
            }
        }

        return $firstRecord;
    }

    /**
     * @param $model
     * @param $postData
     * @throws \yii\db\Exception
     */
    public function checkGridDataUser($model, $postData) 
    {
        $rows = [];
        ManageGroupChild::deleteAll(['group_name' => $model]);
        for ($i=0; $i < count($postData); $i++) { 
            $rows[] = [$model, $postData[$i]];
        }
        Yii::$app->db->createCommand()
        ->batchInsert(ManageGroupChild::tableName(), ManageGroupChild::attributes(), $rows)
        ->execute();
    }
}
