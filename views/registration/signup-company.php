<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 19.09.2017
 * Time: 20:52
 */

/**
 * @var $model = app\models\RegistrationForm;
 * @var $dataProvider array;
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
        <?php $form = ActiveForm::begin(['id' => 'form-signup-user']); ?>
        <?= $form->field($model, 'company_name')->textInput(['placeholder' => 'Enter your company name please']) ?>
        <?= $form->field($model, 'employees_quantity')->dropDownList(
                $dataProvider, ['prompt' => 'Select quantity of employees'])?>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-user-button']) ?>
                <?php $form->end() ?>
            </div>
            <!-- /.col -->
        </div>
