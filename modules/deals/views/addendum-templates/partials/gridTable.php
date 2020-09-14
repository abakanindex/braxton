<?php
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\deals\models\Templates;
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
        'type' => [
            'header' => 'Addendum Type',
            'value' => function($dataProvider) {
                return Templates::getTypes()[$dataProvider->type];
            },
        ],
        'title' => [
            'header' => 'Addendum Title',
            'value' => 'title',
        ],
        'created_by' => [
            'header' => 'Created By',
            'value' => function($dataProvider) {
                if (is_numeric($dataProvider->created_by)) {
                    return $dataProvider->user->username;
                } else {
                    return $dataProvider->created_by;
                }
            },
        ],
        'created_at' => [
            'header' => 'Date Added',
            'value' => function($dataProvider) {
                return date('d-m-Y H:i:s', $dataProvider->created_at);
            },
        ],
        'updated_at' => [
            'header' => 'Date Updated',
            'value' => function($dataProvider) {
                return date('d-m-Y H:i:s', $dataProvider->updated_at);
            },
        ],
    ], $filteredColumns),
]);
?>