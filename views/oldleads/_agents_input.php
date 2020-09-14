<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="row agent-item" style="margin-bottom: 10px">
    <div class="col-sm-5">
        <?= Html::dropDownList('agent-field', $agent,
            ArrayHelper::map($companyAgents, 'id', 'username'),
            ['class' => 'form-control agent-field', 'placeholder' => Yii::t('app', 'Select agent')]
            ) ?>
    </div>
    <div class="col-sm-2">
        <?= Html::a('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>', '#', ['class' => "btn-danger remove-agent btn"]); ?>
    </div>
</div>