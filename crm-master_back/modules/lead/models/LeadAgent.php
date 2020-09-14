<?php

namespace app\modules\lead\models;

use app\models\Leads;
use app\models\User;
use Yii;

/**
 * This is the model class for table "lead_agent".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $user_id
 * @property int $created_at
 *
 * @property Leads $lead
 * @property User $user
 */
class LeadAgent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_agent';
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->created_at = time();
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lead_id', 'user_id'], 'required'],
            [['lead_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lead_id' => Yii::t('app', 'Lead ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
