<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<h1>email</h1>

<?php $form = ActiveForm::begin(['id' => 'mailer-form']); ?>

    <?= $form->field($modelMailer, 'fromName') ?>

    <?= $form->field($modelMailer, 'fromEmail') ?>

    <?= $form->field($modelMailer, 'toEmail') ?>

    <?= $form->field($modelMailer, 'subject') ?>

    <?= $form->field($modelMailer, 'body')->textArea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

<?php ActiveForm::end(); ?>
