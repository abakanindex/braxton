<?php

use app\models\Reminder;
use kartik\datetime\DateTimePicker;
use kartik\switchinput\SwitchInput;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => ['/reminder/create'],
    'validationUrl' => ['/reminder/validate'],
    'class' => 'form-horizontal',
    'layout' => 'horizontal',
    'options' => [
        'id' => 'reminder-form'
    ]]);
?>
    <div class="modal-body">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
            $field = $form->field($reminder, 'timeOrIntervalError');
            $field->template = "{input}{error}";
            echo $field->textInput(['style' => 'display: none']);
            ?>
        </div>

        <?= $form->field($reminder, 'time')->textInput() ?>

        <?php
        $items = [];
        foreach (Reminder::$intervalTypes as $intervalType) {
            $intervalTypeText = Reminder::getIntervalType($intervalType);
            $items[$intervalType] = $intervalTypeText;
        }
        echo $form->field($reminder, 'interval_type')->dropDownList($items);
        ?>
        <div class="col-sm-9 col-sm-offset-3">
            <p class="hint">
                <?= Yii::t('app', 'You can also enter notification time') ?>
            </p>
        </div>

        <?php
        if (!$reminder->IsNewRecord && $reminder->remind_at_time)
            $reminder->remind_at_time = date('Y-m-d H:i', $reminder->remind_at_time);
        echo $form->field($reminder, 'remind_at_time')->widget(DateTimePicker::classname(), [
            'options' => [
                'placeholder' => 'Enter notification time ...',
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii',
                'readonly' => true
            ]
        ]);

        ?>

        <?php
        $statusItems = [Reminder::STATUS_ACTIVE => Yii::t('app', 'Active'), Reminder::STATUS_NOT_ACTIVE => Yii::t('app', 'Not Active')];
        echo $form->field($reminder, 'status')->dropDownList($statusItems);
        ?>

        <?= $form->field($reminder, 'description')->textarea() ?>

        <?php
        echo $form->field($reminder, 'key')->dropDownList(Reminder::getKeys(),
            [
                'prompt' => 'Select...',
                'id' => 'reminder-key-select'
            ]);
        ?>

        <div style="display: none">

            <?= $form->field($reminder, 'created_at')->textInput() ?>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::a(Yii::t('app', 'Choose'), '#', [
                'id' => 'choose-reminder-object',
                'class' => 'btn btn-primary',
                'style' => 'display: none'
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3 key-info">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <?php
            $field = $form->field($reminder, 'key_id');
            $field->template = "{input}{error}";
            echo $field->textInput(['style' => 'display: none']);
            ?>
        </div>
    </div>

    <div class="modal-footer">

        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
        <?php
        echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']);
        ?>
    </div>
<?php ActiveForm::end();

Modal::begin([
    'header' => Yii::t('app', 'Choose'),
    'id' => 'reminder-gridviews-modal',
    'size' => 'modal-lg'
]);
echo "<div id='reminder-gridviews-content'></div>";
echo Html::a(Yii::t('app', 'Choose'), '#', ['class' => 'choose-reminder-key btn btn-primary']);
Modal::end();

$chooseText = Yii::t('app', 'Choose');
$keyIdText = Yii::t('app', 'Key Id') . ': ';
$reminderGridview = Url::to(['reminder/gridviews']);
$script = <<<JS

    $('body').on('beforeSubmit.yii', 'form#reminder-form', function (e) { 
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
                if (response.result === 'success') {
                    $('#create-reminder-modal').modal('hide');   
                    location.reload();
                }
             }
        });
        
        return false; 
    });
        
    var keyId, keyInfo;

    $('body').on('click','.reminder-key-gridview input[type="checkbox"]',function(){
        keyId = $(this).val(); 
        $(".reminder-key-gridview input[value !='"+keyId+"']").each(function() {
            $(this).prop('checked', false);
        });     
    });
    
    $('body').on('click','.choose-reminder-key',function(){
        if (keyId) {
            $('#reminder-key_id').val(keyId);
            $('.key-info').empty();
            if (keyId)
                $('.key-info').text('$keyIdText#' + keyId);
            $('#reminder-gridviews-modal').modal('hide');
        }
        return false;   
    });
    
    var reminderKeySelect = $('#reminder-key-select');
    var chooseReminderObjectBtn = $('#choose-reminder-object');
    
    reminderKeySelect.on('change', function() {
      if( this.value != 0 && this.value != '' )
          { 
              var text = $( "#reminder-key-select option:selected" ).text();
              $('#choose-reminder-object').text('$chooseText' + ' ' + text);  
              chooseReminderObjectBtn.show();
          }
          else 
              chooseReminderObjectBtn.hide();
              
    })

    $('#choose-reminder-object').click(function () {
        var key = $( "#reminder-key-select option:selected" ).val();
        $("#reminder-gridviews-content").load('$reminderGridview' + '?key=' + key, function(responseTxt, statusTxt, xhr){
                $('#reminder-gridviews-modal').modal('show');
    });
        return false;  
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);

