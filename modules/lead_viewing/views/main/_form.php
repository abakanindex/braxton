<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lead_viewing\models\LeadViewing */
/* @var $form ActiveForm */
?>
<div class="app-modules-lead_viewiing-views-main-_form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'lead_id') ?>
        <?= $form->field($model, 'time') ?>
        <?= $form->field($model, 'created_at') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- app-modules-lead_viewiing-views-main-_form -->
