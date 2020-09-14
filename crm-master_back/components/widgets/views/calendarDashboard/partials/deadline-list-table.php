<?php

use app\modules\reports\components\ColorSerialColumn;
use rmrevin\yii\fontawesome\FA;
use yii\grid\GridView;
use yii\helpers\{Html, Url};

/**
 * @var $eventsProvider
 */

echo GridView::widget([
    'dataProvider' => $eventsProvider,
    'summary' => "Showing {begin} - {end} of $eventsProvider->totalCount items",
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
    'columns' => [
        [
            'label' => Yii::t('app', 'ID'),
            'format' => 'raw',
            'value' => function($model) {
                return Html::a($model->id,
                    Url::to(['/task-manager/view', 'id' => $model->id]),
                    ['target' => '_blank', 'data-pjax' => '0',]);
            }
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
            'header' => 'Deadline',
            'value' => function ($model) {
                return date('Y-m-d H:s:i', $model->deadline);
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
