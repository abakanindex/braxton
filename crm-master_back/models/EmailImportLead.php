<?php

namespace app\models;

use app\modules\admin\models\EmailLeadSource;
use Yii;

/**
 * This is the model class for table "email_import_lead".
 *
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property string $imap
 * @property int $port
 * @property int $last_checked_uid
 * @property string $status
 * @property string $password
 *
 * @property Leads $lead
 */
class EmailImportLead extends \yii\db\ActiveRecord
{

    const UPDATE_INTERVAL_SECONDS = 60 * 60;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_import_lead';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'email', 'imap'], 'required'],
            //[['imap'], 'checkImap'],
            [['user_id', 'port'], 'integer'],
            [['email'], 'email'],
            [['password'], 'string'],
            [['last_checked_uid'], 'safe'],
            [['email', 'imap'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function checkImap($attribute_name, $params)
    {
        $inbox = imap_open('{' . $this->imap . (($this->port) ? ':' . $this->port : "") . '/imap/ssl}', $this->email, $this->password);
        if (!$inbox) {
            $this->addError($attribute_name, Yii::t('app', 'Couldn\'t connect to your imap server. Check your fields.'));
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'email' => Yii::t('app', 'Email'),
            'imap' => Yii::t('app', 'Imap'),
            'port' => Yii::t('app', 'Port'),
            'status' => Yii::t('app', 'Status'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getExistRow($email, $imap, $userId)
    {
        return EmailImportLead::findOne([
            'email'   => $email,
            'imap'    => $imap,
            'user_id' => $userId
        ]);
    }

}
