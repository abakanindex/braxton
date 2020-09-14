<?php

use app\models\agent\Agent;
use app\models\Reminder;
use app\modules\lead_viewing\models\LeadViewing;
use app\widgets\LeadViewingWidget;
use app\widgets\ReminderInfoWidget;
use app\widgets\ReminderWidget;
use lo\widgets\modal\ModalAjax;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Leads */

$this->title = $model->reference;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$currentUser = \app\models\User::findOne(Yii::$app->user->id);
?>
    <div class="leads-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
        <div id="contact-note-block" style="margin-bottom: 10px;">
            <?php
            if (!$model->contactNote) {
                if (Yii::$app->user->id == $model->created_by_user_id)
                    echo Html::a(Yii::t('app', 'Create Contact Note'), ['/lead/lead-contact-note/create', 'id' => $model->id], ['class' => 'btn btn-primary']);
            } else {
                echo '<p id="contact-note-text" style="margin-right: 10px">';
                echo Yii::t('app', 'Contact Note') . ': ';
                echo $model->contactNote->note . '</p>';
                echo '<span id="contact-note-user" style="margin-right: 10px">';
                echo Yii::t('app', 'Agent') . ': ';
                echo $currentUser->username . '</span>';
                echo '<span id="contact-note-created" style="margin-right: 10px">';
                echo Yii::t('app', 'Created At') . ': ';
                echo date('Y-m-d', $model->contactNote->created_at) . '</span>';
                if (Yii::$app->user->id == $model->created_by_user_id)
                    echo Html::a(Yii::t('app', 'Update Contact Note'), ['/lead/lead-contact-note/update', 'id' => $model->contactNote->id], ['class' => 'btn btn-primary']);
            }
            ?>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= LeadViewingWidget::widget([
                    'leadId' => $model->id,
                    'action' => LeadViewing::ACTION_CREATE,
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Details'); ?></div>
                    <div class="panel-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                [
                                    'attribute' => 'type_id',
                                    'value' => $model->getType(),
                                ],
                                [
                                    'attribute' => 'status',
                                    'value' => $model->getStatus(),
                                ],
                                [
                                    'attribute' => 'sub_status_id',
                                    'value' => $model->subStatus->title,
                                ],
                                [
                                    'attribute' => 'priority',
                                    'value' => $model->getPriority(),
                                ],
                                'first_name',
                                'last_name',
                                'mobile_number',
                                [
                                    'attribute' => 'category_id',
                                    'value' => $model->category->title,
                                ],
                                'hot_lead',
                                'emirate',
                                'location',
                                'sub_location',
                                'unit_type',
                                'unit_number',
                                'min_beds',
                                'max_beds',
                                'min_price',
                                'max_price',
                                'min_area',
                                'max_area',
                                [
                                    'attribute' => 'source',
                                    'value' => $model->companySource->title,
                                ],
                                'listing_ref',
                                [
                                    'attribute' => 'created_by_user_id',
                                    'value' => $model->getCreatedUserFullname(),
                                ],
                                'agent_1',
                                'agent_2',
                                'agent_3',
                                'agent_4',
                                'agent_5',
                                /*[
                                    'label'  => Yii::t('app', 'Agents'),
                                    'format'  => 'raw',
                                    'value'  => call_user_func(function ($model) {
                                        $agentsList = '<ul style="list-style: none">';
                                        foreach ($model->leadAgents as $agent)
                                            $agentsList .= '<li>' . $agent->agent->username . '</li>';
                                        $agentsList .= '</ul>';
                                        return $agentsList;
                                    }, $model),
                                ],*/
                                [
                                    'attribute' => 'finance_type',
                                    'value' => $model->getFinanceType(),
                                ],
                                'enquiry_time:datetime',
                                'updated_time:datetime',
                                'contract_company',
                                'email:email',
                                'agent_referrala',
                                'shared_leads',
                                [
                                    'label' => Yii::t('app', 'Aditional Emails'),
                                    'format' => 'raw',
                                    'value' => call_user_func(function ($model) {
                                        $additionalEmailsList = '<ul style="list-style: none">';
                                        foreach ($model->additionalEmailsList as $additionalEmails)
                                            $additionalEmailsList .= '<li>' . $additionalEmails->email . '</li>';
                                        $additionalEmailsList .= '</ul>';
                                        return $additionalEmailsList;
                                    }, $model),
                                ],
                                'notes:ntext',
                                [
                                    'label' => Yii::t('app', 'Social Media Contacts'),
                                    'format' => 'raw',
                                    'value' => call_user_func(function ($model) {
                                        $socialMediaContactsList = '<ul style="list-style: none">';
                                        foreach ($model->leadSocialMeadiaContacts as $socialMediaContact) {
                                            $socialMediaContactsList .= '<li>' . Html::a(FA::icon($socialMediaContact->getBtnClass()), $socialMediaContact->link, ['target' => '_blank']) . '</li>';
                                        }
                                        $socialMediaContactsList .= '</ul>';
                                        return $socialMediaContactsList;
                                    }, $model),
                                ],
                                [
                                    'label' => Yii::t('app', 'Agents'),
                                    'format' => 'raw',
                                    'value' => call_user_func(function ($model) {
                                        $leadAgentsList = '<ul style="list-style: none">';
                                        foreach ($model->leadAgents as $leadAgent) {
                                            $leadAgentsList .= '<li>' . $leadAgent->agent->username . '</li>';
                                        }
                                        $leadAgentsList .= '</ul>';
                                        return $leadAgentsList;
                                    }, $model),
                                ]
                            ],
                        ]) ?>
                        <?= ReminderInfoWidget::widget(['keyId' => $model->id, 'keyType' => Reminder::KEY_TYPE_LEAD]) ?>
                        <h4><?= Yii::t('app', 'Properities') ?></h4>
                        <ul style="list-style: none">
                            <?php
                            foreach ($model->leadProperties as $leadProperty) {
                                echo '<li>';
                                $leadType = explode("-", $leadProperty->property->ref);
                                if ($leadType[1] == 'S') {
                                    $url = Yii::$app->getUrlManager()->createUrl([
                                        'sale/view',
                                        'id' => $leadProperty->property->id,
                                    ]);
                                    $url .= '?page=1';
                                    echo Html::a($leadProperty->property->slug, ['sale/view', 'id' => $leadProperty->property->id]);
                                } elseif ($leadType[1] == 'R') {
                                    $url = Yii::$app->getUrlManager()->createUrl([
                                        'rentals/view',
                                        'id' => $leadProperty->property->id,
                                    ]);
                                    $url .= '?page=1';
                                    echo Html::a($leadProperty->property->slug, ['rentals/view', 'id' => $leadProperty->property->id]);
                                }
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Property Requirements'); ?></div>
                    <div class="panel-body">
                        <?php
                        $createPropertyRequirementUrl = Url::to(['/lead/property-requirement/create']);
                        echo Html::a(Yii::t('app', 'Add Property Requirement'), '#', [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'modal',
                            'data-target' => '#propertyRequirementForm'
                        ]);
                        Pjax::begin(['id' => 'property-requirement-list']);
                        echo ListView::widget([
                            'dataProvider' => $propertyRequirementDataProvider,
                            'itemView' => '_property_requirement_list',
                        ]);
                        Pjax::end();
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Yii::t('app', 'Matching Properties'); ?></div>
                    <div class="panel-body">
                        <?= Html::a(Yii::t('app', 'Apply All Properies'), '#', [
                            'class' => 'btn btn-default',
                            'style' => 'margin-bottom: 10px',
                            'id' => 'apply-all-requirements-btn',
                        ]);
                        echo Tabs::widget([
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Sales'),
                                    'options' => ['id' => 'matching-sales-list'],
                                    'active' => true
                                ],
                                [
                                    'label' => Yii::t('app', 'Rentals'),
                                    'options' => ['id' => 'matching-rentals-list'],
                                ]]]);
                        ?>
                    </div>
                </div>
            </div>

        </div>

    </div>

<?php
echo ModalAjax::widget([
    'id' => 'propertyRequirementForm',
    'header' => 'Property Requirement',
    'toggleButton' => [
        'label' => false,
        'class' => 'btn btn-primary pull-right'
    ],
    'url' => Url::to(['/lead/property-requirement/create', 'leadId' => $model->id]),
    'ajaxSubmit' => true,
    'autoClose' => true,
    'pjaxContainer' => '#property-requirement-list',
    'options' => ['class' => 'header-primary'],
    'events' => [
        ModalAjax::EVENT_MODAL_SUBMIT => new \yii\web\JsExpression("
            function(event, data, status, xhr, selector) {
                if(data.success){
                    bootbox.alert('" . Yii::t('app', 'Property Requirement was created') . "');
                    $(this).modal('toggle');
                    $.pjax.reload({container: '#property-requirement-list'});
                    $('#matching-sales-list').empty();
                    $('#matching-rentals-list').empty();
                }
            }
        ")
    ]
]);


echo ModalAjax::widget([
    'id' => 'updatePropertyRequirementForm',
    'selector' => 'a.update-property-requirement',
    'ajaxSubmit' => true,
    'autoClose' => true,
    'options' => ['class' => 'header-primary'],
    'pjaxContainer' => '#property-requirement-list',
    'events' => [
        ModalAjax::EVENT_MODAL_SUBMIT => new \yii\web\JsExpression("
            function(event, data, status, xhr, selector) {
                if(data.success){
                    bootbox.alert('" . Yii::t('app', 'Property Requirement was updated') . "');
                    $(this).modal('toggle');
                    $.pjax.reload({container: '#property-requirement-list'});
                    $('#matching-sales-list').empty();
                    $('#matching-rentals-list').empty();
                }
            }
        ")
    ]

]);
$matchingSalesListUrl = Url::to(['/leads/matching-sales-list', 'SaleSearch[requirement]' => true]);
$matchingRentalsListUrl = Url::to(['/leads/matching-rentals-list', 'RentalsSearch[requirement]' => true]);
$propertySalesRequiremetAllUrl = Url::to(['/leads/matching-sales-list', 'all_requirements' => true, 'propertyRequirementLeadId' => $model->id]);
$propertyRentalsRequiremetAllUrl = Url::to(['/leads/matching-rentals-list', 'all_requirements' => true, 'propertyRequirementLeadId' => $model->id]);
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

JS;
$this->registerJs($script, yii\web\View::POS_READY);
JS;
