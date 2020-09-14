<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
?>

<?php Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Manage Columns') . '</h4>',
    'id'     => 'modal-columns-filter',
])
?>
<?php $formColumnChecked = ActiveForm::begin([
    'action' => $urlSaveColumnFilter
]);?>

<div class="clearfix">
    <?php
    $columnsKey  = array_keys($columnsGrid);
    $dataColumns = [];
    foreach ($columnsKey as $cK) {
        $dataColumns[$cK] = $model->getAttributeLabel($cK);
    }
    asort($dataColumns);

    $half = ceil(count($dataColumns) / 2);
    $iter = 0;
    $countDataCol = count($dataColumns);
    ?>
    <div class="row">
        <?php foreach($dataColumns as $k => $v) {?>
            <?php if($iter == 0 || $iter == $half):?>
                <div class="col-md-6">
            <?php endif;?>

            <?php $iter++;?>
            <div>
                <input type="checkbox" class="height-auto" <?php if (in_array($k, $userColumns)):?> checked <?php endif;?> name="columnChecked[]" value="<?= $k?>"><?= $v?>
            </div>

            <?php if($iter == $half || $iter == $countDataCol):?>
                </div>
            <?php endif;?>
        <?php }?>
    </div>
</div>

<div class="clearfix">
    <?= Html::button(Yii::t('app', 'Close'), [
            'class' => 'btn btn-default pull-right',
            'data-dismiss' => 'modal',
    ]) ?>
    <?= Html::submitButton(Yii::t('app', 'Save'), [
            'class' => 'btn btn-success pull-right',
            'style' => 'margin: 0 10px;',
    ]) ?>
</div>

<?php $formColumnChecked = ActiveForm::end(); ?>
<?php Modal::end();?>