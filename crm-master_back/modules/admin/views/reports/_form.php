<?php

use app\modules\reports\models\Reports;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\reports\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="reports-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php
        $types = Reports::getTypeArray();
        echo $form->field($model, 'type')->dropDownList($types);
        ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?php
        $dateTypes = Reports::getDateTypeArray();
        echo $form->field($model, 'date_type')->dropDownList($dateTypes);
        ?>

        <?= $form->field($model, 'date_from')->textInput() ?>

        <?= $form->field($model, 'date_to')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php
$script = <<< JS

$('.field-reports-date_from').hide();
$('.field-reports-date_to').hide();
        
$('#reports-date_type').on('change', function() {
    if (this.value == 1) {
        $('.field-reports-date_from').hide();
        $('.field-reports-date_to').hide();
    } else {
        $('.field-reports-date_from').show();
        $('.field-reports-date_to').show();
    }
});

JS;
$this->registerJs($script, yii\web\View::POS_READY);
