<?php

use yii\helpers\Html;

?>
<div class="row lead-note-item" style="margin-bottom: 10px">
    <div class="col-sm-5">
        <?= Html::textInput('lead-note-field', $note, ['class' => 'form-control lead-note-field', 'placeholder' => Yii::t('app', 'Enter note..')]); ?>
    </div>
    <div class="col-sm-2">
        <?= Html::a('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>', '#', ['class' => "btn-danger remove-lead-note btn"]); ?>
    </div>
</div>