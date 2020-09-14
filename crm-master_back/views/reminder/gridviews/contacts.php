<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

echo '<div class="reminder-key-gridview">';
Pjax::begin(['id' => 'pjax-reminder-contacts-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'reminder-contacts-gridview',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'ref',
    ],
]);
Pjax::end();
echo "</div>";  