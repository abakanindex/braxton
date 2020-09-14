<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lead_viewing\models\PropertyRequirementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-requirement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'lead_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'location') ?>

    <?= $form->field($model, 'sub_location') ?>

    <?php // echo $form->field($model, 'min_beds') ?>

    <?php // echo $form->field($model, 'max_beds') ?>

    <?php // echo $form->field($model, 'min price') ?>

    <?php // echo $form->field($model, 'max price') ?>

    <?php // echo $form->field($model, 'min_area') ?>

    <?php // echo $form->field($model, 'max_area') ?>

    <?php // echo $form->field($model, 'unit_type') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
