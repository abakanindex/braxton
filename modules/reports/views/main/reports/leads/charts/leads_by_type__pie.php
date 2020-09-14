<?php

use dosamigos\chartjs\ChartJs;

/**
 * @var $provider
 */

$pageCounter = $provider->pagination->params['page'];
$perPageCounter = $provider->pagination->params['per-page'];
$items = $provider->getModels();
$allColors = ['#1FCE6E', '#298ED2', '#F3AC5A', '#9D6CE1', '#21C2C5', '#E3071C', '#FFEA00', '#ED74BE', '#A1887F', '#B9BE29', '#C7C7C7'];

$labels = [];
$data = [];
$backgroundColors = [];
$startCounter = ($pageCounter - 1) * $perPageCounter;
foreach ($items as $item) {
    $backgroundColors[] = $allColors[$startCounter];
    $labels[] = $item->getType();
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

]);
