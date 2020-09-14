<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;

echo '<div class="reminder-key-gridview">';
Pjax::begin(['id' => 'pjax-reminder-events-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'reminder-events-gridview',
    'dataProvider' => $dataProvider,
  //  'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        [
            'attribute' => 'start',
            'value' => function ($model) {
                return date('Y-m-d H:s', $model->start);
            },
            'filterType' => GridView::FILTER_DATETIME,
            'filterWidgetOptions' => [
                'convertFormat' => false,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd hh:ii',
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
            ],
        ],
    ],
]);
Pjax::end();
echo "</div>";  
