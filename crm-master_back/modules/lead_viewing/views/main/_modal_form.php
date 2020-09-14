<?php

use app\modules\lead_viewing\models\LeadViewing;
use app\modules\lead_viewing\models\LeadViewingProperty;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
            <?= Yii::t('app', 'Add Viewing') ?></h4>
    </div>
<?php

if ($action == LeadViewing::ACTION_CREATE)
    $actionUrl = Url::to(['/lead_viewing/main/create']);
elseif ($action == LeadViewing::ACTION_UPDATE)
    $actionUrl = Url::to(['/lead_viewing/main/update']);
$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => $actionUrl,
    'validationUrl' => ['/lead_viewing/main/validate'],
    'class' => 'form-horizontal',
    'layout' => 'horizontal',
    'options' => [
        'id' => 'viewing-form'
    ]]);
?>
    <div class="modal-body">
        <?php
        echo $form->field($leadViewing, 'leadReference')->begin();
        if (!$property) {
            echo Html::activeLabel($leadViewing, 'leadReference', ['class' => 'control-label col-sm-3']);
            echo '<div class="col-sm-6">';
            echo '<div style="padding-top: 7px;">';
            echo $leadViewing->leadReference;
            echo '</div>';
        } else {
            echo Html::activeLabel($leadViewing, 'leadReference', ['class' => 'control-label col-sm-3', 'style' => 'visibility:hidden', 'id' => 'lead-viewing-reference-label']);
            echo '<div class="col-sm-6">';
            echo '<div id="lead-viewing-reference" style="padding-top: 7px;"></div>';
            echo Html::a('Add Lead', ['#'], ['class' => 'btn btn-primary', 'id' => 'viewings-search-lead-btn']);
        }
        echo '<div style="display: none">' . Html::activeTextInput($leadViewing, 'leadReference', ['class' => 'lead-viewing-reference-input']) . '</div>';
        echo Html::error($leadViewing, 'leadReference', ['tag' => 'div', 'class' => 'help-block help-block-error', 'id' => 'lead-viewing-reference-error']);
        echo '</div>';
        echo $form->field($leadViewing, 'leadReference')->end(); ?>
        <div style="display: none">
            <?= $form->field($leadViewing, 'lead_id') ?>
            <?= $form->field($leadViewing, 'leadViewingSales') ?>
            <?= $form->field($leadViewing, 'leadViewingRentals') ?>
        </div>
        <?php
        echo $form->field($leadViewing, 'time')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => Yii::t('app', 'Enter viewing time ...')],
            'pluginOptions' => [
                'startDate' => date('Y-m-d'),
                'autoclose' => true
            ]
        ]);
        ?>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <div class="input-group">
                    <button class="btn btn-default" id="viewings-search-sale-btn"
                            type="button"><?= Yii::t('app', 'Add Sales') ?></button>
                    <button style="margin-left: 10px" class="btn btn-default"
                            id="viewings-search-rentals-btn"
                            type="button"><?= Yii::t('app', 'Add Rentals') ?></button>
                </div>
                <?php
                echo $form->field($leadViewing, 'property')->begin();
                echo '<div style="display: none">' . Html::activeTextInput($leadViewing, 'property') . '</div>';
                echo Html::error($leadViewing, 'property', ['tag' => 'div', 'class' => 'help-block help-block-error', 'style' => 'margin-left: 14px;']);
                echo $form->field($leadViewing, 'property')->end();
                ?>
                <div class="viewings-search-sales-block" style="display: none; margin-top: 10px;">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?= Yii::t('app', 'Sales') ?></div>
                        <div class="panel-body">
                            <ul id="viewings-search-sales-list" style="list-style: none; padding-left: 0px;">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="viewings-search-rentals-block" style="display: none; margin-top: 10px;">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?= Yii::t('app', 'Rentals') ?></div>
                        <div class="panel-body">
                            <ul id="viewings-search-rentals-list" style="list-style: none; padding-left: 0px;">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($property) { ?>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <div class="viewings-search-leads-block" style="display: none">
                        <h5><?= Yii::t('app', 'Leads') ?></h5>
                        <ul id="viewings-search-leads-list" style="list-style: none; padding-left: 0px;">
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            $getLeadReferenceUrl = Url::to(['main/get-lead-reference']);
            $leadScript = <<<JS
    $( '#viewings-search-lead-btn').on('click', function () { 
            $('#modal-viewing-leads').modal('show');    
        return false;
    }); 

    $('#viewing-leads-gridview input[type=checkbox]').change(function() {
        if($(this).is(":checked")) {
            $('#viewing-leads-gridview input[type=checkbox]').prop('checked', false);
        }
        $(this).prop('checked', true);  
    });
    
    $( '#add-viewing-leads').on('click', function () { 
        var viewingLeadId = $('#viewing-leads-gridview').yiiGridView('getSelectedRows');   
        var getLeadReferenceUrl = '$getLeadReferenceUrl?id=' + viewingLeadId;      
        $.get(getLeadReferenceUrl, function(response, status){
            $('#modal-viewing-leads').modal('hide'); 
            $('#viewing-leads-gridview input:checkbox').prop('checked', false); 
            $('#leadviewing-lead_id').val(viewingLeadId); 
            $('#lead-viewing-reference').text(response.reference);        
            $('.lead-viewing-reference-input').val(response.reference);        
            $('#viewings-search-lead-btn').hide();     
            $('#lead-viewing-reference-label').css('visibility', 'visible');
            $('#lead-viewing-reference-error').hide();
            $('.lead-viewing-error').hide(); 
        });  
       return false;   
    });
JS;
            $this->registerJs($leadScript, View::POS_READY);
        }
        ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
        <?php
        echo Html::submitButton(Yii::t('app', 'Save'), ['id' => 'save-viewing-btn', 'class' => 'btn btn-success']);
        ?>
    </div>
<?php ActiveForm::end(); ?>
<?php

if ($property) {
    if ($propertyType == LeadViewingProperty::TYPE_SALE) {
        $propertyScript = <<<JS
            var deleteBtn = '<button data-id="$property->id" style="margin-right: 5px" class="remove-viewing-sales btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
            $('#viewings-search-sales-list').append('<li data-id="$property->id" >' + deleteBtn + '$property->ref</li>');
            $('.viewings-search-sales-block').show();
JS;
    } elseif ($propertyType == LeadViewingProperty::TYPE_RENTALS) {
        $propertyScript = <<<JS
            var deleteBtn = '<button data-id="$property->id" style="margin-right: 5px" class="remove-viewing-sales btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
            $('#viewings-search-rentals-list').append('<li data-id="$property->id" >' + deleteBtn + '$property->ref</li>');
            $('.viewings-search-rentals-block').show(); 
JS;
    }

    $this->registerJs($propertyScript, View::POS_READY);
}

$salesGridViewUrl = Url::to(['/lead_viewing/main/sales']);
$rentalsGridViewUrl = Url::to(['/lead_viewing/main/rentals']);
$script = <<<JS
var rentalsIds, salesIds;
var stopSubmit = false; 

$('body').on('click', '.remove-viewing-rentals', function (e) { 
    var rentalId = $(this).data('id');
    var rentalsIdsInputArr = $('#leadviewing-leadviewingrentals').val().split(',');
    var resultrentalsIdsInputArr = rentalsIdsInputArr.filter(function(elem){
       return elem != rentalId;    
    });  
    $('#leadviewing-leadviewingrentals').val(resultrentalsIdsInputArr.join(','));    
    $(this).closest('li').remove();
    if (rentalsIdsInputArr.length == 1)      
        $('.viewings-search-rentals-block').hide();
    else
        $('.viewings-search-rentals-block').show();
});       

$( '#add-viewing-rentals').on('click', function () { 
    var viewingrentalsKeys = $('#viewing-rentals-gridview').yiiGridView('getSelectedRows');   
    $('#modal-viewing-rentals').modal('hide'); 
    $('#viewing-rentals-gridview  input:checkbox').prop('checked', false);      
    var addedrentalsIds = [];
    $( "#viewings-search-rentals-list li" ).each(function( index ) {
      addedrentalsIds.push($( this ).data('id') );
    });
    var newViewingrentalsKeys = $(viewingrentalsKeys).not(addedrentalsIds).get();   
    rentalsIds = $.merge( addedrentalsIds, newViewingrentalsKeys ); 
    $('#leadviewing-leadviewingrentals').val(rentalsIds);    
    $.post({
       url: '$rentalsGridViewUrl', 
       dataType: 'json',
       data: {keylist: newViewingrentalsKeys},
       success: function(response) {
           if ( (response.result == 'success') && (response.rentals != 0) ) { console.log(response.rentals);
               $.each(response.rentals , function(index, rental) {   
                  var deleteBtn = '<button data-id="' + rental.id + '" style="margin-right: 5px" class="remove-viewing-rentals btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                  $('#viewings-search-rentals-list').append('<li style="margin-top: 3px;margin-bottom: 3px" data-id="' + rental.id + '" >' + deleteBtn + rental.ref + '</li>');
                });
               $('.viewings-search-rentals-block').show();
               stopSubmit = true;
               $('form#viewing-form').submit();  
               if ( rentalsIds.length == 0 )
                    $('.viewings-search-rentals-block').hide();
                else
                    $('.viewings-search-rentals-block').show();
           }
       },  
    });
    return false;
});

$('body').on('click', '.remove-viewing-sales', function (e) { 
    var saleId = $(this).data('id');
    var salesIdsInputArr = $('#leadviewing-leadviewingsales').val().split(',');
    var resultSalesIdsInputArr = salesIdsInputArr.filter(function(elem){
       return elem != saleId;    
    });  
    $('#leadviewing-leadviewingsales').val(resultSalesIdsInputArr.join(','));    
    $(this).closest('li').remove(); 
    if (salesIdsInputArr.length == 1)  
        $('.viewings-search-sales-block').hide();
    else
        $('.viewings-search-sales-block').show();
});    

$( '#add-viewing-sales').on('click', function () { 
    var viewingSalesKeys = $('#viewing-sales-gridview').yiiGridView('getSelectedRows');   
    $('#modal-viewing-sales').modal('hide'); 
    $('#viewing-sales-gridview  input:checkbox').prop('checked', false);      
    var addedSalesIds = [];
    $( "#viewings-search-sales-list li" ).each(function( index ) {
      addedSalesIds.push($( this ).data('id') );
    });
    var newViewingSalesKeys = $(viewingSalesKeys).not(addedSalesIds).get();   
    var salesIds = $.merge( addedSalesIds, newViewingSalesKeys ); 
    $('#leadviewing-leadviewingsales').val(salesIds);    
    $.post({
       url: '$salesGridViewUrl', 
       dataType: 'json',
       data: {keylist: newViewingSalesKeys},
       success: function(response) {
           if ( (response.result == 'success') && (response.sales != 0) ) {
               $.each(response.sales , function(index, sale) {  
                  var deleteBtn = '<button data-id="' + sale.id + '" style="margin-right: 5px" class="remove-viewing-sales btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                  $('#viewings-search-sales-list').append('<li style="margin-top: 3px;margin-bottom: 3px" data-id="' + sale.id + '" >' + deleteBtn + sale.ref + '</li>');
                }); 
               $('.viewings-search-sales-block').show();
               stopSubmit = true;
               $('form#viewing-form').submit();
               if (salesIds.length == 0)
                    $('.viewings-search-sales-block').hide();
                else
                    $('.viewings-search-sales-block').show();
           }
       }, 
    });   
    return false;
});


$( '#viewings-search-sale-btn').on('click', function () { 
        $('#modal-viewing-sales').modal('show');    
    return false;
});

$( '#viewings-search-rentals-btn').on('click', function () { 
        $('#modal-viewing-rentals').modal('show');    
    return false;
});  

$( '#save-viewing-btn').on('click', function () { 
    stopSubmit = false;    
    if ($('#leadviewing-lead_id').val() == '') {  
        $('.lead-viewing-error').show();
    } else $('.lead-viewing-error').hide();
});  

$('body').on('beforeSubmit.yii', 'form#viewing-form', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();    
        $('#viewing-was-added-alert').hide();
        $('.lead-viewing-error').hide();  
        var form = $(this);
        if (form.find('.has-error').length) { 
            return false;
        }       

        if (($('#leadviewing-leadviewingsales').val() == '') && ($('#leadviewing-leadviewingrentals').val() == '')) {
            $('.sale-rentals-viewing-error').show();    
            return false;
        } 
        else {   
            $('.sale-rentals-viewing-error').hide();
            $('.lead-viewing-error').hide();
        } 
        
        if (stopSubmit)
            return false;  
        
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (response) {
                if ( response.result === 'success' ) {  
                    $('#modal-viewing').modal('hide'); 
                    $('#viewing-was-added-alert').show();
                }   
             }     
        });
        return false; 
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);