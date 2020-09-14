<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="row user-item" style="margin-bottom: 10px">
    <div class="col-sm-5">
        <?= Html::dropDownList('user-field', $user,
            ArrayHelper::map($companyUsers, 'id', 'username'),
            ['class' => 'form-control user-field', 'placeholder' => Yii::t('app', 'Select user')]
        ) ?>
    </div>
    <div class="col-sm-2">
        <?= Html::a('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>', '#', ['class' => "btn-danger remove-user btn"]); ?>
    </div>
</div>