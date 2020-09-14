<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property string $date
 * @property string $ref
 * @property User $user
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'user_id', 'date', 'ref'], 'required'],
            [['text'], 'string'],
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['date', 'ref'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'user_id' => Yii::t('app', 'User ID'),
            'date' => Yii::t('app', 'Date'),
            'ref' => Yii::t('app', 'Ref'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getPersonalAssistantDataProvider()
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // $query->select('*, UNIX_TIMESTAMP(deadline) as unixDeadline');
        $query->andFilterWhere(['user_id' => Yii::$app->user->id]);
        $query->andFilterWhere(['date' => date('Y-m-d')]);
        $query->orderBy('id DESC');
        $dataProvider->pagination->pageSize = 5;
        return $dataProvider;
    }

    public static function getByRef($ref)
    {
        return Note::find()->where(['ref' => $ref])->orderBy(['id' => SORT_DESC])->with('user')->all();
    }
}
