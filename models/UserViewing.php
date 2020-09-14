<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_viewing".
 *
 * @property int $id
 * @property int $type
 * @property int $user_id
 * @property int $created_at
 * @property int $model_id
 * @property string $reportName
 * @property string $reportUrl
 *
 * @property User $user
 */
class UserViewing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_viewing';
    }

    public $reportName;
    public $reportUrl;

    const TYPE_SALE = 1;
    const TYPE_RENTAL = 2;
    const TYPE_LEAD = 3;
    const TYPE_REPORT = 4;

    public static $types = [
        self::TYPE_SALE,
        self::TYPE_RENTAL,
        self::TYPE_LEAD,
        self::TYPE_REPORT
    ];

    public static function getTypeTitle($type)
    {
        switch ($type) {
            case self::TYPE_SALE:
                return Yii::t('app', 'Sale');
            case self::TYPE_RENTAL:
                return Yii::t('app', 'Rental');
            case self::TYPE_LEAD:
                return Yii::t('app', 'Lead');
            case self::TYPE_REPORT:
                return Yii::t('app', 'Report');
        }
    }

    public static function getTypeArray()
    {
        $types = [];
        foreach (self::$types as $type) {
            $types[$type] = self::getTypeTitle($type);
        }
        return $types;
    }

    public static function create($type, $id)
    {
        $class = self::class;
        $view = new $class();
        $view->type = $type;
        $view->user_id = Yii::$app->user->id;
        $view->created_at = time();
        $view->model_id = $id;
        return $view->save();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'model_id', 'created_at'], 'required'],
            [['type', 'user_id', 'created_at', 'model_id'], 'integer'],
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
            'type' => Yii::t('app', 'Type'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Last Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
