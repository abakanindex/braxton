<?php

use app\modules\reports\models\Reports;
use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$dateTypes = Reports::getDateTypeArray();
?>
<h3><?php echo Yii::t('app', 'My saved reports') . ' (' . ucwords(Yii::t('app', $typeTitle)) . ') ' ?></h3>
<div class="reports-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, ['main/report', 'id' => $model->url_id]);
                },
            ],
            'description:ntext',
            [
                'attribute' => 'date_type',
                'value' => function ($model) {
                    return Reports::getDateTypeTitle($model->date_type);
                },
                'filter' => $dateTypes
            ],
            [
                'attribute' => 'interval',
                'format' => 'text',
                'filter' => false,
                'content' => function ($model) {
                    if ($model->date_type == Reports::DATE_TYPE_TIME)
                        return Yii::$app->formatter->asDatetime($model->date_from, "php:Y-m-d")
                            . ' to ' . Yii::$app->formatter->asDatetime($model->date_to, "php:Y-m-d");
                    else return '';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        if ($model->menu_item == Reports::MENU_ITEM) return 'menu item';
                        $url = Url::to(['/reports/main/delete', 'id' => $model->url_id, 'type' => Yii::$app->request->queryParams->type]);
                        return Html::a(Yii::t('yii', 'Delete'), '#', [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'onclick' => "
                                var thItem = $(this).closest('tr'); 
                                if (confirm('" . Yii::t('yii', 'Delete this report') . "')) {
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
</div>