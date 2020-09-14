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

    <?= $form->field($model, 'reference') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'sub_status_id') ?>

    <?= $form->field($model, 'priority') ?>

    <?php // echo $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'mobile_number') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'sub_location') ?>

    <?php // echo $form->field($model, 'unit_type') ?>

    <?php // echo $form->field($model, 'unit_number') ?>

    <?php // echo $form->field($model, 'beds') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'source_id') ?>

    <?php // echo $form->field($model, 'created_by_user_id') ?>

    <?php // echo $form->field($model, 'company_id') ?>

    <?php // echo $form->field($model, 'finance_type') ?>

    <?php // echo $form->field($model, 'enquiry_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'contract_company') ?>

    <?php // echo $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
