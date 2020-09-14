<?php

use app\models\{
    Note, Document, Company, Leads, User, UserProfile, Reminder, Viewings
};
use app\models\reference_books\PropertyCategory;
use app\modules\lead\models\CompanySource;
use app\modules\lead\models\LeadSubStatus;
use app\modules\lead\models\LeadType;
use kartik\grid\GridView;
use rmrevin\yii\fontawesome\FA;
use yii\web\View;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;
use kartik\datetime\DateTimePicker;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use app\components\widgets\ReminderWidget;
use yii\widgets\ListView;
use app\components\widgets\{
    ViewingsLeadWidget, NotesWidget, DocumentsWidget
};
use app\models\statusHistory\widgets\ArchiveHistoryWidget;


$userCreatedFilter = ArrayHelper::map(User::find()->where(['company_id' => Company::getCompanyIdBySubdomain()])->asArray()->all(), 'id', 'username');
$this->title = Yii::t('app', 'Leads');
$this->params['breadcrumbs'][] = $this->title;

$companyId = Company::getCompanyIdBySubdomain();
if (empty($companyId))
    $companyId = 0;

echo $this->render('@app/views/modals/_viewingReportForm');

echo $this->render('@app/views/modals/shareMatchingProperties/_shareMatchingProperties', [
    'model' => $firstRecord
]);

echo $this->render('@app/views/modals/_usersList', [
    'usersDataProvider' => $usersDataProvider,
    'usersSearchModel'  => $usersSearchModel,
    'gridVersion'       => '@app/views/modals/partsUsersList/_gridVersionTwo'
]);

echo $this->render('@app/views/modals/_createFirst', [
    'message' => Yii::t('app', 'Create listing first')
]);
$this->registerJsFile('@web/js/show-modal-create-first.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<?php Pjax::begin(['id' => 'result', 'timeout' => 10000]);?>
    <div id="result">
    <input type="hidden" id="url-property-requirement-create" value="<?= Url::to(['/lead/property-requirement/create', 'leadId' => $model->id])?>">
    <input type="hidden" id="url-change-match-properties" value="<?= Url::to(['lead/change-match-properties/' . $firstRecord->id])?>">
    <input type="hidden" id="url-matching-sales-list" value="<?= Url::to(['/lead/property-requirement/matching-sales-list', 'all_requirements' => true, 'propertyRequirementLeadId' => $model->id])?>">
    <input type="hidden" id="url-matching-rentals-list" value="<?= Url::to(['/lead/property-requirement/matching-rentals-list', 'all_requirements' => true, 'propertyRequirementLeadId' => $model->id])?>">
    <input type="hidden" id="url-property-requirement-list" value="<?= Url::to(['/lead/property-requirement/list', 'leadId' => $model->id])?>">

        <div class="leads-view container-fluid top-contact-content clearfix"><!--  Top Contact Block -->
            <div class="head-contact-property container-fluid">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <h2><?= Html::encode($this->title) ?></h2>
                <?= $this->render(
                    '_topButton',
                    [
                        'model' => $firstRecord,
                        'existRecord' => $existRecord,
                    ]
                )
                ?>
            </div>

            <div class="container-fluid content-contact-property">
                <?php
                $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'id' => 'lead-form',
                        'class' => 'form-horizontal',
                        'data-pjax' => true
                    ]

                ]);
                echo $this->render('@app/views/modals/_locationMap', [
                    'topModel' => $firstRecord,
                    'form' => $form
                ]);

                if(Yii::$app->controller->action->id === 'create'):
                    echo $this->render('@app/views/modals/_createPropertyRequirement');
                endif;
                ?>
                <?php
                if (
                    Yii::$app->controller->action->id === 'index' or
                    Yii::$app->controller->action->id === 'view' or
                    Yii::$app->controller->action->id === 'view-archive' or
                    Yii::$app->controller->action->id === 'slug'
                ):
                    ?>
                    <?= $this->render(
                    '_informationLeads',
                    [
                        'model'                => $firstRecord,
                        'form'                 => $form,
                        'attributesDetailView' => $attributesDetailView
                    ]
                )
                    ?>
                <?php
                elseif (
                    Yii::$app->controller->action->id === 'create' or
                    Yii::$app->controller->action->id === 'update'
                ):
                    ?>
                    <?= $this->render(
                    '_form',
                    [
                        'model' => $firstRecord,
                        'form' => $form,
                        'companyAgents' => $companyAgents,
                        'emirates' => $emirates,
                        'locations' => $locations,
                        'subLocations' => $subLocations,
                        'locationsCurrent' => $locationsCurrent,
                        'subLocationsCurrent' => $subLocationsCurrent,
                        'locationsAll' => $locationsAll,
                        'source' => $source
                    ]
                )
                    ?>
                <?php endif; ?>


                <div class="container-fluid contact-middle-block col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            $createPropertyRequirementUrl = Url::to(['/lead/property-requirement/create']);
                            echo Html::a(Yii::t('app', 'Add Property Requirement'), '#', [
                                'class' => 'btn btn-primary create-property-requirement',
                            ]);

                            if ($propertyRequirementDataProvider) {
                                echo '<div class="property-requirement-list-block">';
                                Pjax::begin(['id' => 'property-requirement-list']);
                                echo ListView::widget([
                                    'dataProvider' => $propertyRequirementDataProvider,
                                    'itemView' => '@app/modules/lead/views/property-requirement/_property_requirement_list',
                                    'emptyText' => '',
                                ]);
                                Pjax::end();
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->render('_matchProperties', [
                                'salesMatchProperties' => $salesMatchProperties,
                                'rentalsMatchProperties' => $rentalsMatchProperties
                            ]) ?>
                        </div>
                    </div>

                </div>


                <?php ActiveForm::end(); ?>

                <div
                    <?php if(Yii::$app->controller->action->id === 'create' || !$firstRecord->id):?>
                        id="listing-widget-actions"
                        class="container-fluid col-md-3 right-leads-block opacity-half"
                    <?php else:?>
                        class="container-fluid col-md-3 right-leads-block"
                    <?php endif?>
                    >
                    <div class="tabs-block">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#notes" data-toggle="tab">Notes</a></li>
                            <li><a href="#reminder" data-toggle="tab">Reminder</a></li>
                            <li><a href="#documents" data-toggle="tab">Document</a></li>
                            <li><a href="#history" data-toggle="tab">History</a></li>
                        </ul>
                        <div class="property-list">
                            <div class="tab-content ">
                                <div class="tab-pane" id="reminder">
                                    <div class="tab-header">
                                        <h4>Set up Reminder</h4>
                                    </div>
                                    <div class="tab-row">
                                        <div class="panel panel-default">
                                            <?= ReminderWidget::widget(['keyId' => $firstRecord->id, 'keyType' => Reminder::KEY_TYPE_LEAD]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane active" id="notes">
                                    <?= NotesWidget::widget(['model' => new Note(), 'ref' => $firstRecord->reference]) ?>
                                </div>
                                <div class="tab-pane" id="documents">
                                    <?= DocumentsWidget::widget(['model' => new Document(), 'ref' => $firstRecord->reference, 'keyType' => Document::KEY_TYPE_LEAD]) ?>
                                </div>
                                <div class="tab-pane" id="history">
                                    <div class="tab-header"><h4>History List</h4></div>
                                    <div class="tab-row">
                                        <?= ArchiveHistoryWidget::widget(['modelHistory' => $historyProperty]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= ViewingsLeadWidget::widget(['model' => new Viewings(), 'modelLead' => $firstRecord, 'type' => Viewings::TYPE_LEAD]) ?>
                </div><!-- /Right part-->

            </div>

        </div><!-- /Top Contact Block -->

        <div class="container-fluid  bottom-rentals-content clearfix"><!--    Bottom Rentals Block      -->
            <div id="listings-tab">
                <ul class="nav nav-tabs">
                    <li <?php if($isEmptyPropReqSearch):?> class="active" <?php endif;?>>
                        <a href="#current-listings" data-toggle="tab" id="open-current-listings">Current Leads</a>
                    </li>
                    <li>
                        <a href="#archived-listings" data-toggle="tab" id="open-archived-listings">Archived Leads<span
                                    class="badge"><?= $leadsArchiveDataProvider->getTotalCount() ?></span></a>
                    </li>
                    <li <?php if(!$isEmptyPropReqSearch):?> class="active" <?php endif;?>>
                        <a href="#property-requirement-listings" data-toggle="tab" id="open-property-requirement-listings"><?= Yii::t('app', 'Property requirement')?></a>
                    </li>
                </ul>

                <div class="tab-content ">
                    <div class="pane-header container-fluid clearfix"></div>
                    <?php
                    $hideGridPanelStyle = (!$isEmptyPropReqSearch) ? 'display: none' : '';

                    Pjax::begin(['id' => 'pjax-grid-panel', 'options' => ['style' => "$hideGridPanelStyle"]]); ?>
                    <?= $this->render('@app/views/leads/_gridPanel', [
                        'flagListing' => \app\classes\GridPanel::STATUS_CURRENT_LISTING,
                        'filteredColumns' => $filteredColumns,
                        'userColumns' => $userColumns,
                        'columnsGrid' => $columnsGrid,
                        'model' => $firstRecord,
                        'urlSaveColumnFilter' => Url::to(['lead/save-column-filter']),
                        'usersDataProvider' => $usersDataProvider,
                        'taskManagerDataProvider' => $taskManagerDataProvider,
                        'searchModel' => $searchModel,
                        'advancedSearchPath' => '@app/views/leads/_search'
                    ]) ?>
                    <?php Pjax::end(); ?>
                    <div class="tab-pane tab-pane-grid <?php if($isEmptyPropReqSearch):?> active <?php endif;?>" id="current-listings">
                        <!-- BIG listings Table-->
                        <div style="overflow-x: hidden; padding-right: 0; padding-left: 0;"
                             class="replace-grid-listing container-fluid clearfix lead">
                            <?= $this->render('_gridTable', [
                                'dataProvider' => $dataProvider,
                                'searchModel' => $searchModel,
                                'model' => $model,
                                'urlView' => 'leads/view',
                                'filteredColumns' => $filteredColumns,
                                'topModel' => $firstRecord
                            ]) ?>
                        </div>
                        <!-- /BIG listings Table-->
                    </div>

                    <div class="tab-pane tab-pane-grid" id="archived-listings">
                        <div style="overflow-x: hidden; padding-right: 0; padding-left: 0;"
                             class="replace-grid-listing container-fluid clearfix lead">
                            <?= $this->render('_gridTable', [
                                'dataProvider' => $leadsArchiveDataProvider,
                                'searchModel' => $leadsArchiveSearch,
                                'model' => $model,
                                'urlView' => 'leads/view',
                                'filteredColumns' => $filteredColumns,
                                'topModel' => $firstRecord
                            ]) ?>
                        </div>
                    </div>

                    <div class="tab-pane tab-pane-grid <?php if(!$isEmptyPropReqSearch):?> active <?php endif;?>" id="property-requirement-listings">
                        <div style="overflow-x: hidden; padding-right: 0; padding-left: 0;"
                             class="replace-grid-listing container-fluid clearfix lead">
                            <?php Pjax::begin(['id' => 'grid-property-requirement-listings']); ?>
                            <?= $this->render('_gridTablePropertyReq', [
                                'dataProvider'       => $propertyReqGridProvider,
                                'searchModel'        => $propReqSearch,
                                'propReqSearch'      => $propReqSearch,
                                'locationsSearch'    => $locationsSearch,
                                'subLocationsSearch' => $subLocationsSearch,
                                'emiratesDropDown'   => $emiratesDropDown,
                                'urlView'            => 'leads/view',
                            ]) ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div><!--    /Bottom Rentals Block      -->
    </div>
<?php Pjax::end(); ?>

<?php
if(Yii::$app->controller->action->id !== 'create'):
    echo $this->render('@app/views/modals/_createPropertyRequirement');
endif;

echo $this->render('@app/views/scripts/_locationMap', [
    'locations' => $locations,
    'subLocations' => $subLocations
]);


$propertyRequirementUpdateUrl = Url::to(['/lead/property-requirement/update']);
$propertyRequirementItemUrl   = Url::to(['/lead/property-requirement/item']);
$matchingSendLinksUrl         = Url::to(['/lead/matching-send-links']);
$matchingSendBrochure         = Url::to(['/lead/matching-send-brochure']);
$matchingSalesListUrl         = Url::to(['/lead/property-requirement/matching-sales-list', 'SaleSearch[requirement]' => true]);
$matchingRentalsListUrl       = Url::to(['/lead/property-requirement/matching-rentals-list', 'RentalsSearch[requirement]' => true]);
$urlGridPanelArchive      = Url::to(['lead/grid-panel-archive']);
$urlGridPanelCurrent      = Url::to(['lead/grid-panel-current']);
$urlUnArchive             = Url::to(['lead/unarchive']);
$getResponsiblesItemUrl   = Url::to(['/task-manager/get-responsible-item']);
$urlCreate                = Url::to(['leads/create']);
$exportToXls              = Url::to(['/lead/export-to-xls']);
$exportToPdf              = Url::to(['/lead/export-to-pdf']);

$script = <<<js
$(document).ready(function() {
    function syncResponsibiles() {
        var responsiblesId, responsiblesIds = [];
        $('#choosed-responsibles-list li').each(function( index ) {
          responsiblesId = $(this).data('id');
              if (responsiblesId)
                responsiblesIds.push(responsiblesId);
        });
        responsiblesIds = JSON.stringify(responsiblesIds);
        if ( responsiblesIds != '[]' ) {
            // $('.field-taskmanager-responsible .help-block').hide();
            $('#taskmanager-responsible').val(responsiblesIds);
        }
        else
            $('#taskmanager-responsible').val('');
    }

    $('#create-property-requirement-modal').on('hidden.bs.modal', function() {
        $('#check-type-property-requirement').show();
        $('#create-property-requirement-content').hide();
    })

    $("body").on('click', '#btn-process-create-property', function() {
        var checkedCreateType = $("input[name='check-create-property-type']:checked").val();
        var listingRef        = $('#listing-ref-for-prop-requirement').val();

        if (!checkedCreateType)
            return false;

        if (checkedCreateType == 1 && !listingRef)
            return false;

        $('#check-type-property-requirement').hide();
        $('#create-property-requirement-content').show();

        $.ajax({
            'type': 'post',
            'url': $('#url-property-requirement-create').val(),
            data: {
                listingRef: (checkedCreateType == 2) ? '' : listingRef
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            complete: function() {
                finishLoadingProcess();
            },
            success: function(response) {
                $('#create-property-requirement-content').html(response);
            }
        })
    })

    $("body").on("click", '#btn-send-matching-brochure', function() {
        var items = [];

        $(".check-matching-item:checked").each(function() {
            items.push($(this).attr("data-ref"));
        })

        $.ajax({
            url: '$matchingSendBrochure',
            type: 'POST',
            data: {
                items:   JSON.stringify(items),
                email:   $("#matching-brochure-receiver-email").val()
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(data) {
                alert(data.msg);
            },
            complete: function() {
                finishLoadingProcess();
            }
        });
    })

    $("body").on("click", "#btn-send-matching-preview-links", function() {
        var items = [];

        $(".check-matching-item:checked").each(function() {
            items.push($(this).attr("data-ref"));
        })

        $.ajax({
            url: '$matchingSendLinksUrl',
            type: 'POST',
            data: {
                items:   JSON.stringify(items),
                email:   $("#matching-receiver-email").val(),
                byEmail: $("#matching-send-links-by-email").is(":checked") ? 1 : 0,
                bySms:   $("#matching-send-links-by-sms").is(":checked") ? 1 : 0
            },
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(data) {
                alert(data.msgSendBySms + "\\n" + data.msgSendByEmail);
            },
            complete: function() {
                finishLoadingProcess();
            }
        });
    })

    $("body").on("click", "#check-all-matching-item", function() {
        ($(this).is(":checked")) ? $(".check-matching-item").prop("checked", true) : $(".check-matching-item").prop("checked", false);
    })

    $("body").on("click", "#btn-call-modal-share-matching", function() {
        if ($(".check-matching-item:checked").length > 0)
            $("#modal-share-matching-properties").modal('show');
        else
            $("#modal-share-matching-properties-alert").modal('show');

        return false;
    })

    $("body").on("click", "#btn-submit-advanced-search", function() {
        $.ajax({
            type: 'post',
            url: $("#advanced-search-form").attr('action') + "?" + $("#advanced-search-form").serialize(),
            success: function(xml, textStatus, xhr) {
                if (xhr.status == 200) {
                    $(".tab-pane-grid.active").find(".replace-grid-listing").html(xml);
                    $("#modal-advanced-search").modal('hide');
                }
            }
        })

        return false;
    })

    $("body").on("click", "#btnCreateToDoForItem", function() {
        $.ajax({
            type: 'post',
            url: $("#formAddToDoItem").attr('action'),
            data: $("#formAddToDoItem").serialize(),
            success: function(xml, textStatus, xhr) {
                if (xhr.status == 200)
                    location.reload();
            }
        })

        return false;
    })

    $('.add-responsibles').on('click', function() {
        var responsiblesId, responsiblesIdsJson;
        var responsiblesIds = [];
        $('#users-gridview input[type="checkbox"]').each(function( index ) {
          if( $( this ).prop('checked') ) {
              responsiblesId = $( this ).closest('tr').data('key');
              if (responsiblesId) {
                  var isResponsiblesUnique = true;
                  $('#choosed-responsibles-list li').each(function( index ) {
                      if ($(this).data('id') == responsiblesId)
                          isResponsiblesUnique = false;
                   });
                  if (isResponsiblesUnique)
                      responsiblesIds.push(responsiblesId);
              }
          }
        });
        responsiblesIdsJson = JSON.stringify(responsiblesIds);
        $.post("$getResponsiblesItemUrl", {responsiblesIds: responsiblesIdsJson}, function(data, status){
            $('#choosed-responsibles-list').append(data);
            syncResponsibiles();
        });

        $('#users-modal').modal('hide');
        return false;
    });

    $('.open-users-gridview').on('click', function() {
        $('#users-modal').modal('show');
        return false;
    });

    $("body").on("click", "#toggleView", function() {
        $("#dropdown-views").toggle();

        return false;
    })

    $("body").on("click", "#toggleActions", function() {
        $("#dropdown-actions").toggle();

        return false;
    })

    $("body").on("click", "#unarchive-items", function() {
        var checked   = [];
        $(".check-column-in-grid:checked").each(function() {
            checked.push($(this).val());
        });

        if (checked.length > 0) {
            $.pjax({
                type       : 'POST',
                url        : '$urlUnArchive',
                container  : '#result',
                data       : {
                    items: JSON.stringify(checked)
                },
                push       : false,
                scrollTo   : false
                //replace    : false,
                //timeout    : 10000
            })
        } else {
            $("#errorBoxSelectItem").fadeIn();
        }

        return false;
    })

    $("body").on("click", "#open-current-listings", function() {
        $('#pjax-grid-panel').show();
        $.pjax({
            type       : 'POST',
            url        : '$urlGridPanelCurrent',
            container  : '#pjax-grid-panel',
            data       : {},
            push       : false,
            scrollTo   : false
            //replace    : false,
            //timeout    : 10000,
        })
    })

    $('body').on('click', '#open-property-requirement-listings', function() {
        $('#pjax-grid-panel').hide();
    })

    $("body").on("click", "#open-archived-listings", function() {
        $('#pjax-grid-panel').show();
         $.pjax({
            type       : 'POST',
            url        : '$urlGridPanelArchive',
            container  : '#pjax-grid-panel',
            data       : {},
            push       : false,
            scrollTo   : false
            //replace    : false,
            //timeout    : 10000,
        })
    })

    $('body').on('change', "input[name='match-for-lead-condition']", function() {
        var that = $(this);

        $.pjax({
            type       : 'POST',
            url        : $('#url-change-match-properties').val(),
            container  : '#pjax-matching-properties',
            data       : { type: that.val() },
            push       : false,
            scrollTo   : false
            //replace    : false,
            //timeout    : 10000,
        })
    });

    $('body').on('click', '#save-edit-element', function() {
        $('#lead-form').submit();
   })

    $('body').on('click', '#export-leads-to-xls', function() {
        var items = [];
        $('.check-column-in-grid:checked').each(function() {
            items.push($(this).val());
        })

         $.ajax({
            url: '$exportToXls',
            data: {
                items: JSON.stringify(items)
            },
            type: 'POST',
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(response) {
                if (response.msg)
                    bootbox.alert(response.msg);
                else
                    location.href = response.url;
            },
            complete: function() {
                finishLoadingProcess();
            }
        })

        return false;
    })

    $('body').on('click', '#export-leads-to-pdf', function() {
        var items = [];
        $('.check-column-in-grid:checked').each(function() {
            items.push($(this).val());
        })

        $.ajax({
            url: '$exportToPdf',
            data: {
                items: JSON.stringify(items)
            },
            type: 'POST',
            beforeSend: function() {
                startLoadingProcess();
            },
            success: function(response) {
                if (response.msg)
                    bootbox.alert(response.msg);
                else
                    location.href = response.url;
            },
            complete: function() {
                finishLoadingProcess();
            }
        })

        return false;
    })

   function matchSalesRentals(salesParameters, rentalsParameters) {
                $('#matching-sales-list').load('$matchingSalesListUrl&' + salesParameters);
                $('#matching-rentals-list').load('$matchingRentalsListUrl&' + rentalsParameters);
            }

            $('#apply-all-requirements-btn').on('click', function (e) {
               $('#matching-sales-list').load($('#url-matching-sales-list').val());
               $('#matching-rentals-list').load($('#url-matching-rentals-list').val());
               return false;
            })

            $('body').on('show.bs.collapse', '#property-requirement-list', function (propertyRequirementItem) {
                var propertyRequirementGroup = $('.property-requirement-list-block');
                propertyRequirementGroup.find('.collapse.in').collapse('hide');
                var salesParameters =  $(propertyRequirementItem.target).data('sales-parameters');
                var rentalsParameters =  $(propertyRequirementItem.target).data('rentals-parameters');
                matchSalesRentals(salesParameters, rentalsParameters);
            })

            $('body').on('hide.bs.collapse', '#property-requirement-list', function (e) {
                $('#matching-sales-list').empty();
                $('#matching-rentals-list').empty();
            })

            $(document).on('pjax:send', function() {
                startLoadingProcess();
            })

            $(document).on('pjax:success', function(e) {
                finishLoadingProcess();
                if (typeof e.relatedTarget !== 'undefined') {
                    if (e.relatedTarget.className == 'view-contact') {
                        $('html, body').animate({ scrollTop: 0 }, 1000);
                    }
                }
            })

            $('#content').on('click', '.create-property-requirement', function() {
                $('#create-property-requirement-modal').modal('show');
                return false;
            })

             $('body').on('click', '.update-property-requirement', function (e) {
                 $('#create-property-requirement-content').load('$propertyRequirementUpdateUrl?id=' +
                  $(this).data('propertyRequirementId'), function() {
                        $('#create-property-requirement-modal').modal('show');
                        $('#check-type-property-requirement').hide();
                        $('#create-property-requirement-content').show();
                    });
                 return false;
             });

        $('body').on('beforeSubmit.yii', 'form#property-requirement-form', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var form = $(this);
            if (form.find('.has-error').length) {
                return false;
            }

            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function (response) {
                        if ( response.success ) {
                            var propertyRequirementItem;
                            if ( response.action == 'create' ) {
                                $('.property-requirement-list-block').load($('#url-property-requirement-list').val(), function() {
                                    $('#create-property-requirement-modal').modal('hide');
                                    $('.collapse-property-requirement:first').trigger('click');
                                });
                            }
                            else if ( response.action == 'update' ) {
                                var propertyRequirementItemUrl = '$propertyRequirementItemUrl?id=' + response.id;
                                $('#property-requirement-item-' + response.id ).load(propertyRequirementItemUrl, function() {
                                    $('#create-property-requirement-modal').modal('hide');
                                    propertyRequirementItem = $('#property-requirement-item-' + response.id ).find('#collapse-property-requirement-' + response.id );
                                    var salesParameters = propertyRequirementItem.data('sales-parameters');
                                    var rentalsParameters = propertyRequirementItem.data('rentals-parameters');
                                    matchSalesRentals(salesParameters, rentalsParameters);
                                });
                            }
                        }
                     }
                });
                return false;
        });
})
js;

$this->registerJs($script, View::POS_READY);

?>