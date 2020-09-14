<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 19.09.2017
 * Time: 20:52
 */

/**
 * @var $model = app\models\RegistrationForm;
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Country;


?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>SystaVision</b>CRM</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Fill in the fields below to register</p>
        <?php $countryActiveRecord = Country::find()->select(['en', 'country_id'])->orderBy('en')->all() ?>
        <?php $countries = \yii\helpers\ArrayHelper::map($countryActiveRecord, 'country_id', 'en'); ?>
        <?php $company = new \app\models\Company() ?>
        <?php $employeesArray = [
            1 => '1 - 10',
            2 => '11 - 50',
            3 => '51 - 100',
            4 => '101 - 500',
            5 => 'more then 500',
        ]; ?>
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <?= $form
            ->field($model, 'username')
            ->textInput(['autofocus' => true, 'placeholder' => 'My Name Is John']) ?>
        <?= $form
            ->field($model, 'email') ?>
        <?= $form
            ->field($model, 'password')
            ->passwordInput() ?>
        <?= $form
            ->field($model, 'repassword')
            ->passwordInput()
            ->label('Confirm your password') ?>
        <?= $form
            ->field($model, 'phone')
            ->textInput(['placeholder' => '+35468794315'])
            ->label('Please enter your phone number') ?>
        <?= $form
            ->field($model, 'country')
            ->dropDownList($countries, ['propmpt' => 'Select country'])
            ->label('Select country') ?>
        <?= $form
            ->field($model, 'company_name')
            ->textInput(['placeholder' => 'My company call is MyCompany inc.'])
            ->label('Enter your company name') ?>
        <?= $form
            ->field($model, 'employees_quantity')
            ->dropDownList($employeesArray)
            ->label('How much employees in your company?') ?>


        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- /.col -->
        </div>
