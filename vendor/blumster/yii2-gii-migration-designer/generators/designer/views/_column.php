<?php

use blumster\migration\generators\designer\Generator;

/* @var yii\bootstrap\ActiveForm $form */
/* @var blumster\migration\models\Table $table */
/* @var blumster\migration\models\Column $column */
/* @var int $i */
/* @var int $c */
/* @var string $tableUnique */

?>

<tr class="db-column-<?= $tableUnique ?> columns-custom-width">
    <td>
        <button type="button" class="del-db-column-<?= $tableUnique ?> btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
    </td>
    <td>
        <?= $form->field($column, "[{$i}][{$c}]name")->textInput([ 'maxlength' => true ]) ?>
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
