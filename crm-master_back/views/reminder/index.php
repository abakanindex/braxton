<?php

use app\models\Reminder;
use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReminderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Reminders');
$this->params['breadcrumbs'][] = $this->title;
$reminderStatuses = [Reminder::STATUS_ACTIVE => Yii::t('app', 'Active'), Reminder::STATUS_NOT_ACTIVE => Yii::t('app', 'Not Active')];
$reminderSendTypes = [Reminder::SEND_TYPE_WEBSITE => Yii::t('app', 'Website'), Reminder::SEND_TYPE_EMAIL => Yii::t('app', 'Email')];
$reminderIntervals = Reminder::getDropdownIntervalType();
?>
<div class="reminder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            array(
                'label' => Yii::t('app', 'Message'),
                'attribute' => 'key',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getLink() . ' ' . $model->getNotificationTitle();
                }
            ),
            [
                'format' => 'ntext',
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'description',
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'submitOnEnter' => false,
                        'options' => ['class' => 'form-control', 'rows' => 3, 'placeholder' => Yii::t('app', 'Enter note...')],
                        'size' => 'lg',
                        'header' => ' ',
                        'placement' => 'left',
                        'inputType' => Editable::INPUT_TEXTAREA,
                        'formOptions' => [
                            'action' => ['/reminder/table-update', 'id' => $model->id],
                        ]
                    ];
                },
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'time',
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'submitOnEnter' => false,
                        'options' => ['class' => 'form-control', 'rows' => 3, 'placeholder' => Yii::t('app', 'Enter note...')],
                        'size' => 'lg',
                        'header' => ' ',
                        'placement' => 'left',
                        'inputType' => Editable::INPUT_TEXT,
                        'formOptions' => [
                            'action' => ['/reminder/table-update', 'id' => $model->id],
                        ]
                    ];
                },
            ],
            [
                'attribute' => 'interval_type',
                'class' => 'kartik\grid\EditableColumn',
                'editableOptions' => function ($model, $key, $index) use ($reminderIntervals) {
                    return [
                        'data' => $reminderIntervals,
                        'options' => ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select interval...')],
                        'header' => ' ',
                        'placement' => 'left',
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'formOptions' => [
                            'action' => ['/reminder/table-update', 'id' => $model->id],
                        ],
                        'displayValueConfig' => $reminderIntervals,
                    ];
                },
            ],
           /* [
                'attribute' => 'send_type',
                'class' => 'kartik\grid\EditableColumn',
                'editableOptions' => function ($model, $key, $index) use ($reminderSendTypes) {
                    return [
                        'data' => $reminderSendTypes,
                        'options' => ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select send type...')],
                        'header' => ' ',
                        'placement' => 'left',
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'formOptions' => [
                            'action' => ['/reminder/table-update', 'id' => $model->id],
                        ],
                        'displayValueConfig' => $reminderSendTypes,
                    ];
                },
            ],*/
            [
                'attribute' => 'status',
                'class' => 'kartik\grid\EditableColumn',
                'editableOptions' => function ($model, $key, $index) use ($reminderStatuses) {
                    return [
                        'data' => $reminderStatuses,
                        'options' => ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select status...')],
                        'header' => ' ',
                        'placement' => 'left',
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'formOptions' => [
                            'action' => ['/reminder/table-update', 'id' => $model->id],
                        ],
                        'displayValueConfig' => $reminderStatuses,
                    ];
                },
            ],
            'created_at:datetime',
            'remind_at_time:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '',
                'template' => '{delete}',
                'buttons' => ['delete' => function ($url, $model) {
                    $url = Url::to(['/reminder/delete', 'id' => $model->id]);
                    return Html::a(Yii::t('yii', 'Delete'), '#', [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'onclick' => "
                                var thItem = $(this).closest('tr'); 
                                if (confirm('" . Yii::t('yii', 'Delete this reminder') . "')) {
                                    $.ajax('$url', {
                                        type: 'POST'
                                    }).done(function(data) { 
                                    if ( data.result == 'success' )
                                        thItem.remove();   
                                    });
                                }
                                return false;
                            ",
                    ]);
                },
                ]
            ]
        ]]); ?>
    <?php Pjax::end(); ?>
</div>
