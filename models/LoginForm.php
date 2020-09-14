<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    private static $_companyId;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],

            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @throws \yii\base\Exception
     */
    public function validatePassword($attribute, $params = [])
    {
        if (!$this->hasErrors()) {
            if ($this->getUser()) {
                $user = $this->getUser();
                if ($this->_user->created_at == null) {
                    $this->_user->setPassword($this->password);
                    $this->_user->generateAuthKey();
                    $this->_user->generateActivationKey();
                    $this->_user->created_at = time();
                    $this->_user->save();
                }
                if (!$user->validatePassword($this->password)) {
                    $this->addError($attribute, 'Incorrect username or password.');
                }
            } else {
                $this->addError($attribute, 'Incorrect password or username');
            }
        }
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function login()
    {
        self::$_companyId = Company::getCompanyIdBySubdomain();
        if ($this->validate()) {
            if ($this->_user->status !== 2 && $this->_user->status !== 0) {
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            } else {
                Yii::$app->controller->redirect(['login', 'status' => 2]);
            }
        }
        return false;
    }

    public static function getCompanyId()
    {
        return self::$_companyId;
    }

    /**
     * @return bool|null|static
     * @throws \yii\base\Exception
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
