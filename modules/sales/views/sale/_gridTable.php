<?php

use app\models\reference_books\PropertyCategory;
use yii\helpers\{ArrayHelper, Html, Url};
use kartik\grid\GridView;
use app\models\Sale;
use kartik\select2\Select2;
use yii\jui\AutoComplete;


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
        (
            empty(Yii::$app->request->queryString) ?
                $url =  $url .'?page=' .
                (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page'))
            :
                $url =  $url . '?'. Yii::$app->request->queryString

        );

        return [
            'data-url'    =>  $url,
            'class'       => 'full-listing-table-row'
        ];
    },
    'columns' => array_merge([
        /*['class' => 'yii\grid\SerialColumn'],*/
        [
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function($model) {
                    return [
                        'data-ref'       => $model->ref,
                        'data-owner-url' => Url::toRoute(['/contacts/view', 'id' => $model->landlord_id])
                    ];
                },
            'cssClass' => 'check-column-in-grid',
            'contentOptions' => [
                'class' => 'check-box-column'
            ]
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
                                (
                                    empty(Yii::$app->request->queryString) ?
                                        $url .'?page=' .
                                        (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page'))
                                    :
                                        $url . '?'. Yii::$app->request->queryString

                                ),
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
            'attribute' => 'ref',
            'filter' => Select2::widget([
                'model'     => $searchModel,
                'attribute' => 'ref',
                'theme'     => Select2::THEME_BOOTSTRAP,
                'data' => ArrayHelper::map($sales, 'ref','ref'),
                'options'   => ['placeholder' => '']
            ]),
        ],
        [
            'attribute' => 'status',
            'filter' => Html::activeDropDownList($searchModel,
                    'status',
                    [
                        'Published'   => Yii::t('app', 'Published'),
                        'Unpublished' => Yii::t('app', 'Unpublished'),
                        'Draft'       => Yii::t('app', 'Draft'),
                        'Pending'     => Yii::t('app', 'Pending')
                    ],
                    ['class' => 'form-control', 'prompt' => '']
                )
        ],
        'unit' => [
            'attribute' => 'unit',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'unit',
                'theme' => Select2::THEME_BOOTSTRAP,
                'data' => ArrayHelper::map($sales, 'unit', 'unit'),
                'options' => ['placeholder' => '']
            ]),
        ],
        'category_id' => [
            'attribute' => 'category_id',
            'value' => function($dataProvider) use ($category) {
                    if (is_numeric($dataProvider->category_id)) {
                        return $category[$dataProvider->category_id];
                    } else {
                        return $dataProvider->category_id;
                    }
                },
            'filter' => Html::activeDropDownList($searchModel,
                    'category_id',
                    $category,
                    ['class' => 'form-control', 'prompt' => '']
                )
        ],
        'region_id' => [
            'attribute' => 'region_id',
            'value' => function($dataProvider) use ($emiratesDropDown) {
                    if (is_numeric($dataProvider->region_id)) {
                        return $emiratesDropDown[$dataProvider->region_id];
                    } else {
                        return $dataProvider->region_id;
                    }
                },
            'filter' => Select2::widget([
                    'model'     => $searchModel,
                    'attribute' => 'region_id',
                    'theme'     => Select2::THEME_BOOTSTRAP,
                    'data'      => $emiratesDropDown,
                    'options'   => ['placeholder' => '']
                ]),
            'headerOptions' => [
                'style' => 'width: 120px;'
            ]
        ],
        'area_location_id' => [
            'attribute' => 'area_location_id',
            'value' => function($dataProvider) use ($locationDropDown) {
                    if (is_numeric($dataProvider->area_location_id)) {
                        return $locationDropDown[$dataProvider->area_location_id];
                    } else {
                        return $dataProvider->area_location_id;
                    }
                },
            'filter' => Select2::widget([
                    'model'     => $searchModel,
                    'attribute' => 'area_location_id',
                    'theme'     => Select2::THEME_BOOTSTRAP,
                    'data'      => $locationsSearch,
                    'options'   => ['placeholder' => '']
                ]),
            'headerOptions' => [
                'style' => 'width: 120px'
            ]
        ],
        'sub_area_location_id' => [
            'attribute' => 'sub_area_location_id',
            'value' => function($dataProvider) use ($subLocationDropDown) {
                    if (is_numeric($dataProvider->sub_area_location_id)) {
                        return $subLocationDropDown[$dataProvider->sub_area_location_id];
                    } else {
                        return $dataProvider->sub_area_location_id;
                    }
                },
            'filter' => Select2::widget([
                    'model'     => $searchModel,
                    'attribute' => 'sub_area_location_id',
                    'theme'     => Select2::THEME_BOOTSTRAP,
                    'data'      => $subLocationsSearch,
                    'options'   => ['placeholder' => '']
                ]),
            'headerOptions' => [
                'style' => 'width: 120px'
            ]
        ]
    ], $filteredColumns),
]);
?>