<?php
use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

echo GridView::widget([
    'dataProvider' => $usersDataProvider,
    'filterModel' => $usersSearchModel,
    'layout' => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'listings_row table table-bordered',
    ],
    'columns' => [
        [
            'class' => 'yii\grid\RadioButtonColumn',
            'radioOptions' => function ($model) {
                    return [
                        'value' => $model->id,
                        'class' => 'select-assigned-to',
                        'data-username' => $model->username
                    ];
                }
        ],
        [
            'label' => 'User Name',
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function($model) {
                    return Html::a($model->username,
                        Url::to(['/users/user-settings/view', 'id' => $model->id]),
                        ['target' => '_blank', 'data-pjax' => '0',]);
                }
        ],
        'last_name',
        'first_name',
        'job_title',
        'office_no',
        'mobile_no',
        'email'
    ],
]);
