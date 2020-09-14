<?php

/* @var yii\bootstrap\ActiveForm $form */
/* @var blumster\migration\models\Index $index */
/* @var int|string $i */

?>

<tr class="index-form" data-i="<?= $i ?>">
    <td>
        <div class="col-md-3">
            <?= $form->field($index, "[{$i}]table")->textInput([ 'maxlength' => true ]) ?>
            <button class="btn btn-xs btn-remove-index">X</button>
        </div>
        <div class="col-md-6">
            <?= $form->field($index, "[{$i}]columns")->textInput([ 'maxlength' => true ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($index, "[{$i}]unique")->checkbox() ?>
        </div>
    </td>
</tr>
