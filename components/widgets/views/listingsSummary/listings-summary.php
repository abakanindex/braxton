<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;
use dosamigos\chartjs\ChartJs;
?>

<?php $this->registerCssFile('@web/new-design/css/listings_summary.css') ?>

<div id="summary-wrap" class="in aggregate-score-wrap" style=" margin: 10px 20px 10px 10px;">
    <style>
        p.summary-head {
            font-size: 15px;
        }
    </style>
    <input type="button" class="btn btn-info" value="<?= Yii::t('app', 'Detail View')?>" id="change-summary-view">

    <div id="summary-statistics-detail-view">
        <div class="row summary_row">
            <div class="col-sm-6" style="padding: 10px">
<!--                <div class="text-center">--><?//= Yii::t('app', 'Agent Listings')?><!--</div>-->
                <?= GridView::widget([
                    'dataProvider' => $data['topAgentsProvider'],
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => [
                        'class' => 'listings_row table table-bordered',
                    ],
                    'columns' => [
                        [
                            'label' => Yii::t('app', 'Agent'),
                            'value' => function($dataProvider) {
                                    $img = Html::img(
                                        '@web/new-design/img/user1-128x128.jpg',
                                        [
                                            'width'  => '30px',
                                            'height' => '30px',
                                            'class'  => 'img-circle'
                                        ]
                                    );
                                    return $img . $dataProvider['last_name'] . ' ' . $dataProvider['first_name'];
                                },
                            'format' => 'raw'
                        ],
                        'total'
                    ],
                ]);
                ?>
            </div>
            <div class="col-sm-6" style="padding: 10px">
<!--                <div class="text-center">--><?//= Yii::t('app', 'Category Dist.')?><!--</div>-->
                <?= ChartJs::widget([
                    'type' => 'pie',
                    //'id' => 'structurePie',
                    //'options' => [
                    //    'height' => 200,
                    //    'width' => 400,
                    //],
                    'data' => [
                        'radius' =>  "90%",
                        'labels' => $data['categoriesTitleData'], // Your labels
                        'datasets' => [
                            [
                                'data' => $data['categoriesPercentData'], // Your dataset
                                'label' => '',
                                'backgroundColor' => [
                                    '#ADC3FF',
                                    '#FF9A9A',
                                    'rgba(190, 124, 145, 0.8)'
                                ],
                                'borderColor' =>  [
                                    '#fff',
                                    '#fff',
                                    '#fff'
                                ],
                                'borderWidth' => 1,
                                'hoverBorderColor'=>["#999","#999","#999"],
                            ]
                        ]
                    ],
                    'clientOptions' => [
                        'legend' => [
                            'display' => true,
                            'position' => 'bottom',
                            'labels' => [
                                'fontSize' => 14,
                                'fontColor' => "#425062",
                            ]
                        ],
                        'tooltips' => [
                            'enabled' => true,
                            'intersect' => true
                        ],
                        'hover' => [
                            'mode' => false
                        ],
                        'maintainAspectRatio' => false,
                    ]
                ])?>
            </div>
        </div>
        <div class="row summary_row">
            <div class="col-sm-6" style="padding: 10px">
<!--                <div class="text-center">--><?//= Yii::t('app', 'Status Dist.')?><!--</div>-->
                <?= ChartJs::widget([
                    'type' => 'bar',
                    //'id' => 'structurePie',
                    //'options' => [
                    //    'height' => 200,
                    //    'width' => 400,
                    //],
                    'data' => [
                        'labels' => ['Unpublished', 'Published', 'Waiting Approval', 'Draft'], // Your labels
                        'datasets' => [
                            [
                                'data' => [$data['countUnPublished'], $data['countPublished'], $data['countPending'], $data['countDraft']], // Your dataset
                                'label' => '',
                                'backgroundColor' => [
                                    '#ADC3FF',
                                    '#FF9A9A',
                                    'rgba(190, 124, 145, 0.8)'
                                ],
                                'borderColor' =>  [
                                    '#fff',
                                    '#fff',
                                    '#fff'
                                ],
                                'borderWidth' => 1,
                                'hoverBorderColor'=>["#999","#999","#999"],
                            ]
                        ]
                    ],
                    'clientOptions' => [
                        'legend' => [
                            'display' => false,
                            'position' => 'bottom',
                            'labels' => [
                                'fontSize' => 14,
                                'fontColor' => "#425062",
                            ]
                        ],
                        'tooltips' => [
                            'enabled' => true,
                            'intersect' => true
                        ],
                        'hover' => [
                            'mode' => false
                        ],
                        'maintainAspectRatio' => false,
                    ]
                ])?>
            </div>
            <div class="col-sm-6" style="padding: 10px">
<!--                <div class="text-center">--><?//= Yii::t('app', 'Top Regions')?><!--</div>-->
                <?= GridView::widget([
                    'dataProvider' => $data['topRegionsProvider'],
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => [
                        'class' => 'listings_row table table-bordered',
                    ],
                    'columns' => [
                        [
                            'label' => Yii::t('app', 'Region'),
                            'value' => function($dataProvider) {
                                    return $dataProvider['name'];
                                }
                        ],
                        [
                            'label' => Yii::t('app', 'No. of Listings'),
                            'value' => function($dataProvider) {
                                    return $dataProvider['total'];
                                }
                        ]
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row summary_row">
            <div class="col-sm-6" style="padding: 10px">
<!--                <div class="text-center">--><?//= Yii::t('app', 'Price Range')?><!--</div>-->
                <?= ChartJs::widget([
                    'type' => 'pie',
                    //'id' => 'structurePie',
                    //'options' => [
                    //    'height' => 200,
                    //    'width' => 400,
                    //],
                    'data' => [
                        'radius' =>  "90%",
                        'labels' => $data['priceTitleData'], // Your labels
                        'datasets' => [
                            [
                                'data' => $data['pricePercentData'], // Your dataset
                                'label' => '',
                                'backgroundColor' => [
                                    '#ADC3FF',
                                    '#FF9A9A',
                                    'rgba(190, 124, 145, 0.8)'
                                ],
                                'borderColor' =>  [
                                    '#fff',
                                    '#fff',
                                    '#fff'
                                ],
                                'borderWidth' => 1,
                                'hoverBorderColor'=>["#999","#999","#999"],
                            ]
                        ]
                    ],
                    'clientOptions' => [
                        'legend' => [
                            'display' => true,
                            'position' => 'bottom',
                            'labels' => [
                                'fontSize' => 14,
                                'fontColor' => "#425062",
                            ]
                        ],
                        'tooltips' => [
                            'enabled' => true,
                            'intersect' => true
                        ],
                        'hover' => [
                            'mode' => false
                        ],
                        'maintainAspectRatio' => false,
                    ]
                ])?>
            </div>
            <div class="col-sm-6" style="padding: 10px">
<!--                <div class="text-center">--><?//= Yii::t('app', 'Top Locations')?><!--</div>-->
                <?= GridView::widget([
                    'dataProvider' => $data['topLocationsProvider'],
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => [
                        'class' => 'listings_row table table-bordered',
                    ],
                    'columns' => [
                        [
                            'label' => Yii::t('app', 'Location'),
                            'value' => function($dataProvider) {
                                    return $dataProvider['name'];
                                }
                        ],
                        [
                            'label' => Yii::t('app', 'No. of Listings'),
                            'value' => function($dataProvider) {
                                    return $dataProvider['total'];
                                }
                        ]
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>


    <div class="" id="summary-statistics-short-view">
        <div class="row summary_row">
            <div class="col-lg-4 col-sm-4 summary-column-xs">
                <div class="row">
                    <div class="col-sm-3 summary-label">
                        Agent Listings
                    </div>
                    <div class="col-sm-9">
                        <ul class="short-summary">
                            <?php foreach($data['topAgents'] as $tA):?>
                                <li style="">
                                    <?php
                                    echo Html::img(
                                        '@web/new-design/img/user1-128x128.jpg',
                                        [
                                            'width'  => '30px',
                                            'height' => '30px',
                                            'class'  => 'img-circle',
                                            'title'  => $tA['last_name'] . ' ' . $tA['first_name']
                                        ]
                                    );
                                    ?>
                                    <?= $tA['total']?>
                                </li>
                            <?php endforeach?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 summary-column-xs">
                <div class="row">
                    <div class="col-sm-3 summary-label">
                        Category Dist.
                    </div>
                    <div class="col-sm-9">
                        <div id="category_short" style="height: 50px;"
                             data-highcharts-chart="5">
                            <?php foreach($data['topCategories'] as $tC):?>
                                <span class="label label-success"><?= $tC['title']?>(<?= $tC['total']?>)</span>
                            <?php endforeach?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 summary-column-xs">
                <div class="row">
                    <div class="col-sm-3 summary-label">
                        Status Dist.
                    </div>
                    <div class="col-sm-9">
                        <ul class="short-summary">
                            <li>
                                <img src="https://crm.propspace.com/application/views/images/header_unpublish.png"
                                     title="Unpublished"
                                     style="margin-top: -3px;margin-right: 3px;">
                                <?= $data['countUnPublished']?>
                            </li>
                            <li>
                                <img src="https://crm.propspace.com/application/views/images/header_publish.png"
                                     title="Published"
                                     style="margin-top: -3px;margin-right: 3px;">
                                <?= $data['countPublished']?>
                            </li>
                            <li>
                                <img src="https://crm.propspace.com/application/views/images/header_unapproved.png"
                                     title="Waiting Approval"
                                     style="margin-top: -3px;margin-right: 3px;">
                                <?= $data['countPending']?>
                            </li>
                            <li>
                                <img src="https://crm.propspace.com/application/views/images/header_draft.png"
                                     title="Draft" style="margin-top: -3px;margin-right: 3px;">
                                <?= $data['countDraft']?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row summary_row no-border-bottom">
            <div class="col-lg-4 col-sm-4 summary-column-xs">
                <div class="row">
                    <div class="col-sm-3 summary-label">
                        Price Range
                    </div>
                    <div class="col-sm-9">
                        <div id="price_short" style="height: 50px;" data-highcharts-chart="6">
                            <span class="label label-warning">100k-150k(<?= $data['priceRange1']?>)</span>
                            <span class="label label-warning">200k-250k(<?= $data['priceRange2']?>)</span>
                            <span class="label label-warning">400k+(<?= $data['priceRange3']?>)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 summary-column-xs">
                <div class="row">
                    <div class="col-sm-3 summary-label">Top Regions</div>
                    <div class="col-sm-9">
                        <ul class="short-summary">
                            <?php foreach($data['topRegions'] as $tR):?>
                                <li>
                                    <i class="fa fa-map-marker" style="color: rgb(60,150,210)"></i>
                                    <?= $tR['name']?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 summary-column-xs">
                <div class="row">
                    <div class="col-sm-3 summary-label">
                        Top Locations
                    </div>
                    <div class="col-sm-9">
                        <ul class="short-summary">
                            <?php foreach($data['topLocations'] as $tL):?>
                                <li>
                                    <i class="fa fa-map-marker" style="color: rgb(60,150,210)"></i>
                                    <?= $tL['name']?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<JS
$(document).ready(function() {
    $("#summary-statistics-detail-view").hide();
    $("body").on("click", "#change-summary-view", function() {
        $("#summary-statistics-detail-view").fadeToggle();
        $("#summary-statistics-short-view").fadeToggle();
    })
})
JS;
$this->registerJs($script, View::POS_READY);
?>
