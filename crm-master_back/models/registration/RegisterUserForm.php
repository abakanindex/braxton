<?php

namespace app\models\registration;

use app\modules\admin\Rbac;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use app\models\User;
use yii\helpers\Html;
use yii\swiftmailer\Mailer;
use app\models\Company;

class RegisterUserForm extends Model
{
    public $email;
    public $username;
    public $password;
    public $repassword;

    public $activation;

    private $user;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'email'],
            ['username', 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function registerUser()
    {
        if (!$this->validate()) {
             return Yii::$app->session->setFlash('registerFail', 'Email is already used');
        }
        $this->user = new User();
        $this->user->username = $this->username;
        $this->user->email = $this->username;
        $this->user->status = User::STATUS_ACTIVE;
        $this->user->company_id = Company::getCompanyIdBySubdomain();

        $this->user->setPassword($this->password);
        $this->user->generateAuthKey();
        $this->user->generateActivationKey();

        if (!$saved = $this->user->save()) {
            return null;
        } else {
          // $this->sendEmailConfirmation($this->user->email);
           return $saved;
        }
    }


    public function sendEmailConfirmation($toEmail)
    {
        $linkTo = 'http://crm/web/registration/email-confirm?activation=' . $this->user->activation;
        $mailer = new Mailer();
            return $mailer->compose()
                ->setFrom('no-reply@' . $_SERVER['SERVER_NAME'])
                ->setTo($toEmail)
                ->setSubject('crm email confirmation')
                ->setTextBody($linkTo)
                ->send();
    }

}