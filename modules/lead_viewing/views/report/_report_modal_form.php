<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
            <?= Yii::t('app', 'Update Report') ?></h4>
    </div>
<?php

$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => ['/lead_viewing/report/update', 'id' => $model->id],
    'validationUrl' => ['/lead_viewing/report/validate', 'id' => $model->id],
    'class' => 'form-horizontal',
    'layout' => 'horizontal',
    'options' => [
        'id' => 'report-form'
    ]]);
?>
    <div class="modal-body">
        <?= $form->field($model, 'report')->textarea(['rows' => 10]); ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
        <?php
        echo Html::submitButton(Yii::t('app', 'Update'), ['id' => 'save-viewing-btn', 'class' => 'btn btn-success']);
        ?>
    </div>
<?php ActiveForm::end(); ?>