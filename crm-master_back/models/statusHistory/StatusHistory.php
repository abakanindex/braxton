<?php

namespace app\models\statusHistory;

use Yii;

/**
 * This is the model class for table "status_history".
 *
 * @property int $id
 * @property string $time_change
 * @property string $name_model
 * @property string $history_fields
 * @property int $parent_id
 */
class StatusHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_change'], 'safe'],
            [['history_fields'], 'string'],
            [['parent_id'], 'integer'],
            [['name_model'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'time_change'    => Yii::t('app', 'Time Change'),
            'name_model'     => Yii::t('app', 'Name Model'),
            'history_fields' => Yii::t('app', 'History Fields'),
            'parent_id'      => Yii::t('app', 'Parent ID'),
        ];
    }

}
