<?php

use app\models\Company;
use app\models\Leads;
use app\models\User;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Leads */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="leads-form">

        <?php $form = ActiveForm::begin(['id' => 'lead-form']); ?>

        <?php
        $types = \app\modules\lead\models\LeadType::find()->all();
        $items = ArrayHelper::map($types, 'id', 'title');
        $params = [
            'prompt' => Yii::t('app', 'Select type')
        ];
        echo $form->field($model, 'type_id')->dropDownList($items, $params);
        ?>

        <?php
        $items = [
            Leads::STATUS_OPEN => Yii::t('app', 'Open'),
            Leads::STATUS_CLOSED => Yii::t('app', 'Closed'),
            Leads::STATUS_NOT_SPECIFIED => Yii::t('app', 'Not Specified')
        ];
        $params = [
            'prompt' => Yii::t('app', 'Select status')
        ];
        echo $form->field($model, 'status')->dropDownList($items, $params);
        ?>

        <?php
        $subStatuses = \app\modules\lead\models\LeadSubStatus::find()->all();
        $items = ArrayHelper::map($subStatuses, 'id', 'title');
        $params = [
            'prompt' => Yii::t('app', 'Select sub status')
        ];
        echo $form->field($model, 'sub_status_id')->dropDownList($items, $params);
        ?>

        <?php
        $items = [
            Leads::PRIORITY_URGENT => Yii::t('app', 'Urgent'),
            Leads::PRIORITY_HIGH => Yii::t('app', 'High'),
            Leads::PRIORITY_NORMAL => Yii::t('app', 'Normal'),
            Leads::PRIORITY_LOW => Yii::t('app', 'Low'),
        ];
        $params = [
            'prompt' => Yii::t('app', 'Select priority')
        ];
        echo $form->field($model, 'priority')->dropDownList($items, $params);
        ?>

        <?= $form->field($model, 'hot_lead')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'mobile_number')->widget(
            borales\extensions\phoneInput\PhoneInput::className()
        );
        ?>

        <?php
        $categories = \app\models\reference_books\PropertyCategory::find()->all();
        $items = ArrayHelper::map($categories, 'id', 'title');
        $params = [
            'prompt' => Yii::t('app', 'Select category')
        ];
        echo $form->field($model, 'category_id')->dropDownList($items, $params);
        ?>

        <?= $form->field($model, 'emirate')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sub_location')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'unit_type')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'unit_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'min_beds')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'max_beds')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'min_price')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'max_price')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'min_area')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'max_area')->textInput(['maxlength' => true]) ?>

        <?php
        $sources = \app\modules\lead\models\CompanySource::find()->all();
        $items = ArrayHelper::map($sources, 'id', 'title');
        $params = [
            'prompt' => Yii::t('app', 'Select source')
        ];
        echo $form->field($model, 'source')->dropDownList($items, $params);
        ?>

        <?= $form->field($model, 'listing_ref')->textInput(['maxlength' => true]) ?>


        <?php
        $items = [
            Leads::FINANCE_TYPE_CASH => Yii::t('app', 'Cash'),
            Leads::FINANCE_TYPE_LOAN_APPROVED => Yii::t('app', 'Loan (approved)'),
            Leads::FINANCE_TYPE_LOAN_NOT_APPROVED => Yii::t('app', 'Loan (not approved)'),
        ];
        $params = [
            'prompt' => Yii::t('app', 'Select finance type')
        ];
        echo $form->field($model, 'finance_type')->dropDownList($items, $params);
        ?>

        <?php
        if ($model->enquiry_time)
            $enquiryTimeValue = (!$model->isNewRecord) ? date('Y-m-d H:i', $model->enquiry_time) : '';
        else
            $enquiryTimeValue = '';
        echo $form->field($model, 'enquiry_time')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => 'Enter enquiry time ...', 'value' => $enquiryTimeValue],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd hh:ii'
            ]
        ]);
        ?>

        <?= $form->field($model, 'agent_referrala')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'shared_leads')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'contract_company')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?php
        if (!$model->isNewRecord) {
            $leadSocialMediaContacts = \app\modules\lead\models\LeadSocialMediaContact::find()->where(['lead_id' => $model->id])->asArray()->all();
            $formLeadSocialMediaContacts = [];
            foreach ($leadSocialMediaContacts as $leadSocialMediaContact) {
                unset($leadSocialMediaContact['id']);
                unset($leadSocialMediaContact['lead_id']);
                $formLeadSocialMediaContacts[] = $leadSocialMediaContact;
            }
            $model->socialMediaContacts = Json::encode($formLeadSocialMediaContacts);
        }
        ?>
        <div style="display: none">
            <?= $form->field($model, 'created_by_user_id')->textInput() ?>
            <?= $form->field($model, 'updated_time')->textInput() ?>
            <?= $form->field($model, 'company_id')->textInput() ?>
            <?= $form->field($model, 'socialMediaContacts')->textInput() ?>
        </div>
        <div id="social-media-contact" class="form-group" style="margin-bottom: 10px">
            <div style="padding-bottom: 5px;">
                <label class="control-label"><?= Yii::t('app', 'Social Media Contacts') ?></label>
                <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', '#', ['class' => "btn-default add-social-media-contact btn"]) ?>
            </div>
            <div id="social-media-contact-block">
                <?php
                if ($formLeadSocialMediaContacts) {
                    foreach ($formLeadSocialMediaContacts as $formLeadSocialMediaContact)
                        echo $this->render('_social_media_contact_input', ['formLeadSocialMediaContact' => $formLeadSocialMediaContact]);
                }
                ?>
            </div>
        </div>

        <div id="lead-notes" class="form-group" style="margin-bottom: 10px">
            <div style="padding-bottom: 5px;">
                <label class="control-label"><?= Yii::t('app', 'Notes') ?></label>
                <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', '#', ['class' => "btn-default add-note btn"]) ?>
            </div>
            <div id="notes-block">
                <?php
                if (!$model->isNewRecord) {
                    $notes = \app\modules\lead\models\LeadNote::find()->where(['lead_id' => $model->id])->asArray()->all();
                    $formNotes = [];
                    foreach ($notes as $note)
                        $formNotes[] = $note['text'];
                    $model->notesAttr = Json::encode($formNotes);
                }
                if ($notes) {
                    foreach ($notes as $note)
                        echo $this->render('_lead_note', ['note' => $note['text']]);
                }
                ?>
            </div>
        </div>
        <div style="/*display: none*/;"><?= $form->field($model, 'notesAttr')->textInput() ?></div>

        <div id="additional-email" class="form-group" style="margin-bottom: 10px">
            <div style="padding-bottom: 5px;">
                <label class="control-label"><?= Yii::t('app', 'Additional Emails') ?></label>
                <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', '#', ['class' => "btn-default add-additional-email btn"]) ?>
            </div>
            <div id="additional-email-block">
                <?php
                if (!$model->isNewRecord) {
                    $additionalEmails = \app\modules\lead\models\LeadAdditionalEmail::find()->where(['lead_id' => $model->id])->asArray()->all();
                    $formAdditionalEmails = [];
                    foreach ($additionalEmails as $additionalEmail) {
                        unset($leadSocialMediaContact['id']);
                        unset($leadSocialMediaContact['lead_id']);
                        $formAdditionalEmails[] = $additionalEmail['email'];
                    }
                    $model->additionalEmails = Json::encode($formAdditionalEmails);
                }
                if ($additionalEmails) {
                    foreach ($additionalEmails as $additionalEmail)
                        echo $this->render('_additional_email_input', ['additionalEmail' => $additionalEmail['email']]);
                }
                ?>
            </div>
            <div style="display: none;"><?= $form->field($model, 'additionalEmails')->textInput() ?></div>

            <div id="agents" class="form-group" style="margin-bottom: 10px">
                <div style="padding-bottom: 5px;">
                    <label class="control-label"><?= Yii::t('app', 'Agents') ?></label>
                    <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', '#', ['class' => "btn-default add-agent btn"]) ?>
                </div>
                <div id="agents-block">
                    <?php
                    if (!$model->isNewRecord) {
                        $agents = \app\modules\lead\models\LeadAgent::find()->where(['lead_id' => $model->id])->asArray()->all();
                        $formAgents = [];
                        foreach ($agents as $agent) {
                            unset($agent['id']);
                            unset($agent['lead_id']);
                            $formAgents[] = $agent['user_id'];
                        }
                        $model->agents = Json::encode($formAgents);
                    }
                    if ($agents) {
                        foreach ($agents as $agent)
                            echo $this->render('_agents_input', ['agent' => $agent['user_id'], 'companyAgents' => $companyAgents]);
                    }
                    ?>
                </div>
            </div>
            <div style="display: none;"><?= $form->field($model, 'agents')->textInput() ?></div>

            <?= $form->field($model, 'email_opt_out')->checkbox() ?>
            <?= $form->field($model, 'phone_opt_out')->checkbox() ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$socialMediaContactBlockUrl = Url::to(['/leads/social-media-contacts-block']);
$additionalEmailField = $this->render('_additional_email_input', ['additionalEmail' => '']);
$additionalEmailField = preg_replace("/\r|\n/", "", $additionalEmailField);
$leadNoteField = $this->render('_lead_note');
$leadNoteField = preg_replace("/\r|\n/", "", $leadNoteField);
$agentField = $this->render('_agents_input', ['companyAgents' => $companyAgents]);
$agentField = preg_replace("/\r|\n/", "", $agentField);
$script = <<<JS
$('#lead-notes').on("click",".add-note", function(){
    $('#notes-block').prepend('$leadNoteField');
    return false; 
}) 
$('#lead-notes').on("keyup",".lead-note-field", function(){
  getNotes();
});  
$('#lead-notes').on("click",".remove-lead-note", function(){
    $(this).closest('.lead-note-item').remove();
    getNotes();
    return false;   
}) 
function getNotes() {
    var notesArr = [];
    $( ".lead-note-item" ).each(function( index ) {
      var noteItem = $(this).find( ".lead-note-field" ).val();
      notesArr.push(noteItem);
    }); 
    $('#leads-notesattr').val(JSON.stringify(notesArr));  
} 
$('#agents').on("click",".add-agent", function(){ 
    $('#agents-block').prepend('$agentField');
    return false; 
}) 
$('#agents').on("change",".agent-field", function(){
  getAgents();
});
$('#agents').on("click",".remove-agent", function(){
    $(this).closest('.agent-item').remove();
    getAgents();
    return false; 
})
function getAgents() {
    var agentsArr = [];
    $( ".agent-item" ).each(function( index ) {
      var agentItem = $(this).find( ".agent-field" ).val();
      if(jQuery.inArray(agentItem, agentsArr) == -1)
        agentsArr.push(agentItem);
    });  
    $('#leads-agents').val(JSON.stringify(agentsArr)); 
} 
$('body').on('beforeSubmit', 'form#lead-form', function () {
             var filedIsNotEmailError = false;
             var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
             $( ".additional-email-item" ).each(function( index ) {
                  var additionalEmailItem = $(this).find( ".additional-email-field" ).val();
                  if (!additionalEmailItem.match(re)) {
                       filedIsNotEmailError = true;
                       $(this).children('div').addClass('has-error');
                       $(this).find('.help-block').show();
                  } else {   
                      $(this).children('div').removeClass('has-error');
                      $(this).find('.help-block').hide();
                  }
                     
             });
             if (filedIsNotEmailError)
                 return false;
        });
$('#additional-email').on("click",".add-additional-email", function(){
    $('#additional-email-block').prepend('$additionalEmailField');
    return false; 
})  
$('#additional-email').on("keyup",".additional-email-field", function(){
  getAdditionalEmails();
}); 
$('#additional-email').on("click",".remove-additional-email", function(){
    $(this).closest('.additional-email-item').remove();
    getAdditionalEmails();
    return false; 
}) 
function getAdditionalEmails() {
    var additionalEmailArr = [];
    $( ".additional-email-item" ).each(function( index ) {
      var additionalEmailItem = $(this).find( ".additional-email-field" ).val();
      additionalEmailArr.push(additionalEmailItem);
    });  
    $('#leads-additionalemails').val(JSON.stringify(additionalEmailArr)); 
} 
$('#social-media-contact').on("click",".add-social-media-contact", function(){
    $.ajax({ type: "GET",   
         url: "$socialMediaContactBlockUrl",   
         async: false,
         success : function(response)
         {
             $('#social-media-contact-block').prepend(response);
         }
    });
    return false; 
})    
$('#social-media-contact').on("click",".remove-social-media-contact", function(){
    $(this).closest('.social-media-contact-item').remove();
    getSocialMediaContacts();
    return false; 
})  
$('#social-media-contact').on("change",".social-media-contact-type", function(){
  getSocialMediaContacts();
}) 
$('#social-media-contact').on("keyup",".social-media-contact-link", function(){
  getSocialMediaContacts();
}); 
function getSocialMediaContacts() {
    var socialMediaContactArr = [];
    $( ".social-media-contact-item" ).each(function( index ) {
      var socialMediaContactItem = {};
      socialMediaContactItem.type = $(this).find( ".social-media-contact-type option:selected" ).val();
      socialMediaContactItem.link = $(this).find( ".social-media-contact-link" ).val();
      socialMediaContactArr.push(socialMediaContactItem);
    });
    $('#leads-socialmediacontacts').val(JSON.stringify(socialMediaContactArr)); 
} 
JS;
$this->registerJs($script, yii\web\View::POS_READY);
