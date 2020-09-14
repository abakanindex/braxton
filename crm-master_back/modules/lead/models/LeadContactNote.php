<?php

namespace app\modules\lead\models;

use app\models\Leads;
use app\models\User;
use Yii;

/**
 * This is the model class for table "lead_contact_note".
 *
 * @property int $id
 * @property int $lead_id
 * @property int $user_id
 * @property string $note
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Leads $lead
 * @property User $user
 */
class LeadContactNote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lead_contact_note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['note'], 'string'],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lead_id' => Yii::t('app', 'Lead ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'note' => Yii::t('app', 'Note'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
