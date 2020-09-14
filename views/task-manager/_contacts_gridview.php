<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

echo "<div style='margin-top: 10px'>";
Pjax::begin(['id' => 'pjax-contacts-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'contacts-gridview',
    'dataProvider' => $contactsDataProvider,
    'filterModel' => $contactsSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'ref',
        'first_name',
        'last_name',
    ],
]);
echo "</div>";
Pjax::end();
echo Html::a('Add contacts', '#', ['class'=>'add-contacts btn btn-success']);