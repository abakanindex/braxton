<?php
use yii\grid\GridView;
use \yii\helpers\Html;
use yii\helpers\Url;

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'item_name',
        'user.username',

    ],
]); ?>