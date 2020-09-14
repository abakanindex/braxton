<?php

namespace app\modules\lead\models;

use app\models\Company;
use Yii;

/**
 * This is the model class for table "company_source".
 *
 * @property int $id
 * @property string $title
 * @property int $company_id
 * @property int $order
 *
 * @property User $user
 * @property Leads[] $leads
 */
class CompanySource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_source';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'company_id', 'order'], 'required'],
            [['company_id', 'order'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['order'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'company_id' => Yii::t('app', 'User ID'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeads()
    {
        return $this->hasMany(Leads::className(), ['source_id' => 'id']);
    }
}
