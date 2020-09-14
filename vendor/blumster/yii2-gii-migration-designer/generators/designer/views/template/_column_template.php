<?php

use blumster\migration\generators\designer\Generator;

/* @var \yii\web\View $this */
/* @var \yii\bootstrap\ActiveForm $form */
/* @var \blumster\migration\models\Column $column */
/* @var int|string $i */
/* @var int|string $c */

?>

<tr class="column-form" data-i="<?= $i ?>" data-c="<?= $c ?>">
    <td>
        <?= $form->field($column, "[{$i}][{$c}]name")->textInput([ 'maxlength' => true ]) ?>
        <button class="btn btn-xs btn-remove-column">X</button>
    </td>
    <td>
        <?= $form->field($column, "[{$i}][{$c}]type")->dropDownList([ '' => '' ] + Generator::columnTypes(), [ 'maxlength' => true ]) ?>
    </td>
    <td>
        <?= $form->field($column, "[{$i}][{$c}]unique")->checkbox() ?>
        <?= $form->field($column, "[{$i}][{$c}]notNull")->checkbox() ?>
    </td>
    <td>
        <?= $form->field($column, "[{$i}][{$c}]unsigned")->checkbox() ?>
    </td>
    <td>
        <?= $form->field($column, "[{$i}][{$c}]defaultValue")->textInput([ 'maxlength' => true ]) ?>
    </td>
</tr>
