<?php

use app\models\Reminder;
use kartik\datetime\DateTimePicker;
use kartik\switchinput\SwitchInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('app', 'Reminder') ?></div>
        <div class="panel-body">
            <?php
            if ($reminder->isNewRecord) {
                $statusBlock = '<div id="status-block" style="display:none; margin-right: 10px;">';
                $statusBlock .= '<div class="btn-group" id="status" data-toggle="buttons">';
                $statusBlock .= '<label class="btn btn-default btn-on active">';
                $statusBlock .= '<input type="radio" value="1" name="reminder-status" checked="checked">ON</label>';
                $statusBlock .= '<label class="btn btn-default btn-off">';
                $statusBlock .= '<input type="radio" value="0" name="reminder-status">OFF</label>';
                $statusBlock .= '</div>';
                $statusBlock .= '</div>';
                echo $statusBlock;
                $actionFormUrl = Url::to(['/reminder/create']);
                echo Html::a(Yii::t('app', 'Add reminder'), ['#', 'id' => $keyId], ['class' => 'add-reminder btn btn-primary']);
                echo Html::a(Yii::t('app', 'Edit reminder'), ['#', 'id' => $keyId], ['class' => 'edit-reminder btn btn-primary', 'style' => 'display:none']);
                echo '<button style="margin-left: 5px; display: none" id="delete-reminder" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></button>';
                echo '<span class="reminder_text" style="margin-left: 10px"></span>';
                $displayBlock = 'display: none';
            } else {
                $statusCheckedOn = '';
                $statusOnActive = '';
                $statusCheckedOff = '';
                $statusOffActive = '';
                if ($reminder->status == Reminder::STATUS_ACTIVE) {
                    $statusCheckedOn = 'checked="checked"';
                    $statusOnActive = 'active';
                } else {
                    $statusCheckedOff = 'checked="checked"';
                    $statusOffActive = 'active';
                }
                $statusCheckedOff = ($reminder->status == Reminder::STATUS_NOT_ACTIVE) ? 'checked' : '';
                $statusBlock = '<div id="status-block" style="display: inline; margin-right: 10px;">';
                $statusBlock .= '<div class="btn-group" id="status" data-toggle="buttons">';
                $statusBlock .= '<label class="btn btn-default btn-on ' . $statusOnActive . '">';
                $statusBlock .= '<input data-id="' . $reminder->id . '" type="radio" value="' . Reminder::STATUS_ACTIVE . '" name="reminder-status" ' . $statusCheckedOn . '>' . Yii::t('app', 'ON') . '</label>';
                $statusBlock .= '<label class="btn btn-default btn-off ' . $statusOffActive . '">';
                $statusBlock .= '<input data-id="' . $reminder->id . '" type="radio" value="' . Reminder::STATUS_NOT_ACTIVE . '" name="reminder-status" ' . $statusCheckedOff . '>' . Yii::t('app', 'OFF') . '</label>';
                $statusBlock .= '</div>';
                $statusBlock .= '</div>';
                echo $statusBlock;
                $actionFormUrl = Url::to(['/reminder/update', 'id' => $reminder->id]);
                echo Html::a(Yii::t('app', 'Add reminder'), ['#', 'id' => $keyId], ['class' => 'add-reminder btn btn-primary', 'style' => 'display:none']);
                echo Html::a(Yii::t('app', 'Edit reminder'), ['#', 'id' => $keyId], ['class' => 'edit-reminder btn btn-primary']);
                echo '<button data-id="' . $reminder->id . '" style="margin-left: 5px" id="delete-reminder" class="delete-reminder btn btn-default"><span class="glyphicon glyphicon-remove"></span></button>';
                $displayBlock = '';
            }
            $reminderBlock = '<span class="reminder_text" style="margin-left: 10px;' . $displayBlock . '">';
            /*$reminderBlock .= Yii::t('app', 'Reminder') . ': ';
            $reminderBlock .= Yii::t('app', 'Every') . ' ';
            $reminderBlock .= '<span id="reminder-interval-time">' . $reminder->time . '</span> ';
            $reminderBlock .= '<span id="reminder-interval-type">' . Reminder::getIntervalType($reminder->interval_type) . '</span>';*/
            //$reminderBlock .= '.   ' . Yii::t('app', 'Send type:') . ' ';
            //$reminderBlock .= '<span id="reminder-send-type">' . $reminder->getSendType() . '</span>';
            $reminderBlock .= '</span>';
            echo $reminderBlock;
            ?>

            <div id="reminder-alert" class="alert alert-success" style="display: none; margin-top: 10px;">
            </div>
            <div id="modal-reminder" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">
                                <?= Yii::t('app', 'Add Reminder') ?></h4>
                        </div>
                        <?php
                        $form = ActiveForm::begin([
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'action' => $actionFormUrl,
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
                            if (!$reminder->IsNewRecord)
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

                            /*$sendTypeItems = [Reminder::SEND_TYPE_WEBSITE => Yii::t('app', 'Website'), Reminder::SEND_TYPE_EMAIL => Yii::t('app', 'Email')];
                            echo $form->field($reminder, 'send_type')->dropDownList($sendTypeItems);*/
                            ?>

                            <?= $form->field($reminder, 'description')->textarea() ?>

                            <div style="display: none">
                                <?= $form->field($reminder, 'key')->textInput() ?>

                                <?= $form->field($reminder, 'key_id')->textInput() ?>

                                <?= $form->field($reminder, 'created_at')->textInput() ?>

                                <?= $form->field($reminder, 'status')->textInput() ?>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
                            <?php
                            echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']);
                            ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

$reminderWasSaveText = Yii::t('app', 'Reminder was saved');
$reminderUpdateUrl = Url::to(['/reminder/update']);
$reminderDeleteUrl = Url::to(['/reminder/delete']);
$reminderChangeStatusUrl = Url::to(['/reminder/change-status']);

$script = <<<JS

$( 'input[name="reminder-status"]:radio' ).on("change", function () {    
  var status = $(this).val();
  var reminderId = $(this).data('id');  
  $.ajax({  
        url: '$reminderChangeStatusUrl?id=' + reminderId + '&status=' + status,
        type: 'post',
        success: function (response) {
            if ( response.result === 'success' ) {  

                }
             }  
         });
});


var reminderAlert = $('#reminder-alert');

$( '#delete-reminder' ).on("click", function () {  
  var reminderId = $(this).data('id');  
  $.ajax({
        url: '$reminderDeleteUrl?id=' + reminderId,
        type: 'post',
        success: function (response) {
            if ( response.result === 'success' ) {  
              reminderAlert.hide().text(''); 
              $('#status-block').hide();
              $( '.edit-reminder' ).hide();
              $( '#delete-reminder' ).hide();
              $('#reminder-interval-time').text('');
              $('#reminder-interval-type').text('');   
              // $('#reminder-send-type').text('');   
              $('.reminder_text').hide();  
              $( '.add-reminder' ).show();
            }
         }  
    });
  return false; 
});

$( '.add-reminder' ).on("click", function () {  
  $('#modal-reminder').modal('toggle');
  return false; 
});

$( '.edit-reminder' ).on("click", function () {  
  $('#modal-reminder').modal('toggle');
  return false; 
}); 

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
                if ( response.result === 'success' ) {  
                  form.attr('action', '$reminderUpdateUrl?id=' + response.id);
                  $( '#delete-reminder' ).data('id', response.id);
                  $('#modal-reminder').modal('hide');
                  $( '.add-reminder' ).hide();
                  $( '.edit-reminder' ).show();
                  $( '#delete-reminder' ).show();
                  $('#status-block').css("display", "inline");   
                  $('#reminder-interval-time').text(response.intervalTime);
                  $('#reminder-interval-type').text(response.intervalType);   
                  $('#reminder-send-type').text(response.sendType);   
                  $('.reminder_text').show();    
                  reminderAlert.show().text('$reminderWasSaveText');
                }
             }  
        });
        return false; 
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
