<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
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
            'class' => 'yii\grid\ActionColumn',
            'buttons'=>[
                'view'=>function ($url, $model) use ($urlView, $topModel) {
                        $url = Yii::$app->getUrlManager()->createUrl([
                            $urlView,
                            'id' => $model['id']
                        ]);
                        return \yii\helpers\Html::a(
                            ($topModel->id == $model['id']) ? '<i class="fa fa-eye active"></i>' : '<i class="fa fa-eye"></i>',
                            $url.'?page=' .
                            (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page')),
                            [
                                'title' => Yii::t('app', 'View'),
                                'data-pjax' => true,
                                'pjax' => '#result',
                                'class' => 'view-contact'
                            ]
                        );
                    }
            ],
            'template'=>'{view}',
        ],
        [
            'label' =>  Yii::t('app', 'Assigned to'),
            'attribute' => 'assigned_to',
            'value' => function ($dataProvider) use ($agents) {
                return $agents[$dataProvider->assigned_to];
            },
            'filter' =>  Html::activeDropDownList($searchModel, 'assigned_to', $agents, ['class' => 'form-control', 'prompt' => '']),
        ],
        'ref',
        [
            'label' =>  Yii::t('app', 'Title'),
            'attribute' => 'title',
            'value' => function ($dataProvider) use ($titleModel) {
                    if ($dataProvider->title) {
                        $title = $titleModel::findOne($dataProvider->title);
                        if ($title) {
                            return $title->titles;
                        } else {
                            return "not set";
                        }
                    }
                },
            'filter' =>  Html::activeDropDownList($searchModel, 'title', $titles, ['class' => 'form-control', 'prompt' => ''])
        ],
        'first_name',
        'last_name'
    ], $filteredColumns)
]); ?>