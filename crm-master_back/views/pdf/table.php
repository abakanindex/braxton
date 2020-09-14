<?php
use Yii;
?>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $listDataProvider,
    'layout' => "{items}",
    'tableOptions' => [
        'class' => 'listings_row table table-bordered',
    ],
    'columns' => [
        'ref',
        [
            'label' => Yii::t('app', 'Type'),
            'value' => function($dataProvider) use ($type) {
                    return $type;
                }
        ],
        'name',
        'category_id' => [
            'attribute' => 'category',
            'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->category_id)) {
                        return $dataProvider->category->title;
                    } else {
                        return $dataProvider->category_id;
                    }
                }
        ],
        'region_id' => [
            'attribute' => 'emirate',
            'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->region_id)) {
                        return $dataProvider->emirate->name;
                    } else {
                        return $dataProvider->region_id;
                    }
                }
        ],
        'area_location_id' => [
            'attribute' => 'location',
            'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->area_location_id)) {
                        return $dataProvider->location->name;
                    } else {
                        return $dataProvider->area_location_id;
                    }
                }
        ],
        'sub_area_location_id' => [
            'attribute' => 'subLocation',
            'value' => function($dataProvider) {
                    if (is_numeric($dataProvider->sub_area_location_id)) {
                        return $dataProvider->subLocation->name;
                    } else {
                        return $dataProvider->sub_area_location_id;
                    }
                }
        ],
        'beds',
        'size',
        'price'
    ]
]);?>