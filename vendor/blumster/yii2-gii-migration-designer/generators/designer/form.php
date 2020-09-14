<?php

use blumster\migration\DesignerAsset;
use blumster\migration\models\Column;
use blumster\migration\models\ForeignKey;
use blumster\migration\models\Index;
use blumster\migration\models\Table;

use yii\bootstrap\ActiveForm;
use yii\gii\components\ActiveField;
use yii\helpers\Json;

/* @var yii\web\View $this */
/* @var yii\widgets\ActiveForm $form */
/* @var blumster\migration\generators\designer\Generator $generator */

DesignerAsset::register($this);

$tempForm = new ActiveForm([
    'successCssClass' => '',
    'fieldConfig' => ['class' => ActiveField::className()],
]);

$tableTemplate = $this->render('views/template/_table_template', [
    'form' => $tempForm,
    'table' => new Table(),
    'i' => '{{i}}'
]);

$columnTemplate = $this->render('views/template/_column_template', [
    'form' => $tempForm,
    'column' => new Column(),
    'i' => '{{i}}',
    'c' => '{{c}}'
]);

$indexTemplate = $this->render('views/template/_index_template', [
    'form' => $tempForm,
    'index' => new Index(),
    'i' => '{{i}}'
]);

$foreignKeyTemplate = $this->render('views/template/_foreign_key_template', [
    'form' => $tempForm,
    'foreignKey' => new ForeignKey(),
    'i' => '{{i}}'
]);

$this->registerJs("$('#template-container').data('table-template', " . Json::encode($tableTemplate) . ');');
$this->registerJs("$('#template-container').data('column-template', " . Json::encode($columnTemplate) . ');');
$this->registerJs("$('#template-container').data('index-template', " . Json::encode($indexTemplate) . ');');
$this->registerJs("$('#template-container').data('foreign-key-template', " . Json::encode($foreignKeyTemplate) . ');');

?>

<div id="template-container" style="display: none;"></div>
<a href="#" class="btn-table-collapse" data-toggle="collapse" data-target="#table-table"><h4>Tables<span class="caret"></span><span class="badge <?= count($generator->tables) == 0 ? 'hidden' : '' ?>" id="table-badge"><?= count($generator->tables) ?></span></h4></a>
<table class="table table-bordered collapse in" id="table-table">
    <thead>
        <tr class="active">
            <td><label class="control-label">Data</label></td>
            <td><label class="control-label">Columns</label></td>
        </tr>
    </thead>
    <tbody class="table-container">
        <?php foreach ($generator->tables as $i => $table): ?>
            <?= $this->render('views/template/_table_template', [ 'form' => $form, 'table' => $table, 'i' => $i ]) ?>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><button class="btn btn-primary btn-add-table"><span class="glyphicon glyphicon-plus"></span> Add Table</button></td>
        </tr>
    </tfoot>
</table>

<hr />

<a href="#" class="btn-table-collapse" data-toggle="collapse" data-target="#table-index"><h4>Indices<span class="caret"></span><span class="badge <?= count($generator->indices) == 0 ? 'hidden' : '' ?>" id="index-badge"><?= count($generator->indices) ?></span></h4></a>
<table class="table table-bordered collapse <?= count($generator->indices) > 0 ? 'in' : '' ?>" id="table-index">
    <thead>
        <tr class="active">
            <td><label class="control-label">Data</label></td>
        </tr>
    </thead>
    <tbody class="index-container">
        <?php foreach ($generator->indices as $i => $index): ?>
            <?= $this->render('views/template/_index_template', [ 'form' => $form, 'index' => $index, 'i' => $i ]) ?>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="active">
                <button class="btn btn-primary btn-add-index"><span class="glyphicon glyphicon-plus"></span> Add Index</button>
            </td>
        </tr>
    </tfoot>
</table>

<hr />

<a href="#" class="btn-table-collapse" data-toggle="collapse" data-target="#table-foreign-key"><h4>Foreign Keys<span class="caret"></span><span class="badge <?= count($generator->foreignKeys) == 0 ? 'hidden' : '' ?>" id="foreign-key-badge"><?= count($generator->foreignKeys) ?></span></h4></a>
<table class="table table-bordered collapse <?= count($generator->foreignKeys) > 0 ? 'in' : '' ?>" id="table-foreign-key">
    <thead>
        <tr class="active">
            <td><label class="control-label">Data</label></td>
        </tr>
    </thead>
    <tbody class="foreign-key-container">
        <?php foreach ($generator->foreignKeys as $i => $foreignKey): ?>
            <?= $this->render('views/template/_foreign_key_template', [ 'form' => $form, 'foreignKey' => $foreignKey, 'i' => $i ]) ?>
        <?php endforeach ?>
    </tbody>
    <tfoot>
    <tr>
        <td class="active">
            <button class="btn btn-primary btn-add-foreign-key"><span class="glyphicon glyphicon-plus"></span> Add Foreign Key</button>
        </td>
    </tr>
    </tfoot>
</table>

<hr />

<?= $form->field($generator, 'migrationName')->textInput() ?>


<?= $form->field($generator, 'indexFormat')->textInput() ?>

<?= $form->field($generator, 'foreignKeyFormat')->textInput() ?>

<?= $form->field($generator, 'migrationPath')->textInput() ?>

<?= $form->field($generator, 'db')->textInput() ?>

<?= $form->field($generator, 'baseClass')->textInput() ?>

<?= $form->field($generator, 'usePrefix')->checkbox() ?>

<?= $form->field($generator, 'safe')->checkbox() ?>
