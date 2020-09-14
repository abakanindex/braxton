<?php

use app\modules\reports\components\ColorSerialColumn;
use app\modules\reports\models\Reports;
use app\modules\reports\widgets\ReportWidget;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

echo Html::dropDownList('type', null, ReportWidget::getStandartTypes(), ['id' => 'standart-widget-types-' . $report->url_id]);
?>
    <div id="<?= $report->url_id ?>-widget-content">
        <?php if ($provider->totalCount == 0) { ?>
            <div class="alert alert-warning no-results-found"
                 style="margin-top:10px"><?= Yii::t('app', 'No results found') ?></div>
        <?php } else { ?>
            <div id="widget-chart-<?= $report->url_id ?>">
                <canvas width="500" height="200" id="<?= $report->url_id ?>-widget-pie-canvas"></canvas>
            </div>
            <div id="widget-table-<?= $report->url_id ?>" style="display: none">
                <?php
                Pjax::begin(['id' => $report->url_id . '-report-widget-gridview']);
                echo GridView::widget([
                    'dataProvider' => $provider,
                    'summary' => "Showing {begin} - {end} of $provider->totalCount items",
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'columns' => [
                        [
                            'header' => '',
                            'class' => ColorSerialColumn::className()
                        ],
                        [
                            'attribute' => 'priority',
                            'value' => function ($model) use ($provider) {
                                return $model->getPriority();
                            },
                        ],
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
                        ]
                    ],
                    'pager' => [
                        'pageCssClass' => 'widget-gridview-page',
                        'prevPageCssClass' => 'prev widget-gridview-page',
                        'nextPageCssClass' => 'next widget-gridview-page',
                    ],
                ]);
                Pjax::end();
                ?>
            </div>
        <?php } ?>
    </div>
<?php
$chartUrl = Url::to(['/reports/report-widget/tasks-priority-charts', 'id' => $report->url_id]);
$allColorsJsArray = json_encode(Reports::$allColors);
$typePieChart = ReportWidget::TYPE_PIE_CHART;
$typeColumnChart = ReportWidget::TYPE_COLUMN_CHART;
$typeTable = ReportWidget::TYPE_TABLE;
$widgetId = $dashboardWidget->id;
${"script" . $report->url_id} = <<< JS
var widgetCharts = {};

$('#standart-widget-types-$report->url_id').on('change', function() { 
  if( this.value == $typePieChart )
      getTasksPriorityChartData('pie', '$chartUrl', '$report->url_id');
  else if( this.value == $typeColumnChart )
      getTasksPriorityChartData('bar', '$chartUrl', '$report->url_id');
  else if( this.value == $typeTable ) {
      $( '#widget-chart-$report->url_id' ).hide();
      $( '#widget-table-$report->url_id' ).show();
  }
});       
     
$( '#report-widget-content-$widgetId' ).on( "showwidget", function(e) {
    getTasksPriorityChartData('pie', '$chartUrl', '$report->url_id');   
});                    

getTasksPriorityChartData('pie', '$chartUrl', '$report->url_id');
 

function getTasksPriorityChartData(type, url, reportId) {       
    $.getJSON(url, function(response) { 
     $( '#widget-table-'+reportId ).hide();
     $( '#widget-chart-'+reportId ).show();
      var labels = [];
      var data = [];
      var colors = [];
      var allColorsJsArray = $allColorsJsArray; 
      var startCounter = 0;
      $.each(response, function(key, val) { 
       labels.push( val.priority );
       data.push( val.number );
       colors.push(allColorsJsArray[startCounter]); 
       if (startCounter < 10)
        startCounter++;
     });    
     var ctx = $('#' + reportId + '-widget-pie-canvas');
     if ( type === 'pie' ) {
         if (widgetCharts[reportId])
            widgetCharts[reportId].destroy();     
         var chart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: labels,
              datasets: [{
                  backgroundColor: colors,
                  data: data,
              }]
          },
          options: {
              maintainAspectRatio: false,
          }
      }); 
      widgetCharts[reportId] = chart;
     } else if ( type === 'bar' ) {
        if (widgetCharts[reportId])
            widgetCharts[reportId].destroy();
        var chart = new Chart(ctx, {
        type: 'bar', 
        data: {
          labels: labels,
          datasets: [
            {
              backgroundColor: colors, 
              data: data 
            }
          ]
        },
        options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                                }
                            }]
                    }
                  } 
        });
        widgetCharts[reportId] = chart;
      }     
    });
} 

JS;
$this->registerJs(${"script" . $report->url_id}, yii\web\View::POS_READY);