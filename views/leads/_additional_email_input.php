<?php

use yii\helpers\Html;

?>
<div class="row additional-email-item" style="margin-bottom: 10px">
    <div class="col-sm-5">
        <?= Html::textInput('additional-email-field', $additionalEmail, ['class' => 'form-control additional-email-field', 'placeholder' => Yii::t('app', 'Enter email..')]); ?>
        <div style="display: none" class="help-block"><?= Yii::t('app', 'Please, enter valid email') ?></div>
    </div>
    <div class="col-sm-2">
        <?= Html::a('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>', '#', ['class' => "btn-danger remove-additional-email btn"]); ?>
    </div>
</div>