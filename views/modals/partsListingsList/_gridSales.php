<?php
use yii\grid\GridView;
use yii\helpers\{Html, Url};
use app\modules\deals\models\Deals;
use yii\widgets\Pjax;

Pjax::begin(['id' => 'deals-sales-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'tableOptions' => [
        'class' => 'table_listing table table-bordered'
    ],
    'dataProvider' => $saleDataProvider,
    'filterModel' => $saleSearchModel,
    //'filterPosition' => false,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'class' => 'yii\grid\RadioButtonColumn',
            'radioOptions' => function ($model) {
                return [
                    'value' => $model->id,
                    'class' => 'select-listing-ref',
                    'data-ref' => $model->ref,
                    'data-type' => Deals::TYPE_SALES,
                ];
            }
        ],
        [
            'label' => 'Reference',
            'attribute' => 'ref',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a($model->ref,
                    Url::to(['/sale/view', 'id' => $model->id]),
                    ['target' => '_blank', 'data-pjax' => '0',]);
            }
        ],
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
            },
        ],
    ],
]);
Pjax::end();
