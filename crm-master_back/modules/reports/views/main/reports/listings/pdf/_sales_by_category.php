<?php

use app\modules\reports\components\ColorSerialColumn;
use dosamigos\chartjs\ChartJs;
use rmrevin\yii\fontawesome\FA;
use yii\grid\GridView;
use yii\widgets\Pjax;

echo '<h2 style="margin-top: 0px;">' . Yii::t('app', 'Report') . ' - ' . $report->name . '</h2>';
echo '<p>' . $report->description . '</p>';
echo '<p>' . Yii::t('app', 'Generated ') . ' ' . date('Y/m/d H:i:s') . '</p>';
echo '<h3>' . Yii::t('app', 'Summary') . '</h3>';
echo GridView::widget([
    'dataProvider' => $provider,
    'summary' => "Showing {begin} - {end} of $provider->totalCount items",
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
    'columns' => [
        [
            'header' => '',
            'class' => ColorSerialColumn::class
        ],
        'category',
        'number',
        [
            'attribute' => 'distribution',
            'value' => function ($model) use ($provider) {
                $totalViewings = $provider->pagination->params['totalNumber'];
                if ($totalViewings)
                    return round((float)($model->number / $totalViewings) * 100) . '%';
                else
                    return '';
            },
        ],
    ],
]);
?>

<div class="distribution-block">
    <h4><?= Yii::t('app', 'Distribution of Sales') ?>
        <h4>
            <?php
            $pageCounter = $provider->pagination->params['page'];
            $perPageCounter = $provider->pagination->params['per-page'];
            $items = $provider->getModels();
            $allColors = ['#1FCE6E', '#298ED2', '#F3AC5A', '#9D6CE1', '#21C2C5', '#E3071C', '#FFEA00', '#ED74BE', '#A1887F', '#B9BE29', '#C7C7C7'];
            ?>
            <div class="distribution-pie distribution-tab  distribution-pie-pdf" style="width: 600px">
                <?php
                $labels = [];
                $data = [];
                $backgroundColors = [];
                $startCounter = ($pageCounter - 1) * $perPageCounter;
                foreach ($items as $item) {
                    $backgroundColors[] = $allColors[$startCounter];
                    $labels[] = $item->category;
                    $data[] = $item->number;
                    if ($startCounter < 10)
                        $startCounter++;
                }
                echo ChartJs::widget([
                    'type' => 'pie',
                    'data' => [
                        'labels' => $labels,
                        'datasets' => [
                            [
                                'data' => $data,
                                'backgroundColor' => $backgroundColors,

                            ],
                        ],
                    ],
                    'options' => [
                        'height' => 200,
                        'width' => 500,
                    ],

                ]); ?>
            </div>
</div>