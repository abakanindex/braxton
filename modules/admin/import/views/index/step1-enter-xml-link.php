<?php
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
        'enableAjaxValidation' => false,
]); ?>
<div class="row">
    <div class="col-lg-4">
        <?= $form->field($model, 'xmlLink')->textInput()->label('Please enter link to xml file for merge') ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <?= \yii\helpers\Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>