<?php

use app\modules\reports\components\ColorSerialColumn;
use rmrevin\yii\fontawesome\FA;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var $provider
 * @var $reportType
 */

Pjax::begin(['id' => $reportType . '-report-gridview', 'clientOptions' => []]);
echo GridView::widget([
    'dataProvider' => $provider,
    'summary' => "Showing {begin} - {end} of $provider->totalCount items",
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
    'columns' => [
        [
            'header' => '',
            'class' => ColorSerialColumn::class
        ],
        [
            'header' => 'Location',
            'value' => function ($model) {
                if (is_numeric($model->area_location_id))
                    return $model->location->name;
                else
                    return $model->area_location_id;
            },
        ],
        'number',
        [
            'attribute' => 'distribution',
            'value' => function ($model) use ($provider) {
                $totalViewings = $provider->pagination->params['totalNumber'];
                if ($totalViewings)
                    return round((float)($model->number / $totalViewings) * 100, 2) . '%';
                else
                    return '';
            },
        ],
    ],
]);
?>
<div class="distribution-block">
    <?php if ($provider->pagination->params['page'] < 2) : ?>
    <h4><?= Yii::t('app', 'Distribution of Sales') ?></h4>
    <a class="show-chart show-pie-chart-report btn btn-default"
       href="#"><?php echo FA::icon('pie-chart')->border(); ?></a>
    <a class="show-chart show-bar-chart-report btn btn-default"
       href="#"><?php echo FA::icon('bar-chart') ?></a>

    <div class="distribution-pie distribution-tab" style="height: 400px">
        <?php
        echo $this->render($viewsPath . 'charts/sales_by_location__pie', ['provider' => $provider]);
        ?>
    </div>
    <div class="distribution-bar distribution-tab" style="display: none; height: 400px">
        <?php
        echo $this->render($viewsPath . 'charts/sales_by_location__bar', ['provider' => $provider]);
        ?>
    </div>
    <?php endif; ?>
</div>
<?php Pjax::end(); ?>