<?php
use yii\helpers\{Html, Url};
use kartik\grid\GridView;

echo GridView::widget([
    'dataProvider' => $provider,
    'layout' => "{items}\n{pager}",
    'tableOptions' => [
        'class' => 'listings_row table table-bordered',
    ],
    'columns' => [
        [
            'format'    => 'raw',
            'attribute' => 'contact.ref',
            'value'     => function($model) {
                    return Html::a($model->contact->ref, Url::to(['/contacts/view', 'id' => $model->landlord_id]), ['target' => '_blank', 'data-pjax' => 0]);
                }
        ],
        [
            'attribute' => 'contact.last_name',
            'value'     => function($model) {
                    return $model->contact->last_name;
                }
        ],
        [
            'attribute' => 'contact.first_name',
            'value'     => function($model) {
                    return $model->contact->first_name;
                }
        ]
    ],
]);
?>