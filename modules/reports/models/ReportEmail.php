<?php

namespace app\modules\reports\models;

use app\models\User;
use kartik\mpdf\Pdf;
use rudissaar\fpdf\FPDF;
use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property string $to
 * @property string $cc
 * @property string $bcc
 * @property string $subject
 * @property string $message
 * @property int $attach
 * @property int $report_id
 * @property int $user_id
 * @property int $created_at
 *
 * @property User $user
 * @property Report $report
 */
class ReportEmail extends \yii\db\ActiveRecord
{
    public $from;
    public $cc;
    public $bcc;


    public static function tableName()
    {
        return 'report_email';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['to', 'attach', 'subject', 'message', 'report_id', 'user_id', 'created_at'], 'required'],
            [['subject', 'message'], 'string'],
            ['to', 'email'],
            [['report_id', 'user_id', 'created_at'], 'integer'],
            [['cc', 'bcc'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public static function getDefaultEmailMessage($report, $user)
    {
        $message = Yii::t('app', 'Hello') . ",";
        $message .= "\n\n";
        $message .= Yii::t('app', 'Please find attached the report summary for');
        $message .= " " . $report->name;
        $message .= "\n\n";
        $message .= Yii::t('app', 'Regards');
        $message .= ", " . $user->userProfile->first_name . " " . $user->userProfile->last_name;
        return $message;
    }

    public function sendReportEmail($path)
    {
        $mail = Yii::$app->mailer->compose()
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setSubject($this->subject)
            ->setTextBody($this->message);
        if (!empty($this->cc))
            $mail->setCc($this->cc);
        if (!empty($this->bcc))
            $mail->setBcc($this->bcc);
        if ($this->attach) {
            $mail->attach($path, [
                'fileName'    => 'Summary.pdf',
            ]);
        }
        return $mail->send();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Reports::className(), ['id' => 'report_id']);
    }

    public function generateUniqueRandomString($attribute, $length = 32)
    {

        $randomString = Yii::$app->getSecurity()->generateRandomString($length);

        if (!$this->findOne([$attribute => $randomString]))
            return $randomString;
        else
            return $this->generateUniqueRandomString($attribute, $length);

    }

}
