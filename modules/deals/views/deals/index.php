<?php

use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\widgets\Breadcrumbs;

/**
 * @var $firstRecord
 * @var $existRecord
 * @var $disabledAttribute
 * @var $usersSearchModel
 * @var $usersDataProvider
 * @var $saleSearchModel
 * @var $saleDataProvider
 * @var $rentalSearchModel
 * @var $rentalDataProvider
 * @var $leadRefSearchModel
 * @var $leadRefDataProvider
 * @var $source
 * @var $agents
 * @var $unitModel
 * @var $category
 * @var $locationsAll
 * @var $emirates
 * @var $locationsCurrent
 * @var $subLocationsCurrent
 * @var $locations
 * @var $subLocations
 * @var $assignedToUser
 * @var $assignedToSeller
 * @var $assignedToLead
 * @var $userColumns
 * @var $filteredColumns
 * @var int $typeRental
 * @var int $typeSales
 * @var array $leadStatuses
 * @var array $leadTypes
 * @var array $leadSubStatuses
 * @var $searchModel
 * @var $columnsGrid
 * @var $leadModel
 * @var $assignedToAgent1
 * @var $assignedToAgent2
 * @var $assignedToAgent3
 */

$this->title = Yii::t('app', 'Deals');
$this->params['breadcrumbs'][] = $this->title;

$textBuyer    = Yii::t('app', 'Buyer');
$textSeller   = Yii::t('app', 'Seller');
$textTenant   = Yii::t('app', 'Tenant');
$textLandlord = Yii::t('app', 'Landlord');
?>

<?php $this->beginBlock('deals-head-block'); ?>
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
        'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <h2><?= Html::encode($this->title) ?></h2>
    <br>
<?php $this->endBlock(); ?>


<?php
if (
    Yii::$app->controller->action->id === 'create' or
    Yii::$app->controller->action->id === 'update'
) {
    echo  $this->render('@app/views/modals/_listingsList', [
        'saleSearchModel'    => $saleSearchModel,
        'saleDataProvider'   => $saleDataProvider,
        'rentalSearchModel'  => $rentalSearchModel,
        'rentalDataProvider' => $rentalDataProvider,
    ]);
    echo  $this->render('@app/views/modals/_leadsList', [
        'leadRefSearchModel'  => $leadRefSearchModel,
        'leadRefDataProvider' => $leadRefDataProvider,
        'leadStatuses'        => $leadStatuses,
        'leadTypes'           => $leadTypes,
        'leadSubStatuses'     => $leadSubStatuses,
    ]);
    echo  $this->render('@app/views/modals/_agent1List', [
        'usersDataProvider' => $usersDataProvider,
        'usersSearchModel' => $usersSearchModel
    ]);
    echo  $this->render('@app/views/modals/_agent2List', [
        'usersDataProvider' => $usersDataProvider,
        'usersSearchModel' => $usersSearchModel
    ]);
    echo  $this->render('@app/views/modals/_agent3List', [
        'usersDataProvider' => $usersDataProvider,
        'usersSearchModel' => $usersSearchModel
    ]);
}
?>
<div class="deals-index">
    <div class="container-fluid top-rentals-content clearfix">
        <div class="head-rentals-property container-fluid">
            <?= $this->render(
                'partials/topButton',
                [
                    'topModel' => $firstRecord,
                    'existRecord' => $existRecord,
                ]
            )
            ?>
        </div>

        <div class="container-fluid content-rentals-property" id="result" >
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype'   => 'multipart/form-data',
                    'class'     => 'form-horizontal',
                    'id'        => 'dealsSave',
                    'data-pjax' => true
                ]
            ]); ?>
            <div class="container-fluid rentals-left-block col-md-3"><!-- Left part-->
                <?= $this->render(
                    'partials/informationFields',
                    [
                        'topModel'               => $firstRecord,
                        'form'                   => $form,
                        'assignedToUser'         => $assignedToUser,
                        'assignedToSeller'       => $assignedToSeller,
                        'assignedToLead'         => $assignedToLead,
                        'disabledAttribute'      => $disabledAttribute,
                        'usersSearchModel'       => $usersSearchModel,
                        'usersDataProvider'      => $usersDataProvider,
                        'leadRefDataProvider'    => $leadRefDataProvider,
                        'source'                 => $source,
                        'unitModel'              => $unitModel,
                        'leadModel'              => $leadModel,
                        'typeRental'             => $typeRental,
                        'textBuyer'              => $textBuyer,
                        'textSeller'             => $textSeller,
                        'textTenant'             => $textTenant,
                        'textLandlord'           => $textLandlord,
                    ]
                ) ?>
            </div><!-- /Left part-->
            <div class="container-fluid col-md-6"><!-- Middle part-->
                <div class="row big-column-height">
                    <?= $this->render(
                        'partials/transactionCommissionFields',
                        [
                            'topModel'            => $firstRecord,
                            'form'                => $form,
                            'disabledAttribute'   => $disabledAttribute,
                            'agents'              => $agents,
                            'unitModel'           => $unitModel,
                            'category'            => $category,
                            'locationsAll'        => $locationsAll,
                            'emirates'            => $emirates,
                            'locationsCurrent'    => $locationsCurrent,
                            'subLocationsCurrent' => $subLocationsCurrent,
                            'locations'           => $locations,
                            'subLocations'        => $subLocations,
                            'typeRental'          => $typeRental,
                            'textBuyer'           => $textBuyer,
                            'textSeller'          => $textSeller,
                            'textTenant'          => $textTenant,
                            'textLandlord'        => $textLandlord,
                            'assignedToAgent1'    => $assignedToAgent1,
                            'assignedToAgent2'    => $assignedToAgent2,
                            'assignedToAgent3'    => $assignedToAgent3,
                        ]
                    ) ?>
                </div>

            </div><!-- /Middle part-->
            <?php ActiveForm::end(); ?>
            <?= $this->render('partials/tabs', [
                'topModel'        => $firstRecord,
            ])
            ?>
        </div><!-- /Right part-->
    </div>
</div><!---     Content       -->

<!--    Bottom Deals Block      -->
<div class="container-fluid  bottom-rentals-content clearfix">
    <div id="listings-deals-tab" >
<!--        <ul class="nav nav-tabs">-->
<!--            <li class="active">-->
<!--                <a href="#current-listings" data-toggle="tab" id="open-current-listings">--><?//= Yii::t('app', 'Deals Summary') ?><!--</a>-->
<!--            </li>-->
<!--        </ul>-->

        <div class="tab-content">
            <div class="clearfix"></div>

            <?= $this->render('partials/gridPanelDeals', [
                'model'               => $firstRecord,
                'userColumns'         => $userColumns,
                'mainModel'           => new \app\modules\deals\models\Deals,
                'searchModel'         => $searchModel,
                'columnsGrid'         => $columnsGrid,
                'urlSaveColumnFilter' => Url::to(['deals/save-column-filter']),
            ])?>

            <div class="tab-pane tab-pane-grid active" id="current-listings">
                <!-- BIG listings Table-->
                <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="replace-grid-listing container-fluid clearfix">
                    <?= $this->render('partials/gridTable', [
                        'dataProvider'     => $dataProvider,
                        'urlView'          => 'deals/deals/view',
                        'filteredColumns'  => $filteredColumns,
                        'topModel'         => $firstRecord,
                        'searchModel'      => $searchModel,
                        'source'           => $source,
                    ])?>
                </div>
            </div>
        </div>
    </div>
</div><!--    /Bottom Rentals Block      -->

<?php
$eventUrl = Url::to(['/calendar/main/event']);
$urlListingModel = Url::to(['/deals/deals/listing-model']);
$urlLeadModel = Url::to(['/deals/deals/lead-model']);
$script = <<<js
$(document).ready(function() {
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
        });

        return false;
    });
    
    $("body").on("click", "#toggleActions", function() {
        $("#dropdown-actions").toggle();
        return false;
    });
    
    $("body").on("click", "#toggleView", function() {
        $("#dropdown-views").toggle();

        return false;
    });
    
    $("body").on("click", "#addEventDeal", function() {
        $('#modal-event').modal('show').find('.modal-content').load('$eventUrl');
        return false;
    });
    
    $("body").on("click", ".select-listing-ref", function() {
        var that = $(this);
        $("#listingRef").val(that.val());
        $("#change-listing-ref").val(that.attr("data-ref"));
        var id = that.val();
        var type = that.attr("data-type");
        
        $.get("$urlListingModel", {id: id, type: type}, function(data) {
            if (data.success) {
                var model = data.model;
                console.log(model);
                $("#inputUnit").val(model.unit).blur();
                $("#inputCategory").val(model.category_id).blur();
                $("#inputBeds").val(model.beds).blur();
                $("#inputType").val(model.unit_type).blur();
                $("#emirateDropDown").val(model.region_id).blur();
                
                $("#locationDropDown")
                .html($("<option></option>")
                    .attr("value", model.location.id)
                    .text(model.location.name))
                .blur();
                
                $("#subLocationDropDown")
                .html($("<option></option>")
                    .attr("value", model.subLocation.id)
                    .text(model.subLocation.name))
                .blur();
                
                $("#inputStreetNo").val(model.street_no).blur();
                $("#inputFloor").val(model.floor_no).blur();
                $("#inputSeller").text(model.owner).blur();
                $("#inputPropStatus").val(model.prop_status).blur();
            } else {
                //if data wasn't found the alert.
                alert('We\'re sorry but we couldn\'t load the data!');
            }
        });
    });

    $("body").on("click", ".select-lead-ref", function() {
        var that = $(this);
        var id = that.val();

        $("#leadRef").val(that.val());
        $("#change-lead-ref").val(that.attr("data-lead-ref"));
        
        $.get("$urlLeadModel", {id: id}, function(data) {
            if (data.success) {
                var model = data.model;
                $("#change-buyer").val(model.username).blur();
                $("#buyerDeal").val(model.created_by_user_id).blur();
                $("#inputSource").val(model.source).blur();
                $("#inputBuyer").text(model.first_name + ' ' + model.last_name).blur();
                
            } else {
                //if data wasn't found the alert.
                alert('We\'re sorry but we couldn\'t load the data!');
            }
        });
    });

    $(".deals-index").on("change", "#typeDropDown", function() {
        var that = $(this);
        var val = that.val();
        var inputBuyerObject = $("label[for='inputBuyer']");
        var inputSellerObject = $("label[for='inputSeller']");

        if (val === '$typeRental') {
            inputBuyerObject.text('$textTenant');
            inputSellerObject.text('$textLandlord');
            
        } else {
            inputBuyerObject.text('$textBuyer');
            inputSellerObject.text('$textSeller');
        }
    });

    $("body").on("click", ".select-agent1", function() {
        var that = $(this);
        $("#agent1Deal").val(that.val());
        $("#changeAgent1").val(that.attr("data-agent"));
    });
    
    $("body").on("click", ".select-agent2", function() {
        var that = $(this);
        $("#agent2Deal").val(that.val());
        $("#changeAgent2").val(that.attr("data-agent"));
    });
    
    $("body").on("click", ".select-agent3", function() {
        var that = $(this);
        $("#agent3Deal").val(that.val());
        $("#changeAgent3").val(that.attr("data-agent"));
    });
    
    $("#dealsSave").submit(function (e) {
        if (!$('#typeDropDown option:selected').val()) {
          alert('Please choose Type.');
          e.preventDefault();
        }
        
        if (!$("#listingRef").val() || !$("#leadRef").val()) {
          alert('Listing Ref or Lead Ref cannot be blank.');
        }
    });
});

js;

$this->registerJs($script, View::POS_READY);