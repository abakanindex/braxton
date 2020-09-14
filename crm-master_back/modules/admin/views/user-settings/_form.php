<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->textInput() ?>
        <?= $form->field($model, 'first_name')->textInput() ?>
        <?= $form->field($model, 'last_name')->textInput() ?>
        <?= $form->field($model, 'job_title')->textInput(['disabled' => true]) ?>
        <?= $form->field($model, 'office_no')->textInput() ?>
        <?= $form->field($model, 'mobile_no')->textInput() ?>
        <?= $form->field($model, 'country_dialing')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'status')->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\UserStatus::find()->all(),'id', 'title')
        ) ?>
        <?= $form->field($model, 'role')->dropDownList(
                \yii\helpers\ArrayHelper::map(\app\models\admin\rights\AuthItem::find()->where(['type' => 1])->all(),
                        'name', 'name'
                )) ?>
        <?= $form->field($model, 'company_id')->hiddenInput(
                ['value' => \app\models\Company::getCompanyIdBySubdomain()])->label('')
        ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
