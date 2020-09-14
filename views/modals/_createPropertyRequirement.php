<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;

Modal::begin([
    'id' => 'create-property-requirement-modal',
    'header' => '<h3>' . Yii::t('app', 'Property Requirement') . '</h3>',
]);
?>
    <div id="check-type-property-requirement">
        <div>
            <?= Html::radio('check-create-property-type', false, ['class' => 'height-auto', 'value' => 1])?><?= Yii::t('app', 'Load from existing property')?>
            <?= Html::input('text', '', '', ['placeholder' => Yii::t('app', 'Reference number'), 'class' => 'form-control', 'id' => 'listing-ref-for-prop-requirement'])?>
        </div>
        <div>
            <?= Html::radio('check-create-property-type', false, ['class' => 'height-auto', 'value' => 2])?><?= Yii::t('app', 'Enter new property requirements')?>
        </div>
        <?= Html::button(Yii::t('app', 'Continue'), ['class' => 'btn btn-primary', 'id' => 'btn-process-create-property'])?>
    </div>
    <div id="create-property-requirement-content"></div>
<?php
Modal::end();
?>