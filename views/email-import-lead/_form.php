<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmailImportLead */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-import-lead-form">

    <?php $form = ActiveForm::begin(); ?>

    <div style="display: none"><?= $form->field($emailImportLead, 'user_id')->textInput() ?></div>

    <?= $form->field($emailImportLead, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($emailImportLead, 'imap')->textInput(['maxlength' => true]) ?>

    <?= $form->field($emailImportLead, 'port')->textInput() ?>

    <?= $form->field($emailImportLead, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
