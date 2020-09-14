<?php

use app\models\Company;
use app\models\Reminder;
use app\models\User;
use app\modules\calendar\models\Event;
use app\modules\calendar\models\EventType;
use app\components\widgets\ReminderWidget;
use kartik\datetime\DateTimePicker;
use kartik\spinner\Spinner;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$sales = [];
foreach ($model->sales as $sale) {
    $sales[] = $sale->sale;
    $saleIds[] = $sale->sale->id;
}
$salesIdsJson = json_encode($saleIds);
if (count($saleIds) > 0)
    $model->salesIds = $salesIdsJson;

$rentals = [];
foreach ($model->rentals as $rental) {
    $rentals[] = $rental->rental;
    $rentalIds[] = $rental->rental->id;
}
$rentalsIdsJson = json_encode($rentalIds);
if (count($rentalIds) > 0)
    $model->rentalsIds = $rentalsIdsJson;

$leads = [];
foreach ($model->leads as $lead) {
    $leads[] = $lead->lead;
    $leadIds[] = $lead->lead->id;
}
$leadsIdsJson = json_encode($leadIds);
if (count($leadIds) > 0)
    $model->leadsIds = $leadsIdsJson;

$contacts = [];
foreach ($model->contacts as $contact) {
    $contacts[] = $contact->contact;
    $contactsIds[] = $contact->contact->id;
}
$contactsIdsJson = json_encode($contactsIds);
if (count($contactsIds) > 0)
    $model->contactsIds = $contactsIdsJson;
?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => ['/calendar/main/event', 'id' => $model->id],
    'validationUrl' => Url::toRoute('/calendar/main/validate'),
    /*'class' => 'form-horizontal',
    'layout' => 'horizontal',*/
    'options' => [
        'id' => 'event-form'
    ]]);
?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Event</h4>
    </div>
    <div class="modal-body">
<?php
$companyId = Company::getCompanyIdBySubdomain();
if ($companyId == '')
    $companyUsers = User::find()->all();
else
    $companyUsers = User::find()->where(['company_id' => $companyId])->all();
$items = ArrayHelper::map($companyUsers, 'id', 'username');
echo $form->field($model, 'owner_id')->dropDownList($items);
echo $form->field($model, 'displayStart')->widget(DateTimePicker::classname(), [
    'options' => [
        'placeholder' => 'Enter event time ...',
        'setDate' => 'now',
        'readonly' => true,
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii'
    ],
    'pluginEvents' => [
        'changeDate' => 'function(e) {  
            var repeatStartTime = $(\'#event-displaystart\').val();
            $("input[name=\"repeat-event-start_time\"]").val(repeatStartTime);
         }',
    ]
]);
echo $form->field($model, 'displayEnd')->widget(DateTimePicker::classname(), [
    'options' => [
        'placeholder' => 'Enter event time ...',
        'readonly' => true,],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii'
    ]
]);
?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::a('Repeat', '#', ['class' => 'btn btn-default pull-right', 'id' => 'repeat-btn', 'style' => 'margin-bottom: 15px']); ?>
        </div>
    </div>
<?php
$types = ArrayHelper::map(EventType::find()->all(), 'id', 'name');
echo $form->field($model, 'type')->dropDownList($types, ['prompt' => 'Select']);
if ($model->lead_viewing_id) {
    $leadViewing = \app\modules\lead_viewing\models\LeadViewing::findOne($model->lead_viewing_id);
    echo '<div class="form-group">';
    echo '<div class="col-sm-9 col-sm-offset-3">';
    echo Yii::t('app', 'Lead Viewing') . ' - ' . Html::a(FA::icon('link', ['class' => 'small']), ['/lead_viewing/main/view', 'id' => $leadViewing->id], ['class' => 'btn btn-default']);
    echo '</div></div>';
}
echo $form->field($model, 'title')->textInput();
echo $form->field($model, 'location')->textInput();
echo $form->field($model, 'description')->textarea(['rows' => '3']); ?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::a('Add guests', ['/calendar/main/guests'], ['class' => 'btn btn-primary', 'id' => 'invite-guests', 'style' => 'margin-bottom: 15px']); ?>
        </div>
    </div>
    <div style="display: none">
        <?php
        echo $form->field($model, 'eventContactsIds', ['inputOptions' => ['id' => 'eventContactsIds']])->hiddenInput()->label(false);
        echo $form->field($model, 'repeatType', ['inputOptions' => ['id' => 'repeatType']])->hiddenInput()->label(false);
        echo $form->field($model, 'repeatInterval', ['inputOptions' => ['id' => 'repeatInterval']])->hiddenInput()->label(false);
        echo $form->field($model, 'repeatStart', ['inputOptions' => ['id' => 'repeatStart']])->hiddenInput()->label(false);
        echo $form->field($model, 'repeatEndMode', ['inputOptions' => ['id' => 'repeatEndMode']])->hiddenInput()->label(false);
        echo $form->field($model, 'repeatEnd', ['inputOptions' => ['id' => 'repeatEnd']])->hiddenInput()->label(false);
        echo $form->field($model, 'repeatWeeklyDays', ['inputOptions' => ['id' => 'repeatWeeklyDays']])->hiddenInput()->label(false);
        ?>
    </div>

    <?php echo Html::a(Yii::t('app', 'Add Sales'), '#',
        [
            'class' => 'btn btn-default open-sales-gridview',
            'style' => 'margin-top: 10px'
        ])
    ?>

    <?php echo $form->field($model, 'salesIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Sales') ?></div>
        <div class='panel-body'>
            <ul id='choosed-sales-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('choosed_sale_item', [
                    'sales' => $sales
                ]);
                ?>
            </ul>
        </div>
    </div>

    <?php echo Html::a(Yii::t('app', 'Add Rentals'), '#',
        [
            'class' => 'btn btn-default open-rentals-gridview',
            'style' => 'margin-top: 10px'
        ]) ?>

    <?php echo $form->field($model, 'rentalsIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Rentals') ?></div>
        <div class='panel-body'>
            <ul id='choosed-rentals-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('choosed_rental_item', [
                    'rentals' => $rentals
                ]);
                ?>
            </ul>
        </div>
    </div>

    <?php echo Html::a(Yii::t('app', 'Add Leads'), '#',
        [
            'class' => 'btn btn-default open-leads-gridview',
            'style' => 'margin-top: 10px'
        ]) ?>

    <?php echo $form->field($model, 'leadsIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Leads') ?></div>
        <div class='panel-body'>
            <ul id='choosed-leads-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('choosed_lead_item', [
                    'leads' => $leads
                ]);
                ?>
            </ul>
        </div>
    </div>

    <?php echo Html::a(Yii::t('app', 'Add Contacts'), '#',
        [
            'class' => 'btn btn-default open-contacts-gridview',
            'style' => 'margin-top: 10px'
        ]) ?>

    <?php echo $form->field($model, 'contactsIds')->textInput(['style' => 'display: none'])->label(false); ?>

    <div class='panel panel-default'>
        <div class='panel-heading'><?= Yii::t('app', 'Choosed Contacts') ?></div>
        <div class='panel-body'>
            <ul id='choosed-contacts-list' style='list-style: none; padding-left: 0px;'>
                <?php
                echo $this->render('choosed_contact_item', [
                    'contacts' => $contacts
                ]);
                ?>
            </ul>
        </div>
    </div>
<?php

ActiveForm::end();
if (!$model->isNewRecord) {
    echo ReminderWidget::widget(['keyId' => $model->id, 'keyType' => Reminder::KEY_TYPE_EVENT]);
}
    $saveBtn = Yii::t('app', 'Save');
    $loadingSaveBtn = Spinner::widget(['preset' => 'tiny', 'align' => 'left', 'caption' => Yii::t('app', 'Loading') . ' &hellip;']);
?>
    <div class="modal-footer">
        <?php echo Html::submitButton($saveBtn , ['class' => 'btn btn-success', 'id' => 'event-form-submit']) ?>
        <button <?php if ($model->isNewRecord) {
            echo 'style="display:none;"';
        } ?> data-id="<?= $model->id ?>" type="button" class="btn btn-danger" id="remove-event">Delete
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
<?php
Modal::begin([
    'header' => Yii::t('app', 'Sales'),
    'id' => 'modal-sales-gridview',
    'size' => 'modal-sm',
]);
echo $this->render('sale_gridview',
    [
        'salesDataProvider' => $salesDataProvider,
        'salesSearchModel' => $salesSearchModel,
    ]);
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Rentals'),
    'id' => 'modal-rentals-gridview',
    'size' => 'modal-sm',
]);
echo $this->render('rentals_gridview',
    [
        'rentalsDataProvider' => $rentalsDataProvider,
        'rentalsSearchModel' => $rentalsSearchModel,
    ]);
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Leads'),
    'id' => 'modal-leads-gridview',
    'size' => 'modal-sm',
]);
echo $this->render('leads_gridview',
    [
        'leadsDataProvider' => $leadsDataProvider,
        'leadsSearchModel' => $leadsSearchModel,
    ]);
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Contacts'),
    'id' => 'modal-contacts-gridview',
    'size' => 'modal-sm',
]);
echo $this->render('contacts_gridview',
    [
        'contactsDataProvider' => $contactsDataProvider,
        'contactsSearchModel' => $contactsSearchModel,
    ]);
Modal::end();

$deleteEventUrl = Url::to(['/calendar/main/delete-event']);
$guestsUrl = Url::to(['/calendar/main/guests']);
$createContactUrl = Url::to(['/calendar/main/create-contact']);
$isEventNew = $model->isNewRecord;

if (!$model->isNewRecord) {
    $getContactsUrl = Url::to(['/calendar/main/get-contacts', 'id' => $model->id]);
} else {
    $getContactsUrl = '';
}

$jsRepeatTypesArray = json_encode(Event::$repeatTypes);
$getSaleItemUrl = Url::to(['/task-manager/get-sale-item']);
$getRentalsItemUrl = Url::to(['/task-manager/get-rental-item']);
$getLeadsItemUrl = Url::to(['/task-manager/get-lead-item']);
$getContactsItemUrl = Url::to(['/task-manager/get-contact-item']);
$script = <<< JS
    var eventGuestsModal = $('#modal-event-guests');
    var contactsBlock = eventGuestsModal.find('.modal-content .modal-body #contacts');
    var invitedGuestsBlock = eventGuestsModal.find('.modal-content .modal-body #invited-guests');
    var guests = [];
    var oldEventContactsIds = $('#eventContactsIds').val();
    
    $('#save-repeat-settings').on('click', function() {
        var currentRepeatType = $('#repeat-type').val();
        var currentRepeatTypeForm = $( '#' + currentRepeatType );
        $('#repeatEndMode').val($('input[name="' + currentRepeatType + '-repeat-type-ends"]:checked').val()); 
        $('#repeatType').val($('#repeat-type').val());
        $('#repeatInterval').val($('.' + currentRepeatType + '-repeat-interval').val());
        $('#repeatStart').val(Date.parse($('input[name="repeat-event-start_time"]').val())/1000);
        var repeatEndTime = $('input[name="' + currentRepeatType + '-repeat-event-end-time"]').val();
        if (repeatEndTime)
          $('#repeatEnd').val(Date.parse(repeatEndTime)/1000);
        var selectedDays = [];
        $('#repeat-weekly-days input:checked').each(function() {
            selectedDays.push($(this).attr('value'));
        });
        $('#repeatWeeklyDays').val(selectedDays);
        $( ".repeat-end-datetime-error" ).hide();
        $('#modal-event-repeat').modal('hide');
        return false;
    }); 
    
    $('#repeat-btn').on('click', function() {
        $( ".repeat-end-datetime-error" ).hide();
        $('#modal-event-repeat').modal('show');
    });
    
    $('.repeat-type-time input[type=radio]').change(function() {
        var currentRepeatType = $('#repeat-type').val();
        if (this.value == 'never') {
            $('#' + currentRepeatType + '-event-end-time-datetime').hide();
        }
        else if (this.value == 'on') {
            $('#' + currentRepeatType + '-event-end-time-datetime').show();
        } 
    });;
    
    $('#repeat-type').on('change', function() {
        $('#repeatEndMode').val(''); 
        $('#repeatType').val('');
        $('#repeatInterval').val('');
        $('#repeatStart').val('');
        $('#repeatEnd').val('');
        $('#repeatWeeklyDays').val('');
      
        $( ".repeat-end-datetime-error" ).hide();
        var repeatStartTime = $('#event-displaystart').val();
        $('input[name="repeat-event-start_time"]').val(repeatStartTime);
        var currentRepeatType = this.value;
        var selOption = $(this).find('option:selected');
        $('span#event-repeat-addon-text').text(selOption.data('addon-text'));
        $('.repeat-section').hide();
        $( '.repeat-section#' + currentRepeatType + '-section' ).show();
        $('#' + currentRepeatType + '-section .repeat-type-interval').empty();
        var maxTypeInterval = selOption.data('max-interval');
        var intervalCounter = 1;
        while ( intervalCounter <= maxTypeInterval ) { 
            $('#' + currentRepeatType + '-section .repeat-type-interval').append('<option value=' + intervalCounter + '>' + intervalCounter + '</option>');
            intervalCounter++;
        }
    });
    
    $('#cancel-contacts').on('click', function() {
        $('#eventContactsIds').val(oldEventContactsIds);
    });
    
    $('body').on('beforeSubmit.yii', 'form#contacts-form', function (e) { 
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
                if (response.result === 'success') {
                    var contact = {
                        id: response.id,
                        email: response.email,
                        first_name: '',
                        last_name: '',
                    }
                    guests.push(contact); 
                    writeToEventContactsIds(contact.id);
                    createContactItem(contact);
                    createGuestItem(contact); 
                    $('#new-contact-email-input').val('');       
                }
             }
        });
    });

    function writeToEventContactsIds(id) {
        var ids = $('#eventContactsIds').val();
        if ( ids.length == 0 )
            $('#eventContactsIds').val(id);
        else
            $('#eventContactsIds').val(ids + ',' + id);
    }
    
    function removeEventContactsIds(id) {
        var idsString = $('#eventContactsIds').val();
        var ids = idsString.split(',');
        var updatedIdsString = '';
        if ( ids.length > 0 ) {
            $.each( ids, function( index, cId ) { 
                if ( index !=0 ) {
                    if ( cId != id )
                        updatedIdsString += ',' + cId;
                }   
                else if ( cId != id ) updatedIdsString += cId;   
            });
        }
        updatedIdsString = updatedIdsString.replace(/^[\,]+|[\,]+$/g, '');
        $('#eventContactsIds').val(updatedIdsString);    
    }
    
    $('body').on('beforeSubmit.yii', 'form#event-form', function (e) { 
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
                if (response.result === 'success') {
                    var eventCalendar = $('#calendar');
                    $.each(response.events, function( index, event ) { 
                        var startEventDate = new Date(event.start * 1000);
                        var endEventDate = new Date(event.end * 1000);  
                        var item = $("#calendar").fullCalendar( 'clientEvents', event.id );
                        if (item[0]) {    
                          item[0].title = event.ownerName;
                          item[0].start = startEventDate;
                          item[0].end = endEventDate; 
                          $('#calendar').fullCalendar('updateEvent', item[0]);
                          } else { 
                            var myEvent = {
                                title: event.ownerName,
                                start: startEventDate,
                                end: endEventDate,
                                id: event.id,
                            }; 
                            eventCalendar.fullCalendar( 'renderEvent', myEvent );
                          }
                    });   
                    $('.repeat-section').hide();
                    $('#repeat-type option:first').prop('selected', true); 
                    $('#modal-event').modal('hide');
                }
            }
        });
        return false;
    }).on('submit', function(e){
        e.preventDefault();
    });

    $('#remove-event').on('click', function() {
        var eventId = $(this).data('id');
        $.ajax({
            url: '$deleteEventUrl?id=' + eventId,
            type: 'post',
            data: {id: eventId},
            success: function (response) {
                if (response.result === 'success') {
                    $('#calendar').fullCalendar('removeEvents', eventId);
                    $('#modal-event').modal('hide');
                } 
            }
            });
        return false;
    });
    
    $('#invite-guests').on('click', function() { 
        invitedGuestsBlock.empty();         
        $.ajax({
            url: '$guestsUrl',
            type: 'post',
            success: function (contacts) {
                contactsBlock.empty();
                $.each(contacts, function( index, contact ) {
                    createContactItem(contact);
                });
                var idsString = $('#eventContactsIds').val();
                var ids = idsString.split(',');
                $.each(ids, function( index, cId ) {
                         $('.invite-contact').each(function( index ) {
                             if ( $(this).data('id') == cId ) {
                                 var guest = {
                                    id: cId,
                                    email: $(this).data('email'),
                                    // first_name: $(this).data('first_name'),
                                    // last_name: $(this).data('last_name'),
                                }
                                guests.push(guest);
                                createGuestItem(guest); 
                             }
                         });
                });
                eventGuestsModal.modal('show');
            }
            });
        return false;
    });
    
    $(document).on('click', '.invite-contact', function (e) { 
        e.preventDefault();
        e.stopImmediatePropagation(); 
        var contactItem = $(this);
        var newGuestFlag = true;
        $.each(guests, function( index, guest ) { 
          if ( guest.id == contactItem.data('id') ) {
                 newGuestFlag = false;
          }
        });
        if (newGuestFlag) {
            var newGuest = {
                id: contactItem.data('id'),
                email: contactItem.data('email'),
                /*first_name: contactItem.data('first_name'),
                last_name: contactItem.data('last_name'),*/
            }; 
            guests.push(newGuest);
            writeToEventContactsIds(newGuest.id);
            createGuestItem(newGuest);
            $('.field-new-contact-email-input').val('');
        }
    });
    
    $(document).on('click', '.guest-contact-remove', function (e) { 
        var guestItem = $(this);
        var updatedGuests = []; 
        $.each(guests, function( index, guest ) { 
          if ( guest.id == guestItem.data('id') ) {
                 $('.guest-item#' + guest.id).remove();
                 removeEventContactsIds(guest.id)
          } else updatedGuests.push(guest);
        }); 
        guests = updatedGuests;
        return false;
    }); 
    
    function createContactItem(contact) {
        var contactItem = '<li style="list-style-type: none;">';
        contactItem += '<a /* data-first_name="' + contact.first_name + '" data-last_name="' + contact.last_name + '" */ ';
        contactItem += ' data-email="' + contact.email + '" data-id="' + contact.id + '" class="invite-contact" href="#">';
        contactItem += '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> ';
        contactItem += '<span class="contact-email">' + contact.email + '</span></a>'; 
       /* if (contact)
          if (contact.first_name && contact.last_name)
           contactItem += '<span class="contact-first-lastname"> ' + contact.first_name + ' ' + contact.last_name + '</span>'; */
        contactItem += '</li>';
        contactsBlock.append(contactItem);
    }
    
    function createGuestItem(newGuest) {  
        var contactItem = '<li class="guest-item" id="' + newGuest.id + '" style="list-style-type: none;">';  
        contactItem += '<a class="guest-contact" href="#">';
        contactItem += '<span class="guest-email">' + newGuest.email + '</span></a> '; 
        contactItem += ' <a data-id="' + newGuest.id + '" class="guest-contact-remove" href="#"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
        contactItem += '</li>';
        invitedGuestsBlock.append(contactItem);
    } 
    
    $("#choosed-sales-list").on("click",".remove-sales-item", function(){
        $(this).closest('li').remove();
        syncSales();
        return false;
    });
    
    $('.open-sales-gridview').on('click', function() {
        $('#modal-sales-gridview').css({"position":"fixed", "top":"50%", "left":"45%", "transform":"translate(-50%, -50%)"}).modal('show');
        return false;
    });
    
    $('.add-sales').on('click', function() {
        var saleId, saleIdsJson;
        var saleIds = [];
        $('#sales-gridview input[type="checkbox"]').each(function( index ) {
          if( $( this ).prop('checked') ) {
              saleId = $( this ).closest('tr').data('key');
              if (saleId) {
                  var isSaleUnique = true;
                  $('#choosed-sales-list li').each(function( index ) {
                      if ($(this).data('id') == saleId)
                          isSaleUnique = false;
                   });
                  if (isSaleUnique) 
                      saleIds.push(saleId);
              } 
          }  
        });
        saleIdsJson = JSON.stringify(saleIds);
        $.post("$getSaleItemUrl", {saleIds: saleIdsJson}, function(data, status){
            $('#choosed-sales-list').append(data);
            syncSales();
        });     
        $('#modal-sales-gridview').modal('hide');
        $('#modal-event').css("overflow-y", "auto");
        return false;
    });
    
    $("#choosed-rentals-list").on("click",".remove-rentals-item", function(){
        $(this).closest('li').remove();
        syncRentals();  
        return false;
    });
    
    $('.open-rentals-gridview').on('click', function() {
        $('#modal-rentals-gridview').css({"position":"fixed", "top":"50%", "left":"45%", "transform":"translate(-50%, -50%)"}).modal('show');
        return false;
    });
    
    $('.add-rentals').on('click', function() {
        var rentalId, rentalIdsJson;
        var rentalIds = [];
        $('#rentals-gridview input[type="checkbox"]').each(function( index ) {
          if( $( this ).prop('checked') ) {
              rentalId = $( this ).closest('tr').data('key');
              if (rentalId) {
                  var isRentalUnique = true;
                  $('#choosed-rentals-list li').each(function( index ) {
                      if ($(this).data('id') == rentalId)
                          isRentalUnique = false;
                   });
                  if (isRentalUnique) 
                      rentalIds.push(rentalId);
              } 
          }  
        });
        rentalIdsJson = JSON.stringify(rentalIds);
        $.post("$getRentalsItemUrl", {rentalIds: rentalIdsJson}, function(data, status){
            $('#choosed-rentals-list').append(data);
            syncRentals();
        });     
        $('#modal-rentals-gridview').modal('hide');
        $('#modal-event').css("overflow-y", "auto");
        return false;
    });
    
    $("#choosed-leads-list").on("click",".remove-leads-item", function(){
        $(this).closest('li').remove();
        syncLeads();  
        return false;
    });   
    
    $('.open-leads-gridview').on('click', function() {
        $('#modal-leads-gridview').css({"position":"fixed", "top":"50%", "left":"45%", "transform":"translate(-50%, -50%)"}).modal('show');
        return false;
    });
    
    $('.add-leads').on('click', function() {
        var leadId, leadIdsJson;
        var leadIds = [];
        $('#leads-gridview input[type="checkbox"]').each(function( index ) {
          if( $( this ).prop('checked') ) {
              leadId = $( this ).closest('tr').data('key');
              if (leadId) {
                  var isLeadUnique = true;
                  $('#choosed-leads-list li').each(function( index ) {
                      if ($(this).data('id') == leadId)
                          isLeadUnique = false;
                   });
                  if (isLeadUnique) 
                      leadIds.push(leadId);
              } 
          }  
        });
        leadIdsJson = JSON.stringify(leadIds);
        $.post("$getLeadsItemUrl", {leadIds: leadIdsJson}, function(data, status){
            $('#choosed-leads-list').append(data);
            syncLeads();
        });     
        $('#modal-leads-gridview').modal('hide');
        $('#modal-event').css("overflow-y", "auto");
        return false;
    }); 
    
    $("#choosed-contacts-list").on("click",".remove-contacts-item", function(){
        $(this).closest('li').remove();
        syncContacts();  
        return false;
    });   
    
    $('.open-contacts-gridview').on('click', function() {
        $('#modal-contacts-gridview').css({"position":"fixed", "top":"50%", "left":"45%", "transform":"translate(-50%, -50%)"}).modal('show');
        return false;
    });
    
    $('.add-contacts').on('click', function() {
        var contactId, contactIdsJson;
        var contactIds = [];
        $('#contacts-gridview input[type="checkbox"]').each(function( index ) {
          if( $( this ).prop('checked') ) {
              contactId = $( this ).closest('tr').data('key');
              if (contactId) {
                  var isContactUnique = true;
                  $('#choosed-contacts-list li').each(function( index ) {
                      if ($(this).data('id') == contactId)
                          isContactUnique = false;
                   });
                  if (isContactUnique) 
                      contactIds.push(contactId);
              } 
          }  
        });
        contactIdsJson = JSON.stringify(contactIds);
        $.post("$getContactsItemUrl", {contactIds: contactIdsJson}, function(data, status){
            $('#choosed-contacts-list').append(data);
            syncContacts();
        });     
        $('#modal-contacts-gridview').modal('hide');
        $('#modal-event').css("overflow-y", "auto");
        return false;
    }); 
    
    
    function syncSales() {
        var saleId, saleIdsJson;
        var saleIds = [];
        $('#choosed-sales-list li').each(function( index ) {
          saleId = $(this).data('id');
              if (saleId)
                saleIds.push(saleId);
        });  
        saleIdsJson = JSON.stringify(saleIds);
        $('#event-salesids').val(saleIdsJson); 
    }
    
    function syncRentals() {
        var rentalId, rentalIdsJson;
        var rentalIds = [];
        $('#choosed-rentals-list li').each(function( index ) {
          rentalId = $(this).data('id');
              if (rentalId)
                rentalIds.push(rentalId);
        });  
        rentalIdsJson = JSON.stringify(rentalIds);
        $('#event-rentalsids').val(rentalIdsJson); 
    }
    
    function syncLeads() {
        var leadId, leadIdsJson;
        var leadIds = [];
        $('#choosed-leads-list li').each(function( index ) {
          leadId = $(this).data('id');
              if (leadId)
                leadIds.push(leadId);
        });  
        leadIdsJson = JSON.stringify(leadIds);
        $('#event-leadsids').val(leadIdsJson); 
    }

    function syncContacts() {
        var contactId, contactIdsJson;
        var contactIds = [];
        $('#choosed-contacts-list li').each(function( index ) {
          contactId = $(this).data('id');
              if (contactId)
                contactIds.push(contactId);
        });  
        contactIdsJson = JSON.stringify(contactIds);
        $('#event-contactsids').val(contactIdsJson); 
    }
JS;
$this->registerJs($script, yii\web\View::POS_READY);