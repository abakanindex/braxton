<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.10.2017
 * Time: 19:04
 */

namespace app\models;


use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Company;


class RegistrationForm extends Model
{
    public $username;

    public $password;

    public $repassword;

    public $email;

    public $company_name;

    public $country;

    public $employees_quantity;

    public $phone;

    public function rules()
    {
        return [

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => 'This email address has already been taken.'],

            ['company_name', 'trim'],
            ['company_name', 'required'],
            ['company_name', 'unique', 'targetClass' => 'app\models\Company', 'message' => 'Chosen company name already taken.'],
            ['company_name', 'string', 'min' => 2, 'max' => 255],

            ['country', 'required'],
            ['employees_quantity', 'integer', 'max' => 10],
            ['phone', 'required'],
            [['phone'], 'udokmeci\yii2PhoneValidator\PhoneValidator'],
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->country = $this->country;
        $user->phone_number = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateActivationKey();

        return $user->save() ? $user : null;
    }


}