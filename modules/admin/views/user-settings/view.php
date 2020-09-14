<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="user-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary'])
            ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'first_name',
                'last_name',
                'job_title',
                'office_no',
                'mobile_no',
                'email:email',
                'authAssignment.item_name',
                'userStatus.title',
                'companyName.company_name',
            ],
        ]) ?>

    </div>

    <div class="email-import-lead-form">
        <h3><?= Yii::t('app', 'Email Import Lead') ?></h3>
        <?php
        if ($emailImportLead->isNewRecord)
            $emailImportLeadActionUrl = Url::to(['/email-import-lead/create']);
        else
            $emailImportLeadActionUrl = Url::to(['/email-import-lead/update', 'id' => $emailImportLead->id]);
        $form = ActiveForm::begin([
            'id' => 'email-import-lead-form',
            'action' => $emailImportLeadActionUrl,
            'enableAjaxValidation' => true,
            'validationUrl' => ['/email-import-lead/validate'],
        ]); ?>

        <div style="display: none"><?= $form->field($emailImportLead, 'user_id')->textInput() ?></div>

        <?= $form->field($emailImportLead, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($emailImportLead, 'imap')->textInput(['maxlength' => true]) ?>

        <?= $form->field($emailImportLead, 'port')->textInput(['value' => '']) ?>

        <!--<input type="password" style="display:none" name="EmailImportLead[password]">-->

        <?= $form->field($emailImportLead, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

        <?= $form->field($emailImportLead, 'status')->dropDownList([
            1 => Yii::t('app', 'Enabled'),
            2 => Yii::t('app', 'Disabled'),
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('<span>' . Yii::t('app', 'Save') . '</span>', ['class' => 'btn btn-success save-imap-parameters-btn']) ?>
        </div>

        <?php ActiveForm::end(); ?>
<?php // echo  Html::a('Check emails', ['/email-import-lead/check'], ['class'=>'btn btn-primary', 'id'=>'check-mails']) ?>
    </div>
<?php
$emailImportValidationUrl = Url::to(['/email-import-lead/validate']);
$emailImportSavedMessage = Yii::t('app', 'Email Import Lead Settings saved');
$checkEmailUrl = Url::to(['/email-import-lead/check']);
$pleaseWaitText = Yii::t('app', 'Please wait');
$saveText = Yii::t('app', 'Save');
$script = <<< JS

    /*$('#check-mails').on('click', function() {
        $.post("$checkEmailUrl", function(data, status){
            console.log("Data: " + data + "Status: " + status);
        });  
        return false;
    })*/

    var saveImapParametersBtn = $('.save-imap-parameters-btn');

    $('body').on('beforeValidate', 'form#email-import-lead-form', function () {
        saveImapParametersBtn.find('span').text('$pleaseWaitText...');
        saveImapParametersBtn.prop("disabled", true);
        return true;
    }); 

    $('body').on('afterValidate', 'form#email-import-lead-form', function () {
        saveImapParametersBtn.find('span').text('$saveText');
        saveImapParametersBtn.prop("disabled", false);
        return true;
    }); 

    $('body').on('beforeSubmit', 'form#email-import-lead-form', function () {
         var form = $(this);
         if (form.find('.has-error').length) {
              return false;
         } 
         $.ajax({
              url: form.attr('action'),
              type: 'post',
              data: form.serialize(),
              success: function (response) {
                if(response.result == 'success') {
                    bootbox.confirm('$emailImportSavedMessage', function(result) {
                        if (result) { } 
                    }); 
                }
              }
         });   
         return false;
    }); 
JS;
$this->registerJs($script, yii\web\View::POS_READY);

