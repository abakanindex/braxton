<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

echo "<div style='margin-top: 10px'>";
Pjax::begin(['id' => 'pjax-rentals-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'rentals-gridview',
    'dataProvider' => $rentalsDataProvider,
    'filterModel' => $rentalsSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'ref',
    ],
]);
echo "</div>";
Pjax::end();
echo Html::a('Add Rentals', '#', ['class'=>'add-rentals btn btn-success']);