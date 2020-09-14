<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Leads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'auto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Ref')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'Sub Status')->textInput(['maxlength' => true])*/ ?>

    <?= $form->field($model, 'Priority')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'Hot LeadHot')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'First Name')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Last Name')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Mobile No')->textInput(['maxlength' => true])*/ ?>

    <?= $form->field($model, 'Category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Emirate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Location')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'Sub-location')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Unit Type')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Unit No')->textInput(['maxlength' => true]) */ ?>

    <?php /*$form->field($model, 'Min Beds')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Max Beds')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Min Price')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Max Price')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Min Area')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Max Area')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Listing Ref')->textInput(['maxlength' => true])*/ ?>

    <?= $form->field($model, 'Source')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'Agent 1')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Agent 2')->textInput(['maxlength' => true]) */ ?>

    <?php /*$form->field($model, 'Agent 3')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Agent 4')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Agent 5')->textInput(['maxlength' => true])*/ ?>

    <?php /* $form->field($model, 'Created By')->textInput(['maxlength' => true])*/ ?>

    <?= $form->field($model, 'Finance')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'Enquiry Date')->textInput(['maxlength' => true])*/ ?>

    <?= $form->field($model, 'Updated')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'Agent Referrala')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Shared LeadS')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Contact Company')->textInput(['maxlength' => true])*/ ?>

    <?php /*$form->field($model, 'Email Address')->textInput(['maxlength' => true])*/ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
