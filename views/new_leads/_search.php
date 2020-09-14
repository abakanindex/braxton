<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LeadsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leads-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'auto') ?>

    <?= $form->field($model, 'Ref') ?>

    <?= $form->field($model, 'Type') ?>

    <?= $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'Sub Status') ?>

    <?php // echo $form->field($model, 'Priority') ?>

    <?php // echo $form->field($model, 'Hot LeadHot') ?>

    <?php // echo $form->field($model, 'First Name') ?>

    <?php // echo $form->field($model, 'Last Name') ?>

    <?php // echo $form->field($model, 'Mobile No') ?>

    <?php // echo $form->field($model, 'Category') ?>

    <?php // echo $form->field($model, 'Emirate') ?>

    <?php // echo $form->field($model, 'Location') ?>

    <?php // echo $form->field($model, 'Sub-location') ?>

    <?php // echo $form->field($model, 'Unit Type') ?>

    <?php // echo $form->field($model, 'Unit No') ?>

    <?php // echo $form->field($model, 'Min Beds') ?>

    <?php // echo $form->field($model, 'Max Beds') ?>

    <?php // echo $form->field($model, 'Min Price') ?>

    <?php // echo $form->field($model, 'Max Price') ?>

    <?php // echo $form->field($model, 'Min Area') ?>

    <?php // echo $form->field($model, 'Max Area') ?>

    <?php // echo $form->field($model, 'Listing Ref') ?>

    <?php // echo $form->field($model, 'Source') ?>

    <?php // echo $form->field($model, 'Agent 1') ?>

    <?php // echo $form->field($model, 'Agent 2') ?>

    <?php // echo $form->field($model, 'Agent 3') ?>

    <?php // echo $form->field($model, 'Agent 4') ?>

    <?php // echo $form->field($model, 'Agent 5') ?>

    <?php // echo $form->field($model, 'Created By') ?>

    <?php // echo $form->field($model, 'Finance') ?>

    <?php // echo $form->field($model, 'Enquiry Date') ?>

    <?php // echo $form->field($model, 'Updated') ?>

    <?php // echo $form->field($model, 'Agent Referrala') ?>

    <?php // echo $form->field($model, 'Shared LeadS') ?>

    <?php // echo $form->field($model, 'Contact Company') ?>

    <?php // echo $form->field($model, 'Email Address') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
