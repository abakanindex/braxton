<?php

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * ImportEmailLeads model
 *
 * @property integer $id
 * @property integer $user_id
 * @property boolean $enabled
 * @property string $imap
 * @property string $email
 * @property string $password
 * @property integer $port
 * @property integer $created_at
 * @property integer $updated_at

 */
class ImportEmailLeads extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%import_email_leads}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'enabled'=>'enabled',
            'email' => 'email',
            'imap'=>'imap',
            'password'=>'password',
            'port'=>'port'

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['email', 'email', ],

        ];
    }



}