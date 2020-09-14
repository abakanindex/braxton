<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

echo '<div class="reminder-key-gridview">';
Pjax::begin(['id' => 'pjax-reminder-leads-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'reminder-leads-gridview',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'reference',
    ],
]);
Pjax::end();
echo "</div>";  
