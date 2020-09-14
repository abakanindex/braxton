<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

echo '<div class="reminder-key-gridview">';
Pjax::begin(['id' => 'pjax-reminder-lead-contacts-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'reminder-lead-contacts-gridview',
    'dataProvider' => $dataProvider,
   // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        [
            'attribute' => 'lead_id',
            'value' => function ($model) {
                return $model->lead->reference;
            },
        ],
    ],
]);
Pjax::end();
echo "</div>";  
