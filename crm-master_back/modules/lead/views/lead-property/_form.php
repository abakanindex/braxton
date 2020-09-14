<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lead\models\LeadProperty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lead-property-form">

    <?php $form = ActiveForm::begin([
        'id' => 'property-requirement-form'
    ]); ?>

    <?= $form->field($model, 'lead_id')->textInput() ?>

    <?= $form->field($model, 'property_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
