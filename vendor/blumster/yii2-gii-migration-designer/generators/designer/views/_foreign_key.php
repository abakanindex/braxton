<?php

use blumster\migration\models\ForeignKey;

/* @var yii\bootstrap\ActiveForm $form */
/* @var blumster\migration\models\ForeignKey $foreignKey */
/* @var int $i */

?>

<tr class="db-foreign-key">
    <td>
        <button type="button" class="del-db-foreign-key btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
    </td>
    <td>
        <div class="col-md-5">
            <?= $form->field($foreignKey, "[{$i}]table")->textInput([ 'maxlength' => true ]) ?>
            <?= $form->field($foreignKey, "[{$i}]columns")->textInput([ 'maxlength' => true ]) ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($foreignKey, "[{$i}]refTable")->textInput([ 'maxlength' => true ]) ?>
            <?= $form->field($foreignKey, "[{$i}]refColumns")->textInput([ 'maxlength' => true ]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($foreignKey, "[{$i}]delete")->dropDownList([ '' => '' ] + ForeignKey::constraintOptions()) ?>
            <?= $form->field($foreignKey, "[{$i}]update")->dropDownList([ '' => '' ] + ForeignKey::constraintOptions()) ?>
        </div>
    </td>
</tr>
