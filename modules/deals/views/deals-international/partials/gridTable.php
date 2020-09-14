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
        'ref' => [
            'header' => 'Reference',
            'value' => 'ref',
        ],
        'type' => [
            'header' => 'Type',
            'value' => function($dataProvider) {
                return Deals::getTypes()[$dataProvider->type];
            },
        ],
        'status' => [
            'header' => 'Status',
            'value' => function($dataProvider) {
                return Deals::getStatuses()[$dataProvider->status];
            },
        ],
        'sub_status' => [
            'header' => 'Sub Status',
            'value' => function($dataProvider) {
                return Deals::getSubStatuses()[$dataProvider->sub_status];
            },
        ],
        'buyer_id' => [
            'header' => 'Buyer/Tenant',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->buyer_id)) {
                    return $dataProvider->buyer->username;
                } else {
                    return $dataProvider->buyer_id;
                }
            },
        ],
        'seller_id' => [
            'header' => 'Seller/Landlord',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->seller_id)) {
                    return $dataProvider->seller->username;
                } else {
                    return $dataProvider->seller_id;
                }
            },
        ],
        'deal_price' => [
            'header' => 'Price',
            'value' => 'deal_price',
        ],
        'agent_1' => [
            'header' => 'Agent 1',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->agent_1)) {
                    return $dataProvider->agent1->username;
                } else {
                    return $dataProvider->agent_1;
                }
            },
        ],
        'source' => [
            'header' => 'Source',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->source)) {
                    return $dataProvider->sourceModel->source;
                } else {
                    return $dataProvider->source;
                }
            },
        ],
    ], $filteredColumns),
]);
?>