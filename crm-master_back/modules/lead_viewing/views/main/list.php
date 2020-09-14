<?php

use app\models\Rentals;
use app\models\Sale;
use app\modules\lead_viewing\models\LeadViewing;
use app\modules\lead_viewing\models\LeadViewingProperty;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lead_viewing\models\LeadViewingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lead Viewings');
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('_lead-viewings-modals', [
    'salesSearchModel' => $leadViewingSalesSearchModel,
    'salesDataProvider' => $leadViewingSalesDataProvider,
    'rentalsSearchModel' => $leadViewingRentalsSearchModel,
    'rentalsDataProvider' => $leadViewingRentalsDataProvider,
]);
?>

<div class="lead-viewing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterPosition' => ' ',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => Yii::t('app', 'Lead'),
                'headerOptions' => ['style' => 'width:10%'],
                'contentOptions' => ['style' => 'width: 10%;'],
                'attribute' => 'lead_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a( $model->lead->reference, ['/leads/' . $model->lead->reference]);
                }
            ],
            [
                'attribute' => 'time',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'leadViewingSales',
                'format' => 'raw',
                'value' => function ($model) {
                    if (count($model->sales) == 0) return '';
                    $html = '<ul style="list-style: none">';
                    foreach ($model->sales as $saleViewing) {
                        if ($saleViewing->type == LeadViewingProperty::TYPE_SALE) {
                            $sale = Sale::findOne(['id' => $saleViewing->property_id]);
                            $html .= '<li style="margin-top: 2px; margin-bottom: 5px;">'
                                . Html::a($sale->ref, ['/sale/view', 'id' => $sale->id]) . '</li>';
                        }
                    }
                    $html .= '</ul>';
                    return $html;
                },
            ],
            [
                'attribute' => 'leadViewingRentals',
                'format' => 'raw',
                'value' => function ($model) {
                    if (count($model->rentals) == 0) return '';
                    $html = '<ul style="list-style: none">';
                    foreach ($model->rentals as $rentalsViewing) {
                        if ($rentalsViewing->type == LeadViewingProperty::TYPE_RENTALS) {
                            $rental = Rentals::findOne(['id' => $rentalsViewing->property_id]);
                            $html .= '<li style="margin-top: 2px; margin-bottom: 5px;">'
                                . Html::a($rental->ref, ['/rentals/view', 'id' => $rental->id]) . '</li>';
                        }
                    }
                    $html .= '</ul>';
                    return $html;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $leadViewingUrl = Url::to(['/lead_viewing/main/view', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['main/view', 'id' => $model->id], [
                            'title' => Yii::t('app', 'View Lead Viewing'),
                            'class' => 'btn btn-default'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        $leadViewingUrl = Url::to(['/lead_viewing/main/index-list', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#', [
                            'title' => Yii::t('app', 'Update Lead Viewing'),
                            'class' => 'btn btn-default',
                            'onclick' => "   
                                $('#modal-viewing-content').load('$leadViewingUrl', function() {
                                    $('#modal-viewing').modal('show'); 
                                });
                                return false;
                            ",
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['/lead_viewing/main/delete', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', '#', [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'onclick' => "
                                var thItem = $(this).closest('tr'); 
                                if (confirm('" . Yii::t('app', 'Delete this lead viewing') . "')) {
                                    $.ajax('$url', {
                                        type: 'POST'
                                    }).done(function(data) { 
                                    if ( data.result == 'success' )
                                        thItem.remove();   
                                    });
                                }
                                return false;
                            ",
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>