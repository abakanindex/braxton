<?php

use app\models\Reminder;
use app\components\widgets\ReminderInfoWidget;
use kartik\datetime\DateTimePicker;
use kartik\switchinput\SwitchInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

?>
<?php
echo Html::a(Yii::t('app', 'Edit reminder'), ['#', 'id' => $reminder->key_id], ['class' => 'edit-reminder btn btn-primary']);
echo '<button data-id="' . $reminder->id . '" style="margin-left: 5px" id="delete-reminder" class="delete-reminder btn btn-default"><span class="glyphicon glyphicon-remove"></span></button>';
echo ReminderInfoWidget::widget(['keyId' => $keyId, 'keyType' => $keyType])
?>

    <div id="reminder-alert" class="alert alert-success" style="display: none; margin-top: 10px;">
    </div>
    <div id="modal-reminder" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
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

                    <?= $form->field($reminder, 'subject')->textInput() ?>
                    <?= $form->field($reminder, 'description')->textarea() ?>

                    <br>
                    <?php
                    if (!$reminder->isNewRecord && $reminder->remind_at_time)
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
                    <br>

                    <?= $form->field($reminder, 'time')->textInput() ?>
                    <?php
                    $items = [];
                    foreach (Reminder::$intervalTypes as $intervalType) {
                        $intervalTypeText = Reminder::getIntervalType($intervalType);
                        $items[$intervalType] = $intervalTypeText;
                    }
                    echo $form->field($reminder, 'interval_type')->dropDownList($items);
                    ?>

                    <br>

                    <div class="col-sm-9 col-sm-offset-3">
                        <p class="hint">
                            <?= Yii::t('app', 'You can also enter notification time') ?>
                        </p>
                    </div>

                    <?php
                    $statusItems = [Reminder::STATUS_ACTIVE => Yii::t('app', 'Active'), Reminder::STATUS_NOT_ACTIVE => Yii::t('app', 'Not Active')];
                    echo $form->field($reminder, 'status')->dropDownList($statusItems);
                    ?>

                    <br>
                    <div id="users" class="form-group" style="margin-left: 20px;">
                        <div style="padding-bottom: 5px;">
                            <label class="control-label"><?= Yii::t('app', 'Users') ?></label>
                            <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', '#', ['class' => "btn-default add-user btn"]) ?>
                        </div>
                        <div id="users-block">
                            <?php
                            if (!$reminder->isNewRecord) {
                                $users = \app\models\ReminderUser::find()->where(['reminder_id' => $reminder->id])->asArray()->all();
                                $formUsers = [];
                                foreach ($users as $user) {
                                    unset($user['id']);
                                    unset($user['reminder_id']);
                                    $formUsers[] = $user['user_id'];
                                }

                                $reminder->users = Json::encode($formUsers);
                            }
                            if ($users) {
                                foreach ($users as $user)
                                    echo $this->render('_users_input', ['user' => $user['user_id'], 'companyUsers' => $companyUsers]);
                            }
                            ?>
                        </div>
                    </div>
                    <div id="reminders-users" style="display: none;"><?= $form->field($reminder, 'users')->textInput() ?></div>


                    <div style="display: none">
                        <?= $form->field($reminder, 'key')->textInput() ?>

                        <?php
                        $reminder->key_id = $keyId;
                        echo $form->field($reminder, 'key_id')->textInput();
                        ?>

                        <?= $form->field($reminder, 'created_at')->textInput(); ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <?php
                    echo Html::button(Yii::t('app', 'Close'), [
                        'class' => 'btn btn-default pull-right',
                        'data-dismiss' => 'modal',
                    ]);
                    echo Html::submitButton(Yii::t('app', 'Save'), [
                        'class' => 'btn btn-success',
                        'style' => 'margin: 0 10px;',
                    ]);
                    ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php

$reminderWasSaveText = Yii::t('app', 'Reminder was saved');
$reminderUpdateUrl = Url::to(['/reminder/update']);
if ($reminder->isNewRecord)
    $reminderSaveUrl = Url::to(['/reminder/create']);
else
    $reminderSaveUrl = Url::to(['/reminder/update', 'id' => $reminder->id]);
$reminderChangeStatusUrl = Url::to(['/reminder/change-status']);
$reminderTableName = \yii\helpers\StringHelper::basename(get_class($reminder));

$userField = $this->render('_users_input', ['companyUsers' => $companyUsers]);
$userField = preg_replace("/\r|\n/", "", $userField);

$script = <<<JS

var reminderBlock = $('.reminder_block');

$( '#delete-reminder' ).on("click", function () {  
    reminderBlock.find('.interval_time').empty();
    reminderBlock.find('.interval').empty();
    reminderBlock.find('.notification').empty();
    reminderBlock.find('.status').empty();
    reminderBlock.find('.note').empty(); 
    $('input#reminder').val('');
    $('#reminder-form *').filter(':input').each(function(){
           var inputName = $(this).attr('name');  
           switch(inputName) {
            case '$reminderTableName' + '[time]':
                $(this).val(''); break;
             case '$reminderTableName' + '[remind_at_time]':
                $(this).val(''); break; 
            case '$reminderTableName' + '[description]':  
                $(this).val(''); break;
            }
     });
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
        
        var inputReminder = $('input#reminder');
        if ( inputReminder.length ) {
            $('#reminder-form *').filter(':input').each(function(){
               var inputName = $(this).attr('name');  
               switch(inputName) {
                case '$reminderTableName' + '[time]':
                    reminderBlock.find('.interval_time').text( $(this).val());
                    break;
                case '$reminderTableName' + '[interval_type]':
                    var selectName = '$reminderTableName' + '[interval_type]'; 
                    reminderBlock.find('.interval').text( $('select[name="' + selectName + '"] option:selected').text() );
                    break;
                 case '$reminderTableName' + '[remind_at_time]':
                    reminderBlock.find('.notification').text( $(this).val() );
                    break;
                case '$reminderTableName' + '[status]':
                    var selectName = '$reminderTableName' + '[status]'; 
                    reminderBlock.find('.status').text( $('select[name="' + selectName + '"] option:selected').text() );
                    break;
                case '$reminderTableName' + '[description]':  
                    reminderBlock.find('.note').text( $(this).val() );
                    break;
                }
            });
            var reminderData = JSON.stringify( $('#reminder-form').serialize() );
            inputReminder.val(reminderData);
        } else { 
            $.ajax({
               type: "POST",
               url: '$reminderSaveUrl', 
               data: $("#reminder-form").serialize(), 
               success: function(response) {
                   if (response.result == 'success')
                   {
                       $('.reminder_block .interval_time').text(response.intervalTime);
                       $('.reminder_block .interval').text(response.intervalType);
                       $('.reminder_block .status').text(response.status);
                       $('.reminder_block .note').text(response.description);
                       var notificationTime = response.notification_time.date;
                       notificationTime = notificationTime.substr(0, notificationTime.lastIndexOf(":"));
                       $('.reminder_block .notification').text(notificationTime); 
                   }
                }
             });
         }  
            
        $('#modal-reminder').modal('hide');
        return false; 
    });

    $('#users').on("click",".add-user", function(){ 
        $('#users-block').prepend('$userField');
        getUsers();   
        return false; 
    });
    
    function getUsers() {
        var usersArr = [];
        $( "#reminder-form .user-item" ).each(function() {
          var userItem = $(this).find( ".user-field" ).val();
          if(jQuery.inArray(userItem, usersArr) == -1)
            usersArr.push(userItem);
        });
        
        $('#reminder-users').val(JSON.stringify(usersArr));
        // console.log(usersArr);
    }
    
    $('#users').on("change",".user-field", function(){
      getUsers();
    });
    
    $('#users').on("click",".remove-user", function(){
        $(this).closest('.user-item').remove();
        getUsers();
        return false; 
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);

if (!$reminder->isNewRecord):
    $reminderDeleteUrl = Url::to(['/reminder/delete']);
    $script = <<<JS
$( '#delete-reminder' ).on("click", function () {
        var reminderId = $(this).data('id');
        $.ajax({
        url: '$reminderDeleteUrl?id=' + reminderId,
        type: 'post',
        success: function (response) {}  
    });
  return false; 
});
JS;
    $this->registerJs($script, yii\web\View::POS_READY);
endif;
