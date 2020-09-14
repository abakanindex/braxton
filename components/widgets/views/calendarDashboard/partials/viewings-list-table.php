<?php

use app\modules\reports\components\ColorSerialColumn;
use rmrevin\yii\fontawesome\FA;
use yii\grid\GridView;
use yii\helpers\{Html, Url};
use app\models\Viewings;

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
            'header' => 'Description',
            'value' => function ($model) {
                return $model->note;
            },
        ],
        [
            'label' => Yii::t('app', 'Created for'),
            'attribute' => 'ref',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getLink();
            },
        ],
        [
            'label' => Yii::t('app', 'Property'),
            'attribute' => 'listing_ref',
            'format' => 'raw',
            'value' => function($model) {
                return $model->getLinkListingRef();
            },
        ],
        [
            'header' => 'Owner',
            'value' => function ($model) {
                return $model->username;
            },
        ],
        [
            'header' => 'Date',
            'value' => function ($model) {
                return $model->date;
            },
        ],
    ],
]);
