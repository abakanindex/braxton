<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 19.09.2017
 * Time: 20:52
 */

/**
 * @var $model = app\models\registration\RegisterUserForm;
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
        <?= $form->field($model, 'username')
            ->textInput(['type' => 'email', 'placeholder' => 'Enter email'])
            ->label('Email used as login') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'repassword')->passwordInput() ?>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-user-button']) ?>
                <?php $form->end() ?>
                <?php IF (Yii::$app->session->getFlash('registerFail')): ?>
                    <div style="color: red"><?= Yii::$app->session->getFlash('registerFail') ?></div>
                <?php ENDIF ?>
            </div>
            <!-- /.col -->
        </div>
