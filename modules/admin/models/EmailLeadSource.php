<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "email_lead_source".
 *
 * @property int $id
 * @property string $email
 */
class EmailLeadSource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_lead_source';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['email'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
        ];
    }
}
