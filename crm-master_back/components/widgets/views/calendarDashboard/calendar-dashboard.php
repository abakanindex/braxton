<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\web\View;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use rmrevin\yii\fontawesome\FA;

/**
 * @var string $dates
 */
?>

<div class="box box-solid bg-green-gradient">
    <div class="box-header">
        <i class="fa fa-calendar"></i>

        <h3 class="box-title"><?php echo Yii::t('app', 'Calendar') ?></h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
            <!-- button with a dropdown -->
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bars"></i></button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>
                        <?php echo Html::a(
                            Yii::t('app', 'View calendar'),
                            Url::to(['/calendar/main/index'])
                        ); ?>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-success btn-sm" data-widget="remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <!--The calendar -->
        <?php
            $eventUrl = Url::to(['/calendar/main/events-list']);
            echo DatePicker::widget([
                'name' => 'calendar_datepicker',
                'id' => 'calendar_datepicker',
                'type' => DatePicker::TYPE_INLINE,
                'value' => date('d M Y', time()),
                'options' => [
                    'class' => 'hide',
                ],
                'pluginOptions' => [
                    'format' => 'd M yyyy',
                    'beforeShowDay' => new JsExpression(
                        "function(date){
                            var obj = JSON.parse('$dates');
                            for (var key in obj) {
                                for (var day in obj[key]) {
                                    if (date.toISOString() == new Date(obj[key][day]).toISOString()) {
                                        if (key == 'daysStartEvents') {
                                            return {enabled: true, classes: 'calendar-event'}
                                        }
                                        if (key == 'tasksDeadlines') {
                                            return {enabled: true, classes: 'calendar-task'}
                                        }
                                        if (key == 'viewings') {
                                            return {enabled: true, classes: 'calendar-viewing'}
                                        }
                                    }
                                }
                            }
                        }"
                    )
                ],
                'pluginEvents' => [
                    'changeDate' => new JsExpression(
                        "function(e) {
                            if ($(this).find('td.active').hasClass('calendar-event')
                                || $(this).find('td.active').hasClass('calendar-task')
                                || $(this).find('td.active').hasClass('calendar-viewing')
                            ) {
                                var eventUrl = '$eventUrl?date=' + new Date(e.date).toISOString().substring(0, 10);  
                                $('#modal-events-list').modal('show').find('.modal-body').load(eventUrl);
                            }
                        }"
                    ),
                ],
            ]);
        ?>
    </div>
</div>

<div id="modal-events-list" class="fade modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo Yii::t('app', 'Events List') ?></h3>
            </div>
            <div class="modal-body">Loading...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo Yii::t('app', 'OK') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="modal-deadlines-list" class="fade modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo Yii::t('app', 'Task Manager Deadlines List') ?></h3>
            </div>
            <div class="modal-body">Loading...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo Yii::t('app', 'OK') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="modal-viewings-list" class="fade modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo Yii::t('app', 'Viewings List') ?></h3>
            </div>
            <div class="modal-body">Loading...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo Yii::t('app', 'OK') ?>
                </button>
            </div>
        </div>
    </div>
</div>