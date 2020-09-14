<?php
use yii\grid\GridView;
use yii\widgets\Pjax;

Pjax::begin(['id' => 'viewings-sales-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'tableOptions' => [
        'class' => 'table_listing table table-bordered'
    ],
    'dataProvider' => $saleDataProvider,
    'filterModel' => $saleSearchModel,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'class' => 'yii\grid\RadioButtonColumn',
            'radioOptions' => function ($model) {
                    return [
                        'value' => $model->ref,
                        'class' => 'radio-select-viewing-item'
                    ];
                }
        ],
        'ref',
        'status',
        'beds',
        'size',
        'price',
        [
            'label' => 'Assigned To',
            'attribute' => 'agent_id',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->agent_id)) {
                    return $dataProvider->assignedTo->username;
                } else {
                    return $dataProvider->agent_id;
                }
            }
        ],
    ],
]);
Pjax::end();
