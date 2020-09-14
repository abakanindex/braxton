<?php

use app\components\widgets\PersonalAssistantWidget;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use app\components\widgets\TaskManagerDashboardWidget;
use app\components\widgets\ChartDashboardWidget;
use app\components\widgets\CalendarDashboardWidget;
use app\components\widgets\SmallBoxWidget;
use app\components\widgets\MyReminderDashboardWidget;
use app\components\widgets\MyViewingsWidget;
use yii\web\View;


/**
 * @var $this yii\web\View
 * @var array $tasks
 * @var int $taskPages
 * @var string $jsonSalesRentalsByMonth
 * @var string $leadersJson
 * @var array $reminders
 * @var int $reminderPages
 * @var array $daysStartEvents
 * @var $tasksCalendar
 * @var $viewingsCalendar
 */

$this->title = 'SystaVision CRM';
?>
<?php $this->registerCssFile('@web/new-design/css/index_page.css') ?>

<br/>
<!-- Small boxes (Stat box) -->
<div class="row">

    <!-- Left col -->
    <div class="col-lg-6 col-sm-12 connectedSortable">
        <!-- My Chart -->
        <?php
            echo ChartDashboardWidget::widget([
                    'type'    => 'success',
                    'title'   => Yii::t('app', 'Sales and Rentals by Month'),
                    'boxBody' => '<canvas id="chart-by-month" width="auto" height="270"></canvas>',
            ]);
        ?>


        <!-- TaskManager -->
        <?php
            echo TaskManagerDashboardWidget::widget([
                    'tasks' => $tasks,
                    'taskPages' => $taskPages,
            ]);
        ?>

        <!-- My Viewings -->
        <?php
        echo MyViewingsWidget::widget([]);
        ?>
    </div>
    <!-- /.Left col -->


    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <div class="col-lg-6 col-sm-12 connectedSortable">

        <!-- Most Listings By Users Chart -->
        <?php
            echo ChartDashboardWidget::widget([
                'type'  => 'warning',
                'title' => 'Most Listings By Users',
                'boxBody' => '<canvas id="canvas" width="auto" height="270"></canvas>',
            ]);
        ?>

        <!-- Calendar -->
        <?php
            echo CalendarDashboardWidget::widget([
                'daysStartEvents' => $daysStartEvents,
                'tasksCalendar' => $tasksCalendar,
                'viewingsCalendar' => $viewingsCalendar,
            ]);
        ?>

        <!-- My Reminder -->
        <?php
            echo MyReminderDashboardWidget::widget([
                    'reminders' => $reminders,
                    'reminderPages' => $reminderPages,
            ]);
        ?>
    </div>
    <!-- right col -->
</div>

<?php
$script = <<< JS
$(function () {
    'use strict';
    var jsonSalesRentalsByMonth = JSON.parse('$jsonSalesRentalsByMonth');
    var sale = jsonSalesRentalsByMonth.sale;
    var rental = jsonSalesRentalsByMonth.rental;
    /**
    * report sales and rentals for year
    */
   var ctx = document.getElementById("chart-by-month");
   var myChart = new Chart(ctx, {
       type: 'line',
       data: {
           labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
           datasets: [{
               label: '# Sales',
               data: [
                   sale['1'] ? sale['1'] : '0',
                   sale['2'] ? sale['2'] : '0',
                   sale['3'] ? sale['3'] : '0',
                   sale['4'] ? sale['4'] : '0',
                   sale['5'] ? sale['5'] : '0',
                   sale['6'] ? sale['6'] : '0',
                   sale['7'] ? sale['7'] : '0',
                   sale['8'] ? sale['8'] : '0',
                   sale['9'] ? sale['9'] : '0',
                   sale['10'] ? sale['10'] : '0',
                   sale['11'] ? sale['11'] : '0',
                   sale['12'] ? sale['12'] : '0'
               ],
               backgroundColor: [
                   'rgba(255, 99, 132, 0.2)',
                   'rgba(54, 162, 235, 0.2)',
                   'rgba(255, 206, 86, 0.2)',
                   'rgba(75, 192, 192, 0.2)',
                   'rgba(153, 102, 255, 0.2)',
                   'rgba(255, 159, 64, 0.2)'
               ],
               borderColor: [
                   'rgba(255,99,132,1)',
                   'rgba(54, 162, 235, 1)',
                   'rgba(255, 206, 86, 1)',
                   'rgba(75, 192, 192, 1)',
                   'rgba(153, 102, 255, 1)',
                   'rgba(255, 159, 64, 1)'
               ],

               borderWidth: 1

           },
               {
                   label: '# Rentals',
                   data: [
                       rental['1'] ? rental['1'] : '0',
                       rental['2'] ? rental['2'] : '0',
                       rental['3'] ? rental['3'] : '0',
                       rental['4'] ? rental['4'] : '0',
                       rental['5'] ? rental['5'] : '0',
                       rental['6'] ? rental['6'] : '0',
                       rental['7'] ? rental['7'] : '0',
                       rental['8'] ? rental['8'] : '0',
                       rental['9'] ? rental['9'] : '0',
                       rental['10'] ? rental['10'] : '0',
                       rental['11'] ? rental['11'] : '0',
                       rental['12'] ? rental['12'] : '0'
                   ],
                   backgroundColor: [
                       'rgba(78, 78, 222, 0.2)',
                       'rgba(54, 162, 235, 0.2)',
                       'rgba(255, 206, 86, 0.2)',
                       'rgba(75, 192, 192, 0.2)',
                       'rgba(153, 102, 255, 0.2)',
                       'rgba(255, 159, 64, 0.2)'
                   ],
                   borderColor: [
                       'rgba(255,99,132,1)',
                       'rgba(54, 162, 235, 1)',
                       'rgba(255, 206, 86, 1)',
                       'rgba(75, 192, 192, 1)',
                       'rgba(153, 102, 255, 1)',
                       'rgba(255, 159, 64, 1)'
                   ],

                   borderWidth: 1

               }]
       },
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero: true
                   }
               }]
           }
       }
   });
});

$(function () {
    'use strict';
    var json = JSON.parse('$leadersJson');
    var list = json;
    var i = 0;
    var data = [];
    var key;

    var keys = Object.keys(list).sort(function(a,b){return list[a]-list[b]});
    
    for(key in json) {
        data[i] = json[key];
        i++;
    }
    
   var ctx = document.getElementById("canvas").getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'bar',       
       data: {
           labels: keys,               
           datasets: [{
               label: 'listings', 
               data: data, 
               backgroundColor: [
                   'rgba(255, 99, 132, 0.2)',
                   'rgba(54, 162, 235, 0.2)',
                   'rgba(255, 206, 86, 0.2)',
                   'rgba(75, 192, 192, 0.2)',
                   'rgba(153, 102, 255, 0.2)',
                   'rgba(255, 159, 64, 0.2)',
                   'rgba(102, 224, 36, 0.2)',
                   'rgba(245, 214, 61, 0.2)',
                   'rgba(194, 76, 145, 0.2)',
                   'rgba(65, 232, 224, 0.2)'
               ],
               borderColor: [
                   'rgba(255,99,132,1)',
                   'rgba(54, 162, 235, 1)',
                   'rgba(255, 206, 86, 1)',
                   'rgba(75, 192, 192, 1)',
                   'rgba(153, 102, 255,1)',
                   'rgba(255, 159, 64, 1)',
                   'rgba(102, 224, 36, 1)',
                   'rgba(245, 214, 61, 1)',
                   'rgba(194, 76, 145, 1)',
                   'rgba(65, 232, 224, 1)'
               ],
               
               borderWidth: 1
           
           }]
       }, 
           
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero:true
                   }
               }]
           },
            title: {
                display: true,
                text: 'Most listings by users'
            }
       }
   });
});

JS;
$this->registerJs($script, View::POS_READY);
$this->registerJsFile('@web/js/dashboard_widgets.js', ['depends' => 'yii\web\JqueryAsset']);
?>