<?php

use app\models\Leads;
use app\models\Rentals;
use app\models\Sale;
use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
    <div class="panel panel-default PersonalAssistantWidget-wrap">
        <div class="panel-heading"><?= Yii::t('app', 'Personal Assistant Widget') ?></div>
        <div class="panel-body">
            <div class="container-fluid">
                <div class="col-sm-12">
                    <?= Html::a(Yii::t('app', 'Create Note'), '#',
                        [
                            'class' => 'pull-left btn btn-primary create-note-btn',
                            'style' => 'margin-bottom: 10px',
                            'data-toggle' => 'modal',
                            'data-target' => '#create-note-modal'
                        ]) ?>

                    <?= Html::a(Yii::t('app', 'Create Reminder'), '#',
                        [
                            'class' => 'pull-left btn create-reminder-btn',
                            'style' => 'margin-bottom: 10px; margin-left: 10px',
                            'data-toggle' => 'modal',
                            'data-target' => '#create-reminder-modal'
                        ]) ?>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 small-widget-block">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?= Yii::t('app', 'Upcoming Notifications') ?>
                            </div>
                            <div class="panel-body">
                                <?php Pjax::begin(['id' => 'remider-pa-list']); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $notificationsDataProvider,
                                    'options' => ['style' => 'table-layout:fixed;'],
                                    'columns' => [
                                        [
                                            'label' => Yii::t('app', 'Link'),
                                            'contentOptions' => ['style' => 'width: 20%;'],
                                            'attribute' => 'key',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return '<span style="font-size: 12px">' . $model->getLink() . '</span>';
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Notification'),
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return '<span style="font-size: 12px">' . $model->getNotificationTitle() . '</span>';
                                            }
                                        ],
                                        [
                                            'contentOptions' => ['style' => 'width: 50%;'],
                                            'format' => 'ntext',
                                            'class' => 'kartik\grid\EditableColumn',
                                            'attribute' => 'description',
                                            'editableOptions' => function ($model, $key, $index) {
                                                return [
                                                    'size' => 'lg',
                                                    'header' => ' ',
                                                    'placement' => 'left',
                                                    'inputType' => Editable::INPUT_TEXTAREA,
                                                    'submitOnEnter' => false,
                                                    'options' => ['class' => 'form-control', 'rows' => 3, 'placeholder' => Yii::t('app', 'Enter note...')],
                                                    'formOptions' => [
                                                        'action' => ['/reminder/table-update', 'id' => $model->id],
                                                    ]
                                                ];
                                            },
                                        ]
                                    ]]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 small-widget-block">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= Yii::t('app', 'Tasks') ?></div>
                            <div class="panel-body">
                                <?php Pjax::begin(['id' => 'tasks-pa-list']); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $tasksDataProvider,
                                    'options' => ['style' => 'table-layout:fixed;'],
                                    'columns' => [
                                        array(
                                            'label' => Yii::t('app', 'Deadline'),
                                            'contentOptions' => ['style' => 'width: 20%;'],
                                            'attribute' => 'deadline',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return '<span style="font-size: 12px">' . $model->deadline . '</span>';
                                            }
                                        ),
                                        [
                                            'attribute' => 'salesIds',
                                            'format' => 'raw',
                                            'value' => function ($model, $index, $widget) {
                                                $salesLinks = \app\models\TaskSaleLink::find()->where(['task_id' => $model->id])->with(['sale'])->all();
                                                $salesList = '<ul style="list-style: none">';
                                                foreach ($salesLinks as $salesLink)
                                                    $salesList .= '<li>' . Html::a($salesLink->sale->ref, ['sale/' . $salesLink->sale->ref]) . '</li>';
                                                $salesList .= '</ul>';
                                                return $salesList;
                                            }
                                        ],
                                        [
                                            'attribute' => 'rentalsIds',
                                            'format' => 'raw',
                                            'value' => function ($model, $index, $widget) {
                                                $rentalsLinks = \app\models\TaskRentalLink::find()->where(['task_id' => $model->id])->with(['rental'])->all();
                                                $rentalsList = '<ul style="list-style: none">';
                                                foreach ($rentalsLinks as $rentalsLink)
                                                    $rentalsList .= '<li>' . Html::a($rentalsLink->rental->ref, ['rentals/' . $rentalsLink->rental->ref]) . '</li>';
                                                $rentalsList .= '</ul>';
                                                return $rentalsList;
                                            }],
                                    ]]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 small-widget-block">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= Yii::t('app', 'Events') ?></div>
                            <div class="panel-body">
                                <?php Pjax::begin(['id' => 'events-pa-list']); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $eventsDataProvider,
                                    'options' => ['style' => 'table-layout:fixed;'],
                                    'columns' => [
                                        [
                                            'attribute' => 'start',
                                            'value' => function ($model, $index, $widget) {
                                                return date('Y-m-d H:i', $model->start);
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Sale'),
                                            'format' => 'raw',
                                            'value' => function ($model, $index, $widget) {
                                                if ($model->sale_id) {
                                                    $sale = Sale::findOne($model->sale_id);
                                                    return Html::a($sale->ref, ['sale/' . $sale->ref]);
                                                }
                                                return '';
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Rental'),
                                            'format' => 'raw',
                                            'value' => function ($model, $index, $widget) {
                                                if ($model->rentals_id) {
                                                    $rental = Rentals::findOne($model->rentals_id);
                                                    return Html::a($rental->ref, ['rentals/' . $rental->ref]);
                                                }
                                                return '';
                                            }
                                        ]
                                    ]]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 small-widget-block">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= Yii::t('app', 'Lead viewings') ?></div>
                            <div class="panel-body">
                                <?php Pjax::begin(['id' => 'lead-viewings-pa-list']); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $leadViewingDataProvider,
                                    'options' => ['style' => 'table-layout:fixed;'],
                                    'columns' => [
                                        [
                                            'attribute' => 'time',
                                            'value' => function ($model, $index, $widget) {
                                                return date('Y-m-d H:i', $model->time);
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Lead'),
                                            'format' => 'raw',
                                            'value' => function ($model, $index, $widget) {
                                                return Html::a($model->lead->reference, ['leads/' . $model->lead->reference]);
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Sale'),
                                            'format' => 'raw',
                                            'value' => function ($model, $index, $widget) {
                                                if ($model->sales) {
                                                    $salesList = '<ul style="list-style: none">';
                                                    foreach ($model->sales as $sale)
                                                        $salesList .= '<li>' . Html::a($sale->property->ref, ['sale/' . $sale->property->ref]) . '</li>';
                                                    $salesList .= '</ul>';
                                                    return $salesList;
                                                }
                                                return '';
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Rental'),
                                            'format' => 'raw',
                                            'value' => function ($model, $index, $widget) {
                                                if ($model->rentals) {
                                                    $rentalsList = '<ul style="list-style: none">';
                                                    foreach ($model->rentals as $rental)
                                                        $rentalsList .= '<li>' . Html::a($rental->property->ref, ['rentals/' . $rental->property->ref]) . '</li>';
                                                    $rentalsList .= '</ul>';
                                                    return $rentalsList;
                                                }
                                                return '';
                                            }
                                        ]
                                    ]]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 small-widget-block">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?= Yii::t('app', 'Today\'s Notes') ?>
                                <?php echo ' ' . date('Y-m-d') ?>
                            </div>
                            <div class="panel-body">
                                <?php Pjax::begin(['id' => 'notes-pa-list']); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $notesDataProvider,
                                    'options' => ['style' => 'table-layout:fixed;'],
                                    'columns' => [
                                        'text:ntext'
                                    ]]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 small-widget-block">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?= Yii::t('app', 'My Reminders') ?>
                            </div>
                            <div class="panel-body">
                                <?php Pjax::begin(['id' => 'reminders-pa-list']); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $remindersDataProvider,
                                    'options' => ['style' => 'table-layout:fixed;'],
                                    'columns' => [
                                        [
                                            'label' => Yii::t('app', 'Link'),
                                            'contentOptions' => ['style' => 'width: 20%;'],
                                            'attribute' => 'key',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return '<span style="font-size: 12px">' . $model->getLink() . '</span>';
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Notification'),
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return '<span style="font-size: 12px">' . $model->getNotificationTitle() . '</span>';
                                            }
                                        ],
                                        'description:ntext'
                                    ]]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 small-widget-block">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= Yii::t('app', 'Email Lead Import') ?></div>
                            <div class="panel-body">
                                <?php Pjax::begin(['id' => 'lead-viewings-pa-list']); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $emailLeadImportDataProvider,
                                    'options' => ['style' => 'table-layout:fixed;'],
                                    'columns' => [
                                        [
                                            'label' => Yii::t('app', 'Link'),
                                            'contentOptions' => ['style' => 'width: 20%;'],
                                            'attribute' => 'key',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                $reference = Leads::findOne($model->key_id)->reference;
                                                return '<span style="font-size: 12px">' . Html::a($reference, $model->getRoute()) . '</span>';
                                            }
                                        ],
                                        [
                                            'label' => Yii::t('app', 'Notification'),
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return '<span style="font-size: 12px">' . $model->getTitle() . '</span>';
                                            }
                                        ],
                                        'created_at'
                                    ]]); ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
Modal::begin([
    'header' => Yii::t('app', 'Create Note'),
    'id' => 'create-note-modal',
    'size' => 'modal-lg'
]);
echo "<div id='create-note-modal-content'></div>";
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Create Reminder'),
    'id' => 'create-reminder-modal',
    'size' => 'modal-lg'
]);
echo "<div id='create-reminder-modal-content'></div>";
Modal::end();

$createNoteUrl = Url::to(['/note/create']);
$createReminderUrl = Url::to(['/reminder/modal-form']);
$script = <<<JS
    $('.create-note-btn').click(function () {
            $('#create-note-modal').find('#create-note-modal-content')
            .load('$createNoteUrl', function() {
                $('#create-note-modal').modal('show')
            });
            return false; 
    });

    $('.create-reminder-btn').click(function () {
                $('#create-reminder-modal').find('#create-reminder-modal-content')
                .load('$createReminderUrl', function() {
                    $('#create-reminder-modal').modal('show')
                });
                return false; 
        });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
