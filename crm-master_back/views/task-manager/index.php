<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use app\components\widgets\MatchLeadsWidget;
use app\components\widgets\ReminderWidget;
use app\models\Reminder;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Manager';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    'header' => '<h4>' . Yii::t('app', 'Users') . '</h4>',
    'id' => 'users-modal-task',
    'size' => 'modal-lg',
]);
Pjax::begin(['id' => 'pjax-responsible-gridview', 'timeout' => false, 'enablePushState' => false]);
echo GridView::widget([
    'id' => 'users-gridview',
    'dataProvider' => $usersDataProvider,
    'filterModel' => $usersSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],

        'username' => [
            'attribute' => 'username',
            'value' => function($usersDataProvider) {
                return $usersDataProvider->username;
            },
            'filterInputOptions' => [
                'class' => 'form-control input-sm',
                'id' => null
            ],
        ],

        'first_name' => [
            'attribute' => 'first_name',
            'value' => function($usersDataProvider) {
                return $usersDataProvider->first_name;
            },
        ],
        'last_name' => [
            'attribute' => 'last_name',
            'value' => function($usersDataProvider) {
                return $usersDataProvider->last_name;
            },
        ],
    ],
]);
Pjax::end();
echo Html::a('Add Responsibles', '#', ['class' => 'add-responsibles btn btn-success']);
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Sales'),
    'id' => 'modal-sales-gridview',
    'size' => 'modal-lg',
]);
echo $this->render('_sale_gridview',
    [
        'salesDataProvider' => $salesDataProvider,
        'salesSearchModel' => $salesSearchModel,
    ]);
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Rentals'),
    'id' => 'modal-rentals-gridview',
    'size' => 'modal-lg',
]);

echo $this->render('_rentals_gridview',
    [
        'rentalsDataProvider' => $rentalsDataProvider,
        'rentalsSearchModel' => $rentalsSearchModel,
    ]);
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Leads'),
    'id' => 'modal-leads-gridview',
    'size' => 'modal-lg',
]);
echo $this->render('_leads_gridview',
    [
        'leadsDataProvider' => $leadsDataProvider,
        'leadsSearchModel' => $leadsSearchModel,
    ]);
Modal::end();

Modal::begin([
    'header' => Yii::t('app', 'Contacts'),
    'id' => 'modal-contacts-gridview',
    'size' => 'modal-lg',
]);
echo $this->render('_contacts_gridview',
    [
        'contactsDataProvider' => $contactsDataProvider,
        'contactsSearchModel' => $contactsSearchModel,
    ]);
Modal::end();
?>

<?php Pjax::begin(['id' => 'result']); ?>

<div class="task-manager-index">
<!--    Top Rentals Block     -->
    <div class="container-fluid top-rentals-content clearfix">
        <div class="head-rentals-property container-fluid">
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
                'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="property-list">
            <div class="tab-content ">
                <div class="tab-pane active" id="manage-users">
                    <div class="container-fluid top-contact-content users-top-content clearfix"><!--  Top Contact Block -->
                        <div class="head-contact-property container-fluid">
                        <?= $this->render(
                                '_topButton',
                                [
                                    'topModel'    => $firstRecord,
                                    'existRecord' => $existRecord,
                                ]
                            ) 
                        ?>
                        </div>
                        <div class="container-fluid content-contact-property">
                                <?php 
                                    $form = ActiveForm::begin([
                                        'options' => [
                                            'id'        => 'task-form',
                                            'enctype'   => 'multipart/form-data',
                                            'data-pjax' => true,
                                            'class'     => 'form-horizontal'
                                        ]
                                    ]); 
                                ?>
                                <div class="container-fluid contact-left-block col-md-6"><!-- Left Contact part-->
                                    <div class="contact-bottom-column-height">
                                        <div class="contact-small-block"><!--User Details-->
                                            <h3>Task Details</h3>
                                            <div class="property-list">
                                                <?= $this->render('_form', [
                                                        'model'                => $model,
                                                        'modelUserName'        => $modelUserName,
                                                        'sales'                => $sales,
                                                        'rentals'              => $rentals,
                                                        'salesSearchModel'     => $salesSearchModel,
                                                        'salesDataProvider'    => $salesDataProvider,
                                                        'rentalsSearchModel'   => $rentalsSearchModel,
                                                        'rentalsDataProvider'  => $rentalsDataProvider,
                                                        'usersSearchModel'     => $usersSearchModel,
                                                        'usersDataProvider'    => $usersDataProvider,
                                                        'leadsSearchModel'     => $leadsSearchModel,
                                                        'leadsDataProvider'    => $leadsDataProvider,
                                                        'contactsSearchModel'  => $contactsSearchModel,
                                                        'contactsDataProvider' => $contactsDataProvider,
                                                        'disabledAttribute'    => $disabled,
                                                        'form'                 => $form
                                                    ]) 
                                                ?>
                                            </div>                                           
                                        </div><!-- /User Details-->                           
                                    </div>
                                </div>
                            <?php $form = ActiveForm::end(); ?>
                            <div class="container-fluid contact-middle-block col-md-6">
                            <!-- Middle Contact part-->
                            <div class="content-left-block">
                                <!--Property Address & Detalis-->
                                <div class="property-list user-middle-block">
                                    <div class="bordered-property-block">
                                    <?= ReminderWidget::widget(['keyId' => $model->id, 'keyType' => Reminder::KEY_TYPE_TASKMANAGER]) ?>
                                    </div>
                                </div>
                            </div><!-- /Property Address & Detalis-->
                        </div>
                        </div>
                    </div><!-- /Top Contact Block -->
                    <div class="container-fluid  bottom-rentals-content clearfix"><!--    Bottom Rentals Block      -->
                        <div id="listings-tab">

                            <div class="tab-content ">
                                <div class="tab-pane active" id="current-listings">

                                    <!-- BIG listings Table-->
                                    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class=" container-fluid clearfix">
                                            <?= GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                'filterModel'  => $searchModel,
                                                'layout'       => "{items}\n{pager}",
                                                'tableOptions' => [
                                                    'class' => 'table table-bordered listings_row',
                                                    'id' => 'full-listing-table'
                                                ],
                                                'rowOptions'   => function ($model, $key, $index, $grid) {
                                                        $url = Yii::$app->getUrlManager()->createUrl([
                                                            'task-manager/view',
                                                            'id' => $model['id']
                                                        ]);
                                                        $url = $url.'?page=' .
                                                            (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page'));

                                                        return [
                                                            'data-url'    =>  $url,
                                                            'class'       => 'full-listing-table-row'
                                                        ];
                                                    },
                                                'columns' => [
                                                    /*['class' => 'yii\grid\SerialColumn'],*/
                                                    [
                                                        'class' => 'yii\grid\CheckboxColumn',
                                                        'contentOptions' => ['class' => 'check-box-column']
                                                    ],
                                                    [
                                                        'class'  => 'yii\grid\ActionColumn',
                                                        'buttons'=>[
                                                            'view'=>function ($url, $model) use ($firstRecord) {
                                                                    $url = Yii::$app->getUrlManager()->createUrl([
                                                                        'task-manager/view',
                                                                        'id'   => $model['id'],
                                                                    ]);
                                                                    return \yii\helpers\Html::a(
                                                                        ($firstRecord->id == $model['id']) ? '<i class="fa fa-eye active"></i>' : '<i class="fa fa-eye"></i>',
                                                                        $url.'?page=' .
                                                                        (empty(Yii::$app->request->get('page')) ? '1' : Yii::$app->request->get('page')),
                                                                        [
                                                                            'title'     => Yii::t('app', 'View'),
                                                                            'data-pjax' => '1',
                                                                            'pjax'      => '#result',
                                                                            'class'     => 'view-contact'
                                                                        ]
                                                                    );
                                                                }
                                                        ],
                                                        'template'=>'{view}',
                                                    ],
                                                    'title',
                                                    'description:html',
                                                    [
                                                        'attribute' => 'responsible',
                                                        'format'    => 'raw',
                                                        'value'     => function ($model, $index, $widget) {
                                                            $users     = \app\models\TaskResponsibleUser::find()->where(['task_id' => $model->id])->with(['user'])->all();
                                                            $usersList = '<ul style="list-style: none">';
                                                            foreach ($users as $user)
                                                                $usersList .= '<li>' . $user->user->username . '</li>';
                                                            $usersList .= '</ul>';
                                                            return $usersList;
                                                        }
                                                    ],
                                                    [
                                                        'attribute' => 'deadline',
                                                        'format'    => 'raw',
                                                        'value'     => function ($model, $index, $widget) {
                                                            return $model->deadline;
                                                        }
                                                    ],
                                                    'remind',
                                                    [
                                                        'attribute' => 'salesIds',
                                                        'format'    => 'raw',
                                                        'value'     => function ($model, $index, $widget) {
                                                            $salesLinks = \app\models\TaskSaleLink::find()->where(['task_id' => $model->id])->with(['sale'])->all();
                                                            $salesList  = '<ul style="list-style: none">';
                                                            foreach ($salesLinks as $salesLink)
                                                                $salesList .= '<li>' . Html::a($salesLink->sale->ref, ['sale/view', 'id' => $salesLink->sale->id]) . '</li>';
                                                            $salesList .= '</ul>';
                                                            return $salesList;
                                                        }
                                                    ],
                                                    [
                                                        'attribute' => 'rentalsIds',
                                                        'format'    => 'raw',
                                                        'value'     => function ($model, $index, $widget) {
                                                            $rentalsLinks = \app\models\TaskRentalLink::find()->where(['task_id' => $model->id])->with(['rental'])->all();
                                                            $rentalsList  = '<ul style="list-style: none">';
                                                            foreach ($rentalsLinks as $rentalsLink)
                                                                $rentalsList .= '<li>' . Html::a($rentalsLink->rental->ref, ['rentals/view', 'id' => $rentalsLink->rental->id]) . '</li>';
                                                            $rentalsList .= '</ul>';
                                                            return $rentalsList;
                                                        }],
                                                    [
                                                        'attribute' => 'leadsIds',
                                                        'format'    => 'raw',
                                                        'value'     => function ($model, $index, $widget) {
                                                            $leadsLinks = \app\models\TaskLeadLink::find()->where(['task_id' => $model->id])->with(['lead'])->all();
                                                            $leadsList = '<ul style="list-style: none">';
                                                            foreach ($leadsLinks as $leadsLink)
                                                                $leadsList .= '<li>' . Html::a($leadsLink->lead->reference, ['leads/' . $leadsLink->lead->reference]) . '</li>';
                                                            $leadsList .= '</ul>';
                                                            return $leadsList;
                                                        }],
                                                    [
                                                    'attribute' => 'contactsIds',
                                                    'format'    => 'raw',
                                                    'value'     => function ($model, $index, $widget) {
                                                        $contactsLinks = \app\models\TaskContactLink::find()->where(['task_id' => $model->id])->with(['contact'])->all();
                                                        $contactsList = '<ul style="list-style: none">';
                                                        foreach ($contactsLinks as $contactsLink)
                                                            $contactsList .= '<li>' . Html::a($contactsLink->contact->ref, ['contacts/view', 'id' => $contactsLink->contact->id]) . '</li>';
                                                        $contactsList .= '</ul>';
                                                        return $contactsList;
                                                    }],
                                                ],
                                            ]);
                                        ?>
                                    </div>
                                    <!-- /BIG listings Table-->
                                </div>
                            </div>
                        </div>
                    </div><!--    /Bottom Rentals Block      -->
                </div>
            </div>
        </div>              
    </div>
</div>
<?php Pjax::end(); ?>

<?php     
$this->registerJs(
   "
        $(document).on('pjax:success', function(e) {
            if (e.relatedTarget.className == 'view-contact') {
                $('html, body').animate({ scrollTop: 0 }, 1000);
            }
        })
    "
);

$getSaleItemUrl = Url::to(['/task-manager/get-sale-item']);
$getRentalsItemUrl = Url::to(['/task-manager/get-rental-item']);
$getLeadsItemUrl = Url::to(['/task-manager/get-lead-item']);
$getContactsItemUrl = Url::to(['/task-manager/get-contact-item']);
$getResponsiblesItemUrl = Url::to(['/task-manager/get-responsible-item']);
$script = <<<JS

$( "body" ).on( "click", "#task-form #choosed-leads-list .remove-leads-item", function() {
    $(this).closest('li').remove();
    syncLeads();  
    return false;
});   

$( "body" ).on( "click", "#task-form .open-leads-gridview", function() {
    $('#modal-leads-gridview').modal('show');
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
    return false;
}); 

function syncLeads() {
    var leadId, leadIdsJson;
    var leadIds = [];
    $('#choosed-leads-list li').each(function( index ) {
      leadId = $(this).data('id');
          if (leadId)
            leadIds.push(leadId);
    });  
    leadIdsJson = JSON.stringify(leadIds);
    $('#taskmanager-leadsids').val(leadIdsJson); 
}


$( "body" ).on( "click", "#task-form #choosed-contacts-list .remove-contacts-item", function() {
    $(this).closest('li').remove();
    syncContacts();  
    return false;
});   

$( "body" ).on( "click", "#task-form .open-contacts-gridview", function() {
    $('#modal-contacts-gridview').modal('show');
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
    return false;
}); 

function syncContacts() {
    var contactId, contactIdsJson;
    var contactIds = [];
    $('#choosed-contacts-list li').each(function( index ) {
      contactId = $(this).data('id');
          if (contactId)
            contactIds.push(contactId);
    });  
    contactIdsJson = JSON.stringify(contactIds);
    $('#taskmanager-contactsids').val(contactIdsJson); 
}



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
    
    $('#users-modal-task').modal('hide');
    return false;
});

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

$( "body" ).on( "click", "#task-form #choosed-responsibles-list .remove-responsibles-item", function() {
    $(this).closest('li').remove();
     syncResponsibiles();
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
    $('#taskmanager-salesids').val(saleIdsJson); 
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
    $('#taskmanager-rentalsids').val(rentalIdsJson); 
}

$( "body" ).on( "click", "#task-form #choosed-sales-list .remove-sales-item", function() {
    $(this).closest('li').remove();
    syncSales();
    return false;
});   

$( "body" ).on( "click", "#task-form .open-sales-gridview", function() {
    $('#modal-sales-gridview').modal('show');
    return false;
});

$( "body" ).on( "click", "#task-form .open-rentals-gridview", function() {
    $('#modal-rentals-gridview').modal('show');
    return false;
});

$('#show-add-sales-rentals-modal').on('click', function() {
    $('#sales-rentals-choosing-modal').modal('show');
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
    return false;
});

$( "body" ).on( "click", "#task-form #choosed-rentals-list .remove-rentals-item", function() {
    $(this).closest('li').remove();
    syncRentals();  
    return false;
});   

$('.open-rentals-gridview').on('click', function() {
    $('#modal-rentals-gridview').modal('show');
    return false;
});

$('#show-add-rentals-rentals-modal').on('click', function() {
    $('#sales-rentals-choosing-modal').modal('show');
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
    return false;
});

$("body").on("keyup.yiiGridView", "#users-gridview .filters input", function(e) {
    $("#users-gridview").yiiGridView("applyFilter");
});

JS;
$this->registerJs($script, yii\web\View::POS_READY);
