<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-profile-form">
    <?php $accost_array = \yii\helpers\ArrayHelper::toArray(\app\models\UserProfileAccostSelect::find()->select(['id', 'title'])->all()) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->getId()]) ?>
    <div class="row">
        <div class="col-md-1">
            <?= $form->field($model, 'accost_id')->dropDownList(\yii\helpers\ArrayHelper::map($accost_array, 'id', 'title')) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php 

        echo '<label class="control-label">Watermark</label>';
        echo kartik\file\FileInput::widget([
            'model' => $modelImg,
            'attribute' => 'imageFiles',
            'language' => 'en',
            'options' => [
                'accept' => 'image/*',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'showPreview' => true,
                'initialPreviewAsData' => true,
                'overwriteInitial' => true,
                'showUpload' => false,
                'initialPreview' => '/web/images/img/' . $model->watermark,
                'showCaption' => false,
                'showRemove' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' => 'Select Photo',
                'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
            ]
        ]);
    ?>

    <? /*$form->field($model, 'company_id')->hiddenInput([
        'value' => \app\models\Company::findOne([
            'id' => Yii::$app->user->getId()
        ])
    ])->label(false)*/?>
    <div class="row">
        <div class="col-md-2"><?php $phone = \yii\helpers\ArrayHelper::toArray(app\models\User::find()
                ->select('phone_number')
                ->where([
                    'id' => Yii::$app->user->getId()
                ])->one()) ?>
            <?= $form->field($model, 'mobile_number')
                ->textInput([
                    'value' => $phone['phone_number']
                ]) ?>
            <?= Html::button('Add more', ['class' => 'btn btn-danger']) ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'rental_comm')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'sales_comm')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'rera_brn')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'job_title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'Department')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'office_tel')->textInput() ?>
        </div>
    </div>
    <div class="row">

        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'style' => 'margin-left: 10px']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
