<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\deals\models\Deals;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-bordered listings_row',
        'id' => 'full-listing-table'
    ],
    'rowOptions'   => function ($model, $key, $index, $grid) use ($urlView) {
            $url = Yii::$app->getUrlManager()->createUrl([
                $urlView,
                'id' => $model['id']
            ]);
            $url = $url.'?page=' .
                (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page'));

            return [
                'data-url'    =>  $url,
                'class'       => 'full-listing-table-row'
            ];
        },
    'columns' => array_merge([
        /*['class' => 'yii\grid\SerialColumn'],*/
        [
            'class' => 'yii\grid\CheckboxColumn',
            'cssClass' => 'check-column-in-grid',
            'contentOptions' => ['class' => 'check-box-column']
        ],
        [
            'class'  => 'yii\grid\ActionColumn',
            'buttons'=>[
                'view' => function ($url, $model) use ($urlView, $topModel) {
                    $url = Yii::$app->getUrlManager()->createUrl([
                        $urlView,
                        'id'   => $model['id'],
                    ]);
                    return \yii\helpers\Html::a(
                        ($topModel->id == $model['id']) ? '<i class="fa fa-eye active"></i>' : '<i class="fa fa-eye"></i>',
                        $url.'?page=' .
                        (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page')),
                        [
                            'title'     => Yii::t('app', 'View'),
                            'data-pjax' => '1',
                            'pjax'      => '#result',
                            'class'     => 'view-contact'
                        ]
                    );
                }
            ],
            'template'=>'{view}',
        ],
        [
            'label' => 'Reference',
            'attribute' => 'ref',
            'value' => 'ref',
        ],
        [
            'label' => 'Type',
            'attribute' => 'type',
            'value' => function($dataProvider) {
                return Deals::getTypes()[$dataProvider->type];
            },
            'filter' => Html::activeDropDownList($searchModel,
                'type',
                Deals::getTypes(),
                ['class' => 'form-control', 'prompt' => '']
            )
        ],
//        [
//            'label' => 'Status',
//            'attribute' => 'status',
//            'value' => function($dataProvider) {
//                return Deals::getStatuses()[$dataProvider->status];
//            },
//            'filter' => Html::activeDropDownList($searchModel,
//                'status',
//                Deals::getStatuses(),
//                ['class' => 'form-control', 'prompt' => '']
//            )
//        ],
//        [
//            'label' => 'Sub Status',
//            'attribute' => 'sub_status',
//            'value' => function($dataProvider) {
//                return Deals::getSubStatuses()[$dataProvider->sub_status];
//            },
//            'filter' => Html::activeDropDownList($searchModel,
//                'sub_status',
//                Deals::getSubStatuses(),
//                ['class' => 'form-control', 'prompt' => '']
//            )
//        ],
        [
            'label' => 'Buyer/Tenant',
            'attribute' => 'buyer_id',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->buyer_id)) {
                    return $dataProvider->buyer->username;
                } else {
                    return $dataProvider->buyer_id;
                }
            },
        ],
        [
            'label' => 'Seller/Landlord',
            'attribute' => 'seller_id',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->seller_id)) {
                    return $dataProvider->seller->username;
                } else {
                    return $dataProvider->seller_id;
                }
            },
        ],
        [
            'label' => 'Price',
            'attribute' => 'deal_price',
            'value' => 'deal_price',
        ],
        [
            'label' => 'Agent 1',
            'attribute' => 'agent_1',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->agent_1)) {
                    return $dataProvider->agent1->username;
                } else {
                    return $dataProvider->agent_1;
                }
            },
        ],
        [
            'label' => 'Source',
            'attribute' => 'lead_id',
            'value' => function($dataProvider) use ($source) {
                return $source[$dataProvider->lead->source];
            },
            'filter' => Html::activeDropDownList($searchModel,
                'lead_id',
                $source,
                ['class' => 'form-control', 'prompt' => '']
            )
        ],
    ], $filteredColumns),
]);
?>
