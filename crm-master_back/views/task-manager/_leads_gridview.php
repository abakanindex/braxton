<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

echo "<div style='margin-top: 10px'>";
Pjax::begin(['id' => 'pjax-leads-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'leads-gridview',
    'dataProvider' => $leadsDataProvider,
    'filterModel' => $leadsSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'reference',
        'first_name',
        'last_name',
    ],
]);
echo "</div>";
Pjax::end();
echo Html::a('Add leads', '#', ['class'=>'add-leads btn btn-success']);