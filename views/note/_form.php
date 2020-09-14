<?php

use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Note */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
if ($model->isNewRecord)
    $actionUrl = Url::to(['/note/create']);
else
    $actionUrl = Url::to(['/note/update', 'id' => $model->id]);
?>
    <div class="note-form">

        <?php $form = ActiveForm::begin([
            'id' => 'note-form',
            'enableAjaxValidation' => true,
            'action' => ['/note/create'],
            'validationUrl' => ['/note/validate']
        ]); ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

        <div style="display: none"><?= $form->field($model, 'user_id')->textInput() ?></div>

        <?php
        if ($model->date)
            $date = (!$model->isNewRecord) ? date('Y-m-d H:i', $model->date) : '';
        else
            $date = '';
        echo $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter date ...', 'value' => $date],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

<?php

$script = <<<JS
$('body').on('beforeSubmit', 'form#note-form', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();   
    var form = $(this);
     if (form.find('.has-error').length) {
          return false;
     }
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) {
             $('#create-note-modal').modal('hide');
             $.pjax.reload({container: '#notes-pa-list', timeout: 2000}); 
          }
     });
     return false;              
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
