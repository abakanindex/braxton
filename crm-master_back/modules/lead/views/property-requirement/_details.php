<?php

use yii\widgets\DetailView;

?>

<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'category_id',
            'value' => $model->category->title,
        ],
        [
            'attribute' => 'emirate',
            'value'     => $model->emirateRecord->name
        ],
        [
            'attribute' => 'location',
            'value'     => $model->locationRecord->name
        ],
        [
            'attribute' => 'sub_location',
            'value'     => $model->subLocationRecord->name
        ],
        'min_beds',
        'max_beds',
        'min_price',
        'max_price',
        'min_area',
        'max_area',
        'min_baths',
        'max_baths',
        'unit_type',
        'unit'
    ],
]) ?>