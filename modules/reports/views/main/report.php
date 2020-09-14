<?php

use app\models\Contacts;
use app\modules\reports\models\DashboardReportOrder;
use app\modules\reports\models\Reports;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use kartik\spinner\Spinner;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/**
 * @var $report
 * @var $provider
 */

$viewsPath = '@app/modules/reports/views/main/reports/';
$reportsUrl = Url::to(['/reports/main/report', 'id' => $report->url_id]);
?>
    <h3><?php echo Yii::t('app', 'Reports'); ?></h3>
    <div class="panel panel-default">
        <div class="panel-heading"><?= $report->name ?></div>
        <div class="panel-body">
            <div id="report-added-dashboard-alert" style="display: none" class="alert alert-success">
                <?= Yii::t('app', 'Report was successfuly added to dashboard') ?>
            </div>
            <p><?= $report->description; ?></p>
            <div class="export-block row">
                <div class="col-sm-12">
                    <div class="pull-left">
                        <?php
                        echo Html::a(
                            FA::icon('envelope') . ' ' . Yii::t('app', 'Email'),
                            '#',
                            [
                                'data-toggle' => 'modal',
                                'data-target' => '#email-report',
                                'class' => 'btn btn-default'
                            ]
                        );
                        echo ' ';
                        echo Html::a(
                            FA::icon('share') . ' ' . Yii::t('app', 'Export'),
                            '#',
                            [
                                'data-toggle' => 'modal',
                                'data-target' => '#export-print-report',
                                'data-action' => 'export',
                                'class' => 'export-print-report btn btn-default'
                            ]
                        );
                        ?>

                        <?php
                        if (!DashboardReportOrder::findOne(['user_id' => Yii::$app->user->id, 'report_id' => $report->id])): ?>
                            <a class="add-to-dashboard" style="margin-left: 10px"
                               href="#"><?= Yii::t('app', 'Add to dashboard') ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="pull-right">
                        <div class="report-daterange">
                            <div class="total-block">
                                <?php $activeClass = ($report->date_type == Reports::DATE_TYPE_TOTAL) ? "report-total-active" : ""; ?>
                                <button class="total form-control <?= $activeClass ?>"
                                        title="<?= Yii::t('app', 'In Total') ?>">
                                    <?= Yii::t('app', 'In Total') ?>
                                </button>
                            </div>
                            <div class="date-dropbown">
                                <div class="title-txt"><?= Yii::t('app', 'Date Range') ?></div>
                                <?php
                                $startDate = ($report->date_from) ? $report->date_from : date('Y-m-d', strtotime(' - 1 month'));
                                $endDate = ($report->date_to) ? $report->date_to : date('Y-m-d');
                                echo '<div class="report-dropdown input-group drp-container">';
                                echo DateRangePicker::widget([
                                    'name' => 'report-type-' . $report->type,
                                    'startAttribute' => 'from_date',
                                    'endAttribute' => 'to_date',
                                    'startInputOptions' => ['value' => $startDate],
                                    'endInputOptions' => ['value' => $endDate],
                                    'convertFormat' => true,
                                    'useWithAddon' => true,
                                    'value' => date('Y-m-d'),
//                                    'hideInput' => true,
                                    'presetDropdown' => false,
                                    'pluginOptions' => [
                                        'locale' => [
                                            'format' => 'Y-m-d',
                                            'separator' => ' to ',
                                        ],
                                        'ranges' => [
                                            Yii::t('app', 'Today') => ["moment().startOf('day')", "moment().endOf('day')"],
                                            Yii::t('app', 'Yesterday') => ["moment().startOf('day').subtract(1,'days')", "moment().endOf('day').subtract(1,'days')"],
                                            Yii::t('app', 'Last {n} Days', ['n' => 7]) => ["moment().startOf('day').subtract(6, 'days')", "moment().endOf('day')"],
                                            Yii::t('app', 'Last {n} Days', ['n' => 30]) => ["moment().startOf('day').subtract(29, 'days')", "moment().endOf('day')"],
                                            Yii::t('app', 'This Month') => ["moment().startOf('day').subtract(1, 'months')", "moment().endOf('day')"],
                                            Yii::t('app', 'Last Month') => ["moment().subtract(1, 'month').startOf('month')", "moment().subtract(1, 'month').endOf('month')"],
                                            Yii::t('app', 'Last {n} Months', ['n' => 3]) => ["moment().startOf('day').subtract(3, 'months')", "moment().endOf('day')"],
                                            Yii::t('app', 'Last {n} Months', ['n' => 6]) => ["moment().startOf('day').subtract(6, 'months')", "moment().endOf('day')"],
                                        ],
                                        'opens' => 'left'
                                    ],
                                    'pluginEvents' => [
                                        "apply.daterangepicker" => "function(e) {   
                                            var range = $('input[name=\"report-type-$report->type\"]').val();
                                            var startDate = range.slice(0,10);
                                            var endDate = range.slice(14,24);
                                            activeLink = '$reportsUrl&date_from=' + startDate + '&date_to=' + endDate; 
                                            $.pjax.reload({url: activeLink, container:\"#$report->type-report-gridview\"});
                                            $('#reports-date_type').val(2);
                                            $('#reports-date_to').val(endDate); 
                                            $('#reports-date_from').val(startDate);   
                                            $( '.total-block button.total' ).removeClass( 'report-total-active' );
                                         }"
                                    ]
                                ]);
                                echo '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="export-block">
                <!--<h4><? /*= Yii::t('app', 'Customize your report') */ ?></h4>-->
                <div id="report-saved-alert" style="display: none" class="alert alert-success">
                    <?= Yii::t('app', 'Report') ?>&nbsp;
                    <span id="report-name"></span>&nbsp;
                    <?= Yii::t('app', 'was successfuly saved') ?>
                </div>
                <div id="report-sent-alert" style="display: none" class="alert alert-success">
                    <?= Yii::t('app', 'Report was successfuly sent') ?>
                </div>

                <?php
                echo Html::a(
                    FA::icon('save') . ' ' . Yii::t('app', 'Save as new report'),
                    '#',
                    [
                        'data-toggle' => 'modal',
                        'data-target' => '#save-new-report',
                        'id' => 'save-report',
                    ]
                )
                ?>
            </div>
            <hr/>


            <div class="report-block">
                <?php switch ($report->type) {
                    case Reports::LEAD_TYPE:
                        echo $this->render($viewsPath . 'leads/_leads_by_type', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_STATUS:
                        echo $this->render($viewsPath . 'leads/_leads_by_status', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_VIEWINGS:
                        echo $this->render($viewsPath . 'leads/_leads_by_viewings', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_CATEGORY:
                        echo $this->render($viewsPath . 'listings/_sales_by_category', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_CATEGORY:
                        echo $this->render($viewsPath . 'listings/_rentals_by_category', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_LOCATION:
                        echo $this->render($viewsPath . 'listings/_sales_by_location', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_LOCATION:
                        echo $this->render($viewsPath . 'listings/_rentals_by_location', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_STATUS:
                        echo $this->render($viewsPath . 'listings/_sales_by_status', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_STATUS:
                        echo $this->render($viewsPath . 'listings/_rentals_by_status', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_VIEWINGS_REPORT:
                        echo $this->render($viewsPath . 'listings/_sales_viewings', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_VIEWINGS_REPORT:
                        echo $this->render($viewsPath . 'listings/_rentals_viewings', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::TASKS_PRIORITY_REPORT:
                        echo $this->render($viewsPath . 'tasks/_tasks_by_priority', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::AGENT_LEADER:
                        echo $this->render($viewsPath . 'agent_leader/_agent_leader_board', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_AGENTS:
                        echo $this->render($viewsPath . 'listings/_sales_by_agents', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_AGENTS:
                        echo $this->render($viewsPath . 'listings/_rentals_by_agents', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_INACTIVE_AGENTS:
                        echo $this->render($viewsPath . 'listings/_sales_by_agents', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_INACTIVE_AGENTS:
                        echo $this->render($viewsPath . 'listings/_rentals_by_agents', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_AGENTS:
                        echo $this->render($viewsPath . 'leads/_leads_by_agents', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_PROPERTY:
                        echo $this->render($viewsPath . 'leads/_leads_by_property', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_SOURCE:
                        echo $this->render($viewsPath . 'leads/_leads_by_source', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_OPEN:
                        echo $this->render($viewsPath . 'leads/_open_leads', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_AGENT_CONTACT_INTERVAL:
                        echo $this->render($viewsPath . 'leads/_agent_contact_interval', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_AGENT_CONTACT_NUMBER:
                        echo $this->render($viewsPath . 'leads/_agent_contact_number', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::LEAD_BY_LOCATION:
                        echo $this->render($viewsPath . 'leads/_leads_by_location', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_AGENTS_IN_NUMBERS_PROPERTIES:
                        echo $this->render($viewsPath . 'listings/_sales_by_agents', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_AGENTS_IN_AED:
                        echo $this->render($viewsPath . 'listings/_sales_by_agents_aed', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::SALES_LOCATION_CLOSED:
                        echo $this->render($viewsPath . 'listings/_sales_closed_by_location', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_AGENTS_IN_NUMBERS_PROPERTIES:
                        echo $this->render($viewsPath . 'listings/_rentals_by_agents', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_AGENTS_IN_AED:
                        echo $this->render($viewsPath . 'listings/_rentals_by_agents_aed', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::RENTALS_LOCATION_CLOSED:
                        echo $this->render($viewsPath . 'listings/_rentals_closed_by_location', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::AGENT_LEADERBOARD_SALES:
                        echo $this->render($viewsPath . 'agent_leader/_agent_leader_sales', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                    case Reports::AGENT_LEADERBOARD_RENTALS:
                        echo $this->render($viewsPath . 'agent_leader/_agent_leader_rentals', ['provider' => $provider, 'reportType' => $report->type]);
                        break;
                } ?>
            </div>


        </div>
    </div>


<?php
Modal::begin([
    'id' => 'save-new-report',
    'header' => '<h3>' . Yii::t('app', 'Add to My Saved Reports') . '</h3>',
]);

$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => Url::toRoute('/reports/main/create-report'),
    'validationUrl' => Url::toRoute('/reports/main/validate-report'),
    'class' => 'form-horizontal',
    'layout' => 'horizontal',
    'options' => [
        'id' => 'new-report-form'
    ]]);
?>
    <div class="modal-body">
        <?= $form->field($newReport, 'name') ?>

        <?= $form->field($newReport, 'description')->textarea(['rows' => 6]) ?>

        <div style="display: none">
            <?= $form->field($newReport, 'type')->textInput(); ?>
            <?= $form->field($newReport, 'date_type')->textInput(); ?>
            <?= $form->field($newReport, 'date_from')->textInput() ?>
            <?= $form->field($newReport, 'date_to')->textInput() ?>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
        <?= Html::submitButton(Yii::t('app', 'Save'),
            [
                'class' => 'btn btn-success',
                'id' => 'new-report-form-submit'
            ]) ?>
    </div>
<?php
ActiveForm::end();
Modal::end();
?>


<?php
Modal::begin([
    'id' => 'email-report',
    'header' => '<h3>' . Yii::t('app', 'Email Report') . '</h3>',
]);

$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => ['/reports/main/send-email'],
    'validationUrl' => Url::toRoute('/reports/main/validate-email'),
    'class' => 'form-horizontal',
    'layout' => 'horizontal',
    'options' => [
        'id' => 'email-report-form'
    ]]);
?>
    <div class="modal-body">
        <?= $form->field($emailForm, 'from')->textInput(['readonly' => true]) ?>
        <?= $form->field($emailForm, 'to')->textInput(['autofocus' => true]) ?>

        <?php
        $contacts = ArrayHelper::map(Contacts::find()->where([])->all(), 'email', 'email');
        echo $form->field($emailForm, 'cc')->widget(Select2::class, [
            'data' => $contacts,
            'size' => Select2::SMALL,
            'options' => [
                'multiple' => true,
            ],
        ]);
        ?>

        <?= $form->field($emailForm, 'bcc')->widget(Select2::class, [
            'data' => $contacts,
            'size' => Select2::SMALL,
            'options' => [
                'multiple' => true,
            ],
        ]) ?>

        <?= $form->field($emailForm, 'subject') ?>
        <?= $form->field($emailForm, 'message')->textarea(['rows' => 6]) ?>
        <?= $form->field($emailForm, 'attach')->checkbox(); ?>

        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="row">
                    <div class="col-sm-2"><?= FA::icon('file-pdf-o')->size(FA::SIZE_3X); ?></div>
                    <div class="col-sm-10"><?php echo Yii::t('app', 'Summary') . ' PDF'; ?></div>
                </div>
            </div>
        </div>

        <div style="display: none">
            <?= $form->field($emailForm, 'report_id') ?>
            <?= $form->field($emailForm, 'user_id') ?>
            <?= $form->field($emailForm, 'created_at') ?>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
        <?php
        echo '<button class="btn btn-success" id="email-report-form-submit" type="submit">';
        echo '<div id="send-btn-text">' . Yii::t('app', 'Send Email') . '</div>';
        echo '<div id="send-id-spinner" style="display: none">' . Spinner::widget(['preset' => 'tiny', 'align' => 'left', 'caption' => Yii::t('app', 'Sending Email') . ' &hellip;']) . '</div>';
        echo '</button>';
        ?>
    </div>
<?php
ActiveForm::end();
Modal::end();
?>


<?php
Modal::begin([
    'id' => 'export-print-report',
    'header' => '<h3>' . Yii::t('app', 'Print Report') . '</h3>',
]);
?>
    <div class="modal-body">
        <?php echo $this->render('pdf-report', ['provider' => $pdfProvider, 'report' => $report, 'user' => $user]); ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?= Yii::t('app', 'OK') ?>
        </button>
        <?= Html::a('Download', [
            '/reports/main/download-pdf-report',
            'urlId' => $report->url_id,
        ], [
            'class' => 'btn btn-success',
            'target' => '_blank',
        ]); ?>
        <?php /*Html::a('Export', [
                        '/reports/main/save-report-pdf',
                        'urlId' => $report->url_id,
                    ], [
                        'class' => 'btn btn-primary',
                        'id'=> 'print-export-action-btn',
                        'target' => '_blank',
                    ]);*/ ?>
        <a href="#" style="display: none" id="open-pdf-file" class="btn-pdfprint">open</a>
    </div>
<?php
Modal::end();
?>

<?= \dixonstarter\pdfprint\Pdfprint::widget([
    'elementClass' => '.btn-pdfprint'
]); ?>
<?php
$addToDashboardUrl = Url::to(['/reports/dashboard-order/add']);
$saveReportPdfUrl = Url::to(['/reports/main/save-report-pdf', 'urlId' => $report->url_id]);
$downloadPdfUrl = Url::to(['/reports/main/download-pdf-report', 'urlId' => $report->url_id]);
$pdfPath = Url::home(true) . 'uploads/reports-pdf/tmp/';

$script = <<<JS

$( '#print-export-action-btn' ).on("click", function () {
  var action = $(this).data('action');
   $.ajax({
            url: '$saveReportPdfUrl',
            type: 'get', 
            success: function(data) {     
                if ( data.result === 'success' ) {    
                  $('#open-pdf-file').attr("href", '$pdfPath' + data.pdfFile);
                  $('#open-pdf-file').click();
                } 
            }
    }); 
  return false; 
});

$( '.export-print-report' ).on("click", function () {
     var action = $(this).data('action');
     if ( action == 'print' )   {
        $("#export-print-report .print-export-modal-title").text( 'Print Report' );
        $("#export-print-report .print-export-action-btn").text( 'Print' );  
        $("#export-print-report .print-export-action-btn").data( 'action', 'print' );  

     }
     else if ( action == 'export' ) {
       $("#export-print-report .print-export-modal-title").text( 'Export Report' );
       $("#export-print-report .print-export-action-btn").text( 'Export' );
       $("#export-print-report .print-export-action-btn").data( 'action', 'export' );  
     }
}); 

$( '.total-block button.total' ).on( 'click', function() {
    $(this).addClass( 'report-total-active' );
});  

var range = $('input[name=\"report-type-$report->type\"]').val();
var startDate = range.slice(0,10);
var endDate = range.slice(14,24);
$('#reports-date_type').val(2);
$('#reports-date_to').val(endDate);  
$('#reports-date_from').val(startDate); 

$('#email-report-form').on('beforeSubmit', function(event, jqXHR, settings) {
        var form = $(this);   
        if(form.find('.has-error').length) {
                return false;
        }  
        $('#email-report-form-submit').prop('disabled', true);
        $('#send-btn-text').hide();
        $('#send-id-spinner').show();
        $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(data) {     
                    if ( data.result === 'success' ) {
                        $('#email-report').modal('toggle');
                        $('#report-sent-alert').show(); 
                        $('#email-report-form-submit').prop('disabled', false);
                        $('#send-id-spinner').hide();
                        $('#send-btn-text').show();  
                    } 
                }
        }); 
        return false;
}); 

                                            
$('#new-report-form').on('beforeSubmit', function(event, jqXHR, settings) {
        var form = $(this);  
        if(form.find('.has-error').length) {
                return false;
        }
        $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(data) {              
                    $('#save-new-report').modal('toggle');
                    $('#report-name').text(data.name);
                    $('#report-saved-alert').show();
                }
        }); 
        return false;
}); 

$('.add-to-dashboard').on('click', function() {
    var addToDashboardLink = $(this);
    $.ajax({  
        url: "$addToDashboardUrl", 
        type: "post",
        data: {"id": "$report->id" },
        cache: false,
        success: function(data) {
             $('#report-added-dashboard-alert').show();  
             addToDashboardLink.hide();
        }
    });
    return false;
});

$('button.total').on('click', function() {
    var activeLink = '$reportsUrl&total=true';  
    $('#reports-date_type').val(1);
    $('#reports-date_to').val('');
    $('#reports-date_from').val('');
    $.pjax.reload({url: activeLink, container:'#$report->type-report-gridview'});
});

$(document).on('click', '.show-pie-chart-report', function (event) { 
    $(this).closest('.distribution-block').find('.distribution-bar').hide();
    $(this).closest('.distribution-block').find('.distribution-pie').show(); 
    $(this).closest('.distribution-block').find('.show-chart i').removeClass('fa-border');
    $(this).find('i').addClass('fa-border');
    return false;
});
$(document).on('click', '.show-bar-chart-report', function (event) { 
    $(this).closest('.distribution-block').find('.distribution-pie').hide();
    $(this).closest('.distribution-block').find('.distribution-bar').show(); 
    $(this).closest('.distribution-block').find('.show-chart i').removeClass('fa-border');
    $(this).find('i').addClass('fa-border');
    return false;
});

JS;
$this->registerJs($script, yii\web\View::POS_READY);