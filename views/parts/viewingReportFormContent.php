<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $model
 */
?>

<div class="row margin-top-15">
    <div class="col-md-12">
        <div>
            <?= Yii::t('app', 'Your viewing was appointed on {date}.', ['date' => $model->date]) ?>
        </div>
        <div>
            <?= Yii::t('app', 'Note'), ': ', $model->note ?>
        </div>
        <div>
            <?= Yii::t('app', 'Referral'), ': ', $model->ref ?>
        </div>
    </div>
</div>

<div class="row margin-top-15">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal',
                'id' => 'viewing-report-form',
//            'data-pjax' => true
            ]
        ]); ?>

        <?= $form->field($model, 'id', [
            'template' => '{input}',
            'options' => [
                'tag' => false,
            ],
        ])->hiddenInput(['id' => 'viewing-report-id']); ?>

        <?= $form->field($model, 'report_title'); ?>

        <?= $form->field($model, 'report_description'); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>