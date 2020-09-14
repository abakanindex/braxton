<?php

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


$form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => ['/lead_viewing/main/update', 'id' => $leadViewing->id],
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
        echo Html::activeLabel($leadViewing, 'leadReference', ['class' => 'control-label col-sm-3']);
        echo '<div class="col-sm-6">';
        echo '<div style="padding-top: 7px;">';
        echo $leadViewing->leadReference;
        echo '</div>';
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
            <div class="row">
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
                    echo Html::error($leadViewing, 'property', ['tag' => 'div', 'id' => 'no-property-error', 'class' => 'help-block help-block-error', 'style' => 'margin-left: 14px;']);
                    echo $form->field($leadViewing, 'property')->end();
                    ?>
                    <div class="viewings-search-sales-block" style="<?php if (!$sales) echo 'display:none'; ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= Yii::t('app', 'Sales') ?></div>
                            <div class="panel-body">
                                <ul id="viewings-search-sales-list" style="list-style: none; padding-left: 0px;">
                                    <?php foreach ($sales as $sale):
                                        $deleteBtn = '<button data-id="' . $sale->property->id . '" style="margin-right: 5px" class="remove-viewing-sales btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                                        echo '<li data-id="' . $sale->property->id . '" >' . $deleteBtn . $sale->property->ref . '</li>';
                                    endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="viewings-search-rentals-block" style="<?php if (!$rentals) echo 'display:none'; ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?= Yii::t('app', 'Rentals') ?></div>
                            <div class="panel-body">
                                <ul id="viewings-search-rentals-list" style="list-style: none; padding-left: 0px;">
                                    <?php foreach ($rentals as $rental):
                                        $deleteBtn = '<button data-id="' . $rental->property->id . '" style="margin-right: 5px" class="remove-viewing-rentals btn btn-default btn-xs" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                                        echo '<li data-id="' . $rental->property->id . '" >' . $deleteBtn . $rental->property->ref . '</li>';
                                    endforeach; ?>
                                </ul
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
        <?php
        echo Html::submitButton(Yii::t('app', 'Update'), ['id' => 'save-viewing-btn', 'class' => 'btn btn-success']);
        ?>
    </div>
<?php ActiveForm::end(); ?>
<?php

$this->registerJs($propertyScript, View::POS_READY);
$leadviewSavedMessage = Yii::t('app', 'Lead viewing was successfuly saved');
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
           if ( (response.result == 'success') && (response.rentals != 0) ) {  
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
                    bootbox.confirm('$leadviewSavedMessage', function(result) {
                        if (result) { window.location.reload(); } 
                    });  
                }   
             }     
        });
        return false; 
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);