<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'username',
        'email:email',

        ['class' => 'yii\grid\ActionColumn',
            'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{permit}&nbsp;&nbsp;{delete}',
            'buttons' =>
                [
                    'permit' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-wrench"></span>', Url::to(['/permit/user/view', 'id' => $model->id]), [
                            'title' => Yii::t('yii', 'Change user role')
                        ]);
                    },
                ]
        ],
    ],
]);