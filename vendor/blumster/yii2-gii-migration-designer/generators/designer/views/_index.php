<?php

/* @var yii\bootstrap\ActiveForm $form */
/* @var blumster\migration\models\Index $index */
/* @var int $i */

?>

<tr class="db-index">
    <td>
        <button type="button" class="del-db-index btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
    </td>
    <td>
        <div class="col-md-3">
            <?= $form->field($index, "[{$i}]table")->textInput([ 'maxlength' => true ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($index, "[{$i}]columns")->textInput([ 'maxlength' => true ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($index, "[{$i}]unique")->checkbox() ?>
        </div>
    </td>
</tr>
