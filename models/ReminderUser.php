<?php

namespace app\models;

use app\models\Reminder;
use app\models\User;
use Yii;

/**
 * This is the model class for table "reminder_user".
 *
 * @property int $id
 * @property int $reminder_id
 * @property int $user_id
 * @property int $created_at
 *
 * @property Reminder $reminder
 * @property User $user
 */
class ReminderUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reminder_user';
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
            [['reminder_id', 'user_id'], 'required'],
            [['reminder_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['reminder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reminder::class, 'targetAttribute' => ['reminder_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reminder_id' => Yii::t('app', 'Reminder ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReminder()
    {
        return $this->hasOne(Reminder::class, ['id' => 'reminder_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}