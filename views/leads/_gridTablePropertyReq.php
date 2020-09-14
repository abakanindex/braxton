<?php
use app\models\reference_books\PropertyCategory;
use kartik\grid\GridView;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\{ArrayHelper, Html, Url};
use yii\widgets\{Pjax, Breadcrumbs};
use kartik\select2\Select2;
use yii\jui\AutoComplete;
use yii;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout' => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'table table-bordered listings_row'
    ],
    'columns' => [
        [
            'format' => 'raw',
            'value' => function ($model)use ($urlView) {
                    $url = Yii::$app->getUrlManager()->createUrl([
                        $urlView,
                        'id'   => $model->lead->id,
                    ]);

                    return Html::a($model->lead->reference, $url, [
                        'data-pjax' => '0',
                        'target'     => '_blank'
                    ]);
                },
        ],
        [
            'attribute' => 'category_id',
            'value'     => 'category.title',
            'filter'    => Select2::widget([
                    'attribute' => 'category_id',
                    'model'     => $searchModel,
                    'theme'     => Select2::THEME_BOOTSTRAP,
                    'data'      => ArrayHelper::map(PropertyCategory::find()->all(), 'id', 'title'),
                    'options'   => ['placeholder' => '']
                ]),
        ],
        [
            'attribute' => 'emirate',
            'value'     => 'emirateRecord.name',
            'filter' => Select2::widget([
                'model'     => $searchModel,
                'attribute' => 'emirate',
                'theme'     => Select2::THEME_BOOTSTRAP,
                'data'      => $emiratesDropDown,
                'options'   => ['placeholder' => '']
            ]),
        ],
        [
            'attribute' => 'location',
            'value'     => 'locationRecord.name',
            'filter' => Select2::widget([
                'model'     => $searchModel,
                'attribute' => 'location',
                'theme'     => Select2::THEME_BOOTSTRAP,
                'data'      => $locationsSearch,
                'options'   => ['placeholder' => '']
            ]),
        ],
        [
            'attribute' => 'sub_location',
            'value'     => 'subLocationRecord.name',
            'filter' => Select2::widget([
                'model'     => $searchModel,
                'attribute' => 'sub_location',
                'theme'     => Select2::THEME_BOOTSTRAP,
                'data'      => $subLocationsSearch,
                'options'   => ['placeholder' => '']
            ]),
        ],
        'min_beds',
        'max_beds',
        'min_price',
        'max_price',
        'min_baths',
        'max_baths'
    ]
]);
?>