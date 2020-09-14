<?php

/* @var yii\web\View $this */
/* @var yii\bootstrap\ActiveForm $form */
/* @var blumster\migration\models\Table $table */
/* @var int $i */

?>

<tr class="table-form" data-i="<?= $i ?>">
    <td>
        <?= $form->field($table, "[{$i}]name")->textInput([ 'maxlength' => true, 'class' => 'form-control' ]) ?>
        <button class="btn btn-xs btn-remove-table">X</button>
    </td>
    <td>
        <table class="table table-bordered" id="table-column">
            <tbody class="column-container">
                <?php foreach ($table->columns as $c => $column): ?>
                    <?= $this->render('_column_template', [ 'form' => $form, 'column' => $column, 'i' => $i, 'c' => $c ]) ?>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><button class="btn btn-primary btn-add-column"><span class="glyphicon glyphicon-plus"></span> Add Column</button></td>
                </tr>
            </tfoot>
        </table>
    </td>
</tr>
