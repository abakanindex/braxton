<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

echo "<div style='margin-top: 10px'>";
Pjax::begin(['id' => 'pjax-sales-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'sales-gridview',
    'dataProvider' => $salesDataProvider,
    'filterModel' => $salesSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'ref',
    ],
]);
echo "</div>";
Pjax::end();
echo Html::a('Add Sales', '#', ['class'=>'add-sales btn btn-success']);