<?php

namespace app\modules\lead_viewing\models;

use app\models\Leads;
use app\models\Reminder;
use app\models\User;
use app\modules\calendar\models\Event;
use app\modules\calendar\models\EventType;
use codeonyii\yii2validators\AtLeastValidator;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "lead_viewing".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lead_id
 * @property int $time
 * @property int $created_at
 * @property string $leadReference
 *
 * @property Leads $lead
 * @property User $user
 */
class LeadViewing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lead_viewing';
    }

    public $leadViewingSales;
    public $leadViewingRentals;
    public $leadReference;
    public $property;

    const ACTION_CREATE = 1;
    const ACTION_UPDATE = 2;

    const SCENARIO_CREATE_UPDATE = 'change-event';
    const SCENARIO_REPORT = 'repeat';

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->time = strtotime($this->time);
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->scenario == self::SCENARIO_CREATE_UPDATE) {
            LeadViewingProperty::deleteAll(['lead_viewing_id' => $this->id]);
            $leadViewingSales = explode(",", $this->leadViewingSales);
            $leadViewingRentals = explode(",", $this->leadViewingRentals);
            foreach ($leadViewingSales as $leadViewingSale) {
                $leadViewinProperty = new LeadViewingProperty();
                $leadViewinProperty->type = LeadViewingProperty::TYPE_SALE;
                $leadViewinProperty->property_id = $leadViewingSale;
                $leadViewinProperty->lead_viewing_id = $this->id;
                $leadViewinProperty->save();
            }
            foreach ($leadViewingRentals as $leadViewingRental) {
                $leadViewinProperty = new LeadViewingProperty();
                $leadViewinProperty->type = LeadViewingProperty::TYPE_RENTALS;
                $leadViewinProperty->property_id = $leadViewingRental;
                $leadViewinProperty->lead_viewing_id = $this->id;
                $leadViewinProperty->save();
            }

            Event::deleteAll(['lead_viewing_id' => $this->id]);
            $model = new Event();
            $model->start = $this->time;
            $model->end = $this->time;
            $model->owner_id = Yii::$app->user->id;
            $model->created_at = time();
            $model->type = EventType::findOne(['name' => 'Lead Viewings'])->id;
            $model->lead_viewing_id = $this->id;
            $model->save();

            Reminder::deleteAll(['user_id' => Yii::$app->user->id, 'key_id' => $this->id, 'key' => Reminder::KEY_TYPE_LEAD_VIEWING_REPORT]);
            $reminder = new Reminder();
            $reminder->user_id = Yii::$app->user->id;
            $reminder->key_id = $this->id;
            $reminder->interval_type = Reminder::INTERVAL_TYPE_DAYS;
            $reminder->created_at = time();
            $reminder->send_type = Reminder::SEND_TYPE_WEBSITE;
            $reminder->status = Reminder::STATUS_ACTIVE;
            $reminder->key = Reminder::KEY_TYPE_LEAD_VIEWING_REPORT;
            $reminder->notification_time_from = strtotime(' +1 day -2 minutes', $model->start);
            $reminder->time = 1;
            $reminder->save();
        }
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REPORT] = ['report', 'created_at', 'user_id', 'lead_id'];
        $scenarios[self::SCENARIO_CREATE_UPDATE] = ['property', 'leadViewingSales', 'leadViewingRentals', 'created_at', 'leadReference', 'time', 'user_id', 'lead_id', 'leadReference', 'leadViewingSales', 'leadViewingRentals', 'property'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'lead_id', 'time', 'created_at'], 'required'],
            [['leadReference'], 'required', 'message' => Yii::t('app', 'Please add lead')],
            [['user_id', 'lead_id', 'created_at'], 'integer'],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['leadViewingSales', 'leadViewingRentals'], 'safe'],
            [['property'], 'safe'],
            [['report'], 'safe'],
            ['property', AtLeastValidator::className(), 'in' => ['leadViewingSales', 'leadViewingRentals'], 'message' => 'Choose sales or rentals'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'lead_id' => Yii::t('app', 'Lead ID'),
            'time' => Yii::t('app', 'Time'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSales()
    {
        return $this->hasMany(LeadViewingProperty::className(), ['lead_viewing_id' => 'id'])
            ->where(['type' => LeadViewingProperty::TYPE_SALE]);
    }

    public function getRentals()
    {
        return $this->hasMany(LeadViewingProperty::className(), ['lead_viewing_id' => 'id'])
            ->where(['type' => LeadViewingProperty::TYPE_RENTALS]);
    }

    public static function getPersonalAssistantDataProvider()
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere(['user_id' => Yii::$app->user->id]);
        $query->andFilterWhere(['>', 'time', time()]);
        $query->orderBy('time ASC');
        $dataProvider->pagination->pageSize = 5;
        return $dataProvider;
    }

}
