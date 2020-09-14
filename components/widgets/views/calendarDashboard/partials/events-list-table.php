<?php

use app\modules\reports\components\ColorSerialColumn;
use rmrevin\yii\fontawesome\FA;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var $eventsProvider
 */

echo GridView::widget([
    'dataProvider' => $eventsProvider,
    'summary' => "Showing {begin} - {end} of $eventsProvider->totalCount items",
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
    'columns' => [
        [
            'header' => 'ID',
            'value' => function ($model) {
                return $model->id;
            },
        ],
        [
            'header' => 'Title',
            'value' => function ($model) {
                return $model->title;
            },
        ],
        [
            'header' => 'Description',
            'value' => function ($model) {
                return $model->description;
            },
        ],
        [
            'header' => 'Start',
            'value' => function ($model) {
                return date('Y-m-d H:s:i', $model->start);
            },
        ],
        [
            'header' => 'End',
            'value' => function ($model) {
                return date('Y-m-d H:s:i', $model->end);
            },
        ],
        [
            'header' => 'Owner',
            'value' => function ($model) {
                return $model->username;
            },
        ],
    ],
]);
