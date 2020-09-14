<?php
/* @var $this yii\web\View */

use app\modules\calendar\models\Event;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;

echo $this->render('@app/views/modals/eventForm');
?>
<div class="calendar-wrap">
    <h2>Your calendar</h2>
    <?php
    $eventUrl = Url::to(['/calendar/main/event']);
    $taskUrl = Url::to(['/task-manager/view', 'id' => '']);
    $viewingUrl = Url::to(['/calendar/main/viewing']);
    echo edofre\fullcalendar\Fullcalendar::widget([
        'events' => Url::to(['/calendar/main/events']),
        'header' => [
            'left' => 'month agendaWeek agendaDay today',
            ' center' => '',
            'right' => 'prev title next'
        ],
        'clientOptions' => [
            'lazyFetching' => false,
            'dayClick' => new JsExpression("
                function(date, jsEvent, view) { 
                    var eventUrl = '$eventUrl?date=' + date.format(); 
                    $('#modal-event').modal('show').find('.modal-content').load(eventUrl);                     
                }
            "),
            'eventClick' => new JsExpression("
                function(event, jsEvent, view) {
                    if (event.editable == false) {
                        if (event.className[0] == 'tasks') {
                            var html = '<div>Task Name: <a href=$taskUrl' + event.id + '>' + event.title + '</a></div>';
                            html += '<div>Task DeadLine: ' + new Date(event.start).toDateString() + '</div>';
                            $('#modal-task').modal('show').find('.modal-body').html(html);
                        }
                        if (event.className[0] == 'viewings') {
                            $.post('$viewingUrl', {id: event.id}, function(data, status){
                                if (status === 'success') {
                                    console.log(data);
                                    var html = '<div>Vewing: ' + data.ref + '</div>';
                                    html += '<div>Vewing Client Name: ' + data.client_name + '</div>';
                                    html += '<div>Vewing Property: ' + data.listing_ref + '</div>';
                                    html += '<div>Vewing Date: ' + data.date + '</div>';
                                    $('#modal-viewings').modal('show').find('.modal-body').html(html);
                                }
                            });   
                        }
                    } else {
                        var eventUrl = '$eventUrl?id=' + event.id; 
                        $('#remove-event').data('id', event.id);
                        $('#remove-event').show();
                        $('#modal-event').modal('show').find('.modal-content').load(eventUrl);
                    }
                }
            "),
        ],
    ]);
    ?>
</div>
<div class="modal modal-wide-60 fade" id="modal-event-guests">
    <div class="modal-dialog">
        <div class="modal-content loader-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Guests</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Invited Guests</div>
                            <div class="contacts-guests" id="invited-guests" class="panel-body">
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Contacts</div>
                            <div class="contacts-guests" id="contacts" class="panel-body">
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <?php $form = ActiveForm::begin([
                                'id' => 'contacts-form',
                                'layout' => 'inline',
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => false,
                                'action' => ['/calendar/main/create-contact'],
                                'validationUrl' => Url::toRoute('/calendar/main/validate-contact'),
                                'fieldConfig' => [
                                    'labelOptions' => ['class' => ''],
                                    'enableError' => true,
                                ]]); ?>

                            <?= $form->field($contact, 'work_email', ['inputOptions' => ['id' => 'new-contact-email-input']]) ?>

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Add new email'),
                                    [
                                        'style' => 'margin-bottom: 10px',
                                        'class' => 'btn btn-primary',
                                        'id' => 'contacts-form-submit']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button id="cancel-contacts" type="button" class="btn btn-default"
                                    data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
                            <button id="save-contacts" type="button" class="btn btn-success"
                                    data-dismiss="modal"><?= Yii::t('app', 'Save') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-event-repeat">
    <div class="modal-dialog">
        <div class="modal-content loader-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Repeat</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="event-repeat-form" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="repeat-type">Repeats:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="repeat-type">
                                        <?php foreach (Event::$repeatTypes as $repeatType) {
                                            echo "<option data-addon-text=" . Event::getRepeatTypeAddonText($repeatType) . " ";
                                            echo "data-max-interval=" . Event::getRepeatTypeMaxInterval($repeatType) . " ";
                                            echo "value='$repeatType'>" . Event::getRepeatTypeTitle($repeatType) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php foreach (Event::$repeatTypes as $repeatType):
                                if ($repeatType !== Event::REPEAT_TYPE_NONE) {
                                    $repeatSecion = "<div id='$repeatType-section' class='repeat-section' style='display:none'>";
                                    $repeatSecion .= '<div class="form-group">';
                                    $repeatSecion .= '<label class="control-label col-sm-2" for="repeat-type">' . Yii::t('app', 'Repeat every') . ':</label>';
                                    $repeatSecion .= '<div class="col-sm-10">';
                                    $repeatSecion .= '<div class="input-group">';
                                    $repeatSecion .= "<select class='$repeatType-repeat-interval form-control repeat-type-interval'></select>";
                                    $repeatSecion .= '<span id="event-repeat-addon-text" class="input-group-addon"></span>';
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= '</div>';
                                    switch ($repeatType) {
                                        case Event::REPEAT_TYPE_WEEKLY:
                                            $days = ['S-sunday', 'M-monday', 'T-tuesday', 'W-wednesday', 'T-thursday', 'F-friday', 'S-saturday'];
                                            $dayCounter = 0;
                                            $repeatSecion .= '<div class="form-group">';
                                            $repeatSecion .= '<label class="control-label col-sm-2" for="repeat-weekly-day">' . Yii::t('app', 'Choose day(s)') . ':</label>';
                                            $repeatSecion .= '<div id="repeat-weekly-days" class="col-sm-10">';
                                            foreach ($days as $day) {
                                                $dayArr = explode("-", $day);
                                                $dayKey = $dayArr[0];
                                                $dayName = $dayArr[1];
                                                $repeatSecion .= '<label class="checkbox-inline">';
                                                $repeatSecion .= "<input type='checkbox' name='repeat-weekly-day' value='$dayName'>$dayKey";
                                                $repeatSecion .= '</label>';
                                                $dayCounter++;
                                            }
                                            $repeatSecion .= '</div>';
                                            $repeatSecion .= '</div>';
                                            break;
                                    }
                                    $repeatSecion .= '<div class="form-group">';
                                    $repeatSecion .= '<label class="control-label col-sm-2" for="repeat-type-start">' . Yii::t('app', 'Starts on') . ':</label>';
                                    $repeatSecion .= '<div class="col-sm-10">';
                                    $repeatSecion .= DateTimePicker::widget([
                                        'name' => 'repeat-event-start_time',
                                        'disabled' => true,
                                        'layout' => '{picker}{input}',
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd hh:ii'
                                        ]
                                    ]);
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= '<div class="form-group repeat-type-time">';
                                    $repeatSecion .= '<label class="control-label col-sm-2" for="repeat-type-ends">' . Yii::t('app', 'Ends') . ':</label>';
                                    $repeatSecion .= '<div class="col-sm-10">';
                                    $repeatSecion .= '<div class="radio">';
                                    $repeatSecion .= '<label><input value="never" type="radio" name="' . $repeatType . '-repeat-type-ends">' . Yii::t('app', 'Never') . '</label>';
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= '<div class="radio">';
                                    $repeatSecion .= '<label class="event-on-label"><input value="on" type="radio" name="' . $repeatType . '-repeat-type-ends" checked>' . Yii::t('app', 'On') . '</label>';
                                    $repeatSecion .= DateTimePicker::widget([
                                        'id' => $repeatType . '-event-end-time',
                                        'name' => $repeatType . '-repeat-event-end-time',
                                        'layout' => '{picker}{input}',
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd hh:ii',
                                            'autoclose' => true,
                                        ],
                                        'pluginEvents' => [
                                            'changeDate' => 'function(e) {  
                                             var repeatStartTime = $("input[name=\"repeat-event-start_time\"]").val();
                                             var repeatStartTimestamp = Date.parse(repeatStartTime)/ 1000;   
                                             var repeatEndTime = $("input[name=\"' . $repeatType . '-repeat-event-end-time\"]").val(); 
                                             var repeatEndTimestamp = Date.parse(repeatEndTime)/ 1000;    
                                             if ( repeatEndTimestamp <= repeatStartTimestamp )
                                             {
                                                $("input[name=\"' . $repeatType . '-repeat-event-end-time\"]").val("");
                                                $( ".repeat-end-datetime-error" ).show();
                                             }
                                             else
                                                $( ".repeat-end-datetime-error" ).hide();
                                         }',
                                        ]
                                    ]);
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= '</div>';
                                    $repeatSecion .= "</div>";
                                    echo $repeatSecion;
                                }
                            endforeach;
                            ?>
                            <div class="repeat-end-datetime-error alert alert-danger" style="display: none;">
                                <?= Yii::t('app', 'End datetime must be greater then start datetime') ?>
                            </div
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button type="submit" data-dismiss="modal" data-target=".modal-event-repeat"
                                            class="btn btn-default"><?= Yii::t('app', 'Cancel') ?></button>
                                    <button type="submit" id="save-repeat-settings"
                                            class="btn btn-success"><?= Yii::t('app', 'Save') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-task">
    <div class="modal-dialog">
        <div class="modal-content loader-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= Yii::t('app', 'Task Manager Info') ?></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-viewings">
    <div class="modal-dialog">
        <div class="modal-content loader-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= Yii::t('app', 'Viewings Info') ?></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
            </div>
        </div>
    </div>
</div>