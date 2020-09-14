<?php

use app\modules\reports\models\DashboardReportOrder;
use app\modules\reports\widgets\ReportWidget;
use kartik\sortable\Sortable;
use yii\helpers\Url;
use yii\bootstrap\Tabs;

/**
 * @var $recentlyViewedReports
 * @var $recentlySavedReports
 * @var array $boxes
 */

$this->registerCssFile('@web/new-design/css/index_page.css')
?>
    <div class="reports-default-index">
    <h2><?= Yii::t('app', 'Dashboard') ?></h2>
    <div style="margin-top: 20px" class="panel panel-default">
        <div class="panel-body">
            <?php
            try {
                echo Tabs::widget([
                    'navType' => 'nav-tabs',
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Recently Viewed'),
                            'content' => $recentlyViewedReports,
                            'options' => [
                                'id' => 'recently-viewed-reports',
                                'class' => 'tab-pane fade in active',
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'Recently Saved'),
                            'content' => $recentlySavedReports,
                            'options' => [
                                'id' => 'recently-viewed-saved',
                                'class' => 'tab-pane fade',
                            ],
                        ],
                    ],
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>

    <div class="row custom-box-sortable-area">
        <?php
        foreach ($boxes as $box) {
        ?>
            <div class="col-lg-12 custom-box-sortable">
                <div data-mode="1" data-type="1" data-id="<?php echo $box['report']->id; ?>" class="box box-warning">
                    <div class="box-header">
                        <i class="fa fa-bar-chart"></i>
                        <h3 class="box-title"><?php echo $box['report']->name; ?></h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-warning btn-sm" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body"><?php echo $box['view']; ?></div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
$changeUrlMode = Url::toRoute('/reports/dashboard-order/change-mode');
$removeWidgetUrl = Url::toRoute('/reports/dashboard-order/remove-widget');
$sortWidgetUrl = Url::toRoute('/reports/dashboard-order/sort');
$showWidgetMode = DashboardReportOrder::MODE_OPENED;
$script = <<< JS
$(function () {
    'use strict';
    $('.custom-box-sortable .box').find('button[data-widget="remove"]').on('click', function() {
        $.ajax({  
            url: "$removeWidgetUrl", 
            type: "post",
            data: { "widgetId": $(this).parents().eq(2).attr('data-id') },
            cache: false,
            success: function(data) {
                if ( data.result === 'success' ) {
                    
                }
            }
        });
    });
});

$(function () {
    'use strict';
    // Make the dashboard widgets sortable Using jquery UI
    $('.custom-box-sortable-area').sortable({
        placeholder: 'sort-highlight',
        handle: '.box-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999,
        update: function(event, ui) {
            function sort_widgets() {
                var widgets = [];
                $(".custom-box-sortable .box").map(function (i, n) {
                    widgets.push({
                        "id": $(n).data("id"),
                        "type": $(n).data("type"),
                        "mode": $(n).data("mode")
                    });
                    return widgets;
                });
                
                $.ajax({
                    url: "$sortWidgetUrl",
                    type: "post",
                    data: {"sort": widgets},
                    cache: false,
                    success: function(data) {}
                }); 
            }
            setTimeout(sort_widgets, 4000);
        }
            // var start_pos = ui.item.data('start_pos');
            // var index = ui.placeholder.index();
            // if (start_pos < index) {
            //     $('#sortable li:nth-child(' + index + ')').addClass('highlights');
            // } else {
            //     $('#sortable li:eq(' + (index + 1) + ')').addClass('highlights');
            // }
    });
    
    $('.custom-box-sortable .box-header, .custom-box-sortable .nav-tabs-custom').css('cursor', 'move');

    // jQuery UI sortable for the todo list
    // $('.todo-list').sortable({
    //     placeholder: 'sort-highlight',
    //     handle: '.handle',
    //     forcePlaceholderSize: true,
    //     zIndex: 999999
    // });
});

// $('.widget-hide').on('click', function() {
//     var widgetContentBlock = $( this ).closest( '.widget-sortable' ).find( '.report-widget-content' );
//     var dataMode = widgetContentBlock.attr( 'data-mode' );
//     if ( dataMode )
//         changeWidgetMode(dataMode, widgetContentBlock.attr( 'data-widget'), widgetContentBlock);
// });      
//
//function changeWidgetMode(mode, widgetOrderId, widgetContentBlock) { 
//    var arrowIcon = widgetContentBlock.closest( '.widget-sortable' ).find( '.widget-hide i' );
//    $.ajax({  
//        url: "$changeUrlMode", 
//        type: "post",
//        data: {"mode": mode, "widgetOrderId": widgetOrderId },
//        cache: false,
//        success: function(data) {
//            widgetContentBlock.attr( 'data-mode', data.mode ); 
//            if ( data.mode == $showWidgetMode ) {
//                widgetContentBlock.toggle( 'show' ); 
//                arrowIcon.removeClass( 'glyphicon-menu-down' ).addClass( 'glyphicon-menu-up' );  
//                var widgetId = widgetContentBlock.data( 'widget' ); 
//                $( '#report-widget-content-' + widgetId ).trigger("showwidget");      
//            }
//            else {
//                widgetContentBlock.toggle( 'hide' ); 
//                arrowIcon.removeClass( 'glyphicon-menu-up' ).addClass( 'glyphicon-menu-down' );
//            }
//        }
//    });
//}
  
JS;
$this->registerJs($script, yii\web\View::POS_READY);
$this->registerJsFile('@web/js/dashboard_widgets.js', ['depends' => 'yii\web\JqueryAsset']);
