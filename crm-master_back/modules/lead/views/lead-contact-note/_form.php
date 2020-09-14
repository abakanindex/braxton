<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lead\models\LeadContactNote */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lead-contact-note-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <div style="display: none">
        <?= $form->field($model, 'user_id')->textInput() ?>
        <?= $form->field($model, 'created_at')->textInput() ?>
        <?= $form->field($model, 'updated_at')->textInput() ?>
        <?= $form->field($model, 'lead_id')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
