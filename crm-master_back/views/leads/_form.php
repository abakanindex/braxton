<?php
use app\models\Company;
use app\models\Leads;
use app\models\User;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//use lo\widgets\modal\ModalAjax;

$types = \app\modules\lead\models\LeadType::find()->all();
$items = ArrayHelper::map($types, 'id', 'title');
$params = [
    'prompt' => Yii::t('app', 'Select type')
];
?>


<?= $this->render('@app/views/modals/_searchLocation', [
    'locationsAll' => $locationsAll
])?>

    <div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->
        <?php if (
            Yii::$app->controller->action->id === 'create' or
            Yii::$app->controller->action->id === 'update'
        ):
            ?>
        <?php else: ?>
            <div class="contact-top-column-height">
                <div class="contact-big-block"><!-- Owner -->
                    <div class="owner-head">
                        <div class="owner-name">
                            <h4>Lead</h4>
                        </div>

                    </div>
                    <div class="owner-property property-list">
                        <p><i class="fa fa-user"></i><?= $model->first_name ?> <?= $model->last_name ?></p>
                        <p><i class="fa fa-mobile"></i><?= $model->mobile_number ?></p>
                        <p><i class="fa fa-envelope"></i><?= $model->email ?></p>
                    </div>
                </div><!--/Owner-->
            </div>
        <?php endif; ?>
        <?php
        if (Yii::$app->controller->action->id === 'create')
            echo $form->field($model, 'reminder')->textInput(['style' => 'display: none', 'id' => 'reminder', 'maxlength' => true, 'class' => 'form-control'])->label(false);
        ?>
        <div class="contact-bottom-column-height">
            <div class="contact-small-block">
                <h3>Lead information</h3>
                <div class="property-list">
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">First Name</label>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Last Name</label>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Mobile Number</label>
                        <div class="col-sm-6">
                            <?php
                            $dataOptionsPhone = [];

                            if (Yii::$app->controller->action->id == 'create') {
                                $dataOptionsPhone = [
                                    'jsOptions' => [
                                        'initialCountry' => 'ae',
                                    ]
                                ];
                            }
                            echo $form->field($model, 'mobile_number')->widget(
                                borales\extensions\phoneInput\PhoneInput::className(),
                                $dataOptionsPhone
                            )->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label"><?= $model->getAttributeLabel('phone_opt_out')?></label>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'phone_opt_out')->checkbox(['class' => 'height-auto', 'label' => false])?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Email</label>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'email')->textInput([
                                'maxlength' => true,
                                'class' => 'form-control'
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-6 control-label"><?= $model->getAttributeLabel('email_opt_out')?></label>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'email_opt_out')->checkbox(['class' => 'height-auto', 'label' => false])?>
                        </div>
                    </div>
                    <div id="social-media-contact" class="form-group" style="margin-bottom: 10px">
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
                        <div style="padding-bottom: 5px;">
                            <label class="control-label"><?= Yii::t('app', 'Social Media Links') ?></label>
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
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Agent Referral</label>
                        <div class="col-sm-6">
                            <?= Html::input('text', '', ($model->agentReferral->username) ? $model->agentReferral->username : Yii::t('app', ' Select'), [
                                'readonly'    => true,
                                'class'       => 'form-control cursor-pointer',
                                'autocomplete'=> 'off',
                                'data-toggle' => 'modal',
                                'data-target' => '#users-gridview',
                                'id'          => 'lead-agent-referral-selected'
                            ])?>

                            <?= $form->field($model, 'agent_referrala')->hiddenInput([
                                'readonly'    => true,
                                'class'       => 'form-control cursor-pointer',
                                'autocomplete'=> 'off',
                                'data-toggle' => 'modal',
                                'data-target' => '#users-gridview',
                                'id'          => 'lead-agent-referral'
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Type</label>
                        <div class="col-sm-6">
                            <?php
                            $types = \app\modules\lead\models\LeadType::find()->all();
                            $items = ArrayHelper::map($types, 'id', 'title');
                            $params = [
                                'prompt' => Yii::t('app', 'Select type'),
                                'class' => 'form-control'
                            ];
                            echo $form->field($model, 'type_id')->dropDownList($items, $params)->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Status</label>
                        <div class="col-sm-6">
                            <?php
                            $items = [
                                Leads::STATUS_OPEN => Yii::t('app', 'Open'),
                                Leads::STATUS_CLOSED => Yii::t('app', 'Closed'),
                                Leads::STATUS_NOT_SPECIFIED => Yii::t('app', 'Not Specified')
                            ];
                            $params = [
                                'prompt' => Yii::t('app', 'Select status'),
                                'class' => 'form-control'
                            ];
                            echo $form->field($model, 'status')->dropDownList($items, $params)->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Sub Status</label>
                        <div class="col-sm-6">
                            <?php
                            $subStatuses = \app\modules\lead\models\LeadSubStatus::find()->all();
                            $items = ArrayHelper::map($subStatuses, 'id', 'title');
                            $params = [
                                'prompt' => Yii::t('app', 'Select sub status'),
                                'class' => 'form-control'
                            ];
                            echo $form->field($model, 'sub_status_id')->dropDownList($items, $params)->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Priority</label>
                        <div class="col-sm-6">
                            <?php
                            $items = [
                                Leads::PRIORITY_URGENT => Yii::t('app', 'Urgent'),
                                Leads::PRIORITY_HIGH => Yii::t('app', 'High'),
                                Leads::PRIORITY_NORMAL => Yii::t('app', 'Normal'),
                                Leads::PRIORITY_LOW => Yii::t('app', 'Low'),
                            ];
                            $params = [
                                'prompt' => Yii::t('app', 'Select priority'),
                                'class' => 'form-control'
                            ];
                            echo $form->field($model, 'priority')->dropDownList($items, $params)->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Source</label>
                        <div class="col-sm-6">
                            <?php
                            $params = [
                                'prompt' => Yii::t('app', 'Select source'),
                                'class' => 'form-control'
                            ];
                            echo $form->field($model, 'source')->dropDownList($source, $params)->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Listing Reference</label>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'listing_ref')->textInput([
                                'maxlength' => true,
                                'class' => 'form-control'
                            ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Finance Type</label>
                        <div class="col-sm-6">
                            <?php
                            $items = [
                                Leads::FINANCE_TYPE_CASH => Yii::t('app', 'Cash'),
                                Leads::FINANCE_TYPE_LOAN_APPROVED => Yii::t('app', 'Loan (approved)'),
                                Leads::FINANCE_TYPE_LOAN_NOT_APPROVED => Yii::t('app', 'Loan (not approved)'),
                            ];

                            $params = [
                                'prompt' => Yii::t('app', 'Select finance type'),
                                'class' => 'form-control',

                            ];

                            echo $form->field($model, 'finance_type')->dropDownList($items, $params)->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputSourceOflisting" class="col-sm-6 control-label">Enquiry Time</label>
                        <div class="col-sm-6">
                            <?php
                            if ($model->enquiry_time) {
                                $enquiryTimeValue = (!$model->isNewRecord) ? date('Y-m-d H:i', $model->enquiry_time) : '';
                            } else {
                                $enquiryTimeValue = '';

                                echo $form->field($model, 'enquiry_time')->widget(DateTimePicker::classname(), [
                                    'options' => [
                                        'placeholder' => 'Enter enquiry time ...',
                                        'value' => $enquiryTimeValue,
                                        'class' => 'form-control',

                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd hh:ii'
                                    ]
                                ])->label(false);
                            }
                            ?>
                        </div>
                    </div>



<!--                    <div id="additional-email" class="form-group" style="margin-bottom: 10px">-->
<!--                        <div style="padding-bottom: 5px;">-->
<!--                            <label class="control-label">--><?//= Yii::t('app', 'Additional Emails') ?><!--</label>-->
<!--                            --><?//= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', '#', ['class' => "btn-default add-additional-email btn"]) ?>
<!--                        </div>-->
<!--                        <div id="additional-email-block">-->
<!--                            --><?php
//                            if (!$model->isNewRecord) {
//                                $additionalEmails = \app\modules\lead\models\LeadAdditionalEmail::find()->where(['lead_id' => $model->id])->asArray()->all();
//                                $formAdditionalEmails = [];
//                                foreach ($additionalEmails as $additionalEmail) {
//                                    unset($leadSocialMediaContact['id']);
//                                    unset($leadSocialMediaContact['lead_id']);
//                                    $formAdditionalEmails[] = $additionalEmail['email'];
//                                }
//                                $model->additionalEmails = Json::encode($formAdditionalEmails);
//                            }
//                            if ($additionalEmails) {
//                                foreach ($additionalEmails as $additionalEmail)
//                                    echo $this->render('_additional_email_input', ['additionalEmail' => $additionalEmail['email']]);
//                            }
//                            ?>
<!--                        </div>-->
<!--                        <div style="display: none;">--><?//= $form->field($model, 'additionalEmails')->textInput() ?><!--</div>-->
<!--                    </div>-->

                </div>
            </div>
        </div>
    </div><!-- /Left Contact part-->


<?php

$matchingSalesListUrl = Url::to([
    '/leads/matching-sales-list',
    'SaleSearch[requirement]' => true
]);
$matchingRentalsListUrl = Url::to([
    '/leads/matching-rentals-list',
    'RentalsSearch[requirement]' => true
]);
$propertySalesRequiremetAllUrl = Url::to([
    '/leads/matching-sales-list',
    'all_requirements' => true,
    'propertyRequirementLeadId' => $model->id
]);
$propertyRentalsRequiremetAllUrl = Url::to([
    '/leads/matching-rentals-list',
    'all_requirements' => true,
    'propertyRequirementLeadId' => $model->id
]);

$socialMediaContactBlockUrl = Url::to(['/leads/social-media-contacts-block']);
$additionalEmailField = $this->render('_additional_email_input', ['additionalEmail' => '']);
$additionalEmailField = preg_replace("/\r|\n/", "", $additionalEmailField);
$agentField = $this->render('_agents_input', ['companyAgents' => $companyAgents]);
$agentField = preg_replace("/\r|\n/", "", $agentField);

$script = <<<JS
$('#apply-all-requirements-btn').on('click', function (e) {
    $('#matching-sales-list').load('$propertySalesRequiremetAllUrl');   
    $('#matching-rentals-list').load('$propertyRentalsRequiremetAllUrl');   
    return false;
}) 

$('#property-requirement-list').on('show.bs.collapse', function (e) { 
    var salesParameters =  $(e.target).data('sales-parameters');  
    $('#matching-sales-list').load('$matchingSalesListUrl&' + salesParameters);   
    var rentalsParameters =  $(e.target).data('rentals-parameters'); 
    $('#matching-rentals-list').load('$matchingRentalsListUrl&' + rentalsParameters); 
})   

$('#property-requirement-list').on('hide.bs.collapse', function () { 
    $('#matching-sales-list').empty();
    $('#matching-rentals-list').empty();
}) 

$('#agents').on("click",".add-agent", function(){ 
    $('#agents-block').prepend('$agentField');
    getAgents();   
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

?>