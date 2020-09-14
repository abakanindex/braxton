<?php

use wbraganca\dynamicform\DynamicFormWidget;

/* @var yii\bootstrap\ActiveForm $form */
/* @var blumster\migration\models\Table $table */
/* @var int $i */

?>

<tr class="db-table">
    <td>
        <button type="button" class="del-db-table btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
    </td>
    <td>
        <?= $form->field($table, "[{$i}]name")->textInput([ 'maxlength' => true, 'class' => 'form-control' ]) ?>
    </td>
    <td>
        <?php $tableUnique = uniqid(); ?>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamic_columns_' . $tableUnique,
            'widgetBody' => '.db-columns-' . $tableUnique,
            'widgetItem' => '.db-column-' . $tableUnique,
            'insertButton' => '.add-db-column-' . $tableUnique,
            'deleteButton' => '.del-db-column-' . $tableUnique,
            'model' => $table->columns[0],
            'min' => 1,
            'formId' => $form->id,
            'formFields' => [
                'name',
                'type'
            ]
        ]); ?>

        <table class="table table-bordered db-columns-table">
            <tbody class="db-columns-<?= $tableUnique ?>">
            <?php foreach ($table->columns as $c => $column): ?>
                <?= $this->render('_column', [ 'form' => $form, 'table' => $table, 'i' => $i, 'column' => $column, 'c' => $c, 'tableUnique' => $tableUnique ]) ?>
            <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="active"><button type="button" class="add-db-column-<?= $tableUnique ?> btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button></td>
                </tr>
            </tfoot>
        </table>

        <?php DynamicFormWidget::end() ?>
    </td>
</tr>
