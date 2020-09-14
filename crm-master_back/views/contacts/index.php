<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel app\controllers\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$nationModel;
$religionModel;
$contactSourceModel;
$titleModel;
$model;

echo $this->render('@app/views/modals/_createFirst', [
    'message' => Yii::t('app', 'Create listing first')
]);
$this->registerJsFile('@web/js/show-modal-create-first.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="contacts-index">
<?= $this->render('@app/views/modals/_usersList', [
    'usersDataProvider' => $usersDataProvider,
    'usersSearchModel'  => $usersSearchModel,
    'gridVersion'       => '@app/views/modals/partsUsersList/_gridVersionOne'
])?>
<?php Pjax::begin(['id' => 'result']); ?>
<div class="container-fluid top-contact-content clearfix"><!--  Top Contact Block -->
    <div id="result">

        <div class="head-contact-property container-fluid">
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <h2><?=Html::encode($this->title)?></h2>
            <ul class="list-inline container-fluid">
                <?php if ($btnAdd) { ?>
                    <?php if(Yii::$app->user->can('contactsCreate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
                        <li class="">
                            <?= Html::a(
                                '<i class="fa fa-plus-circle"></i>' . Yii::t('app', 'New Contact'),
                                [
                                    'create'
                                ],
                                [
                                    'class' => 'btn green-button',
                                    'id'    => 'add-new-element'
                                ]
                            ) ?>
                        </li>
                    <?php endif; ?>
                <?php } ?>

                <?php if ($btnEdit) { ?>
                    <?php if(Yii::$app->user->can('contactsUpdate') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
                        <li class="">
                            <?= Html::a(
                                '<i class="fa fa-pencil-square-o"></i>' . Yii::t('app', 'Edit contact'),
                                ['update', 'id' => $model->id],
                                [
                                    'class' => 'btn red-button',
                                    'id'    => 'edit-element'
                                ]
                            ) ?>
                        </li>
                    <?php endif; ?>
                <?php } ?>

                <?php if ($btnSave) { ?>
                    <li class="">
                        <?= Html::button(
                            '<i class="fa fa-check-circle"></i>' . Yii::t('app', 'Save'),
                            [
                                'class' => 'btn green-button',
                                'id'    => 'save-edit-element',
                                'data-pjax' => '0'
                            ]
                        ) ?>
                    </li>
                <?php } ?>

                <?php if ($btnCancel) { ?>
                    <li class="">
                        <?= Html::a(
                            '<i class="fa fa-times-circle"></i>' . Yii::t('app', 'Cancel'),
                            $urlCancel,
                            [
                                'class' => 'btn gray-button',
                                'id'    => 'cancel-edit-element'
                            ]
                        ) ?>
                    </li>
                <?php } ?>

                <?php if ($btnDelete) { ?>
                    <?php if(Yii::$app->user->can('contactsDelete') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Owner')): ?>
                        <li>
                            <?= Html::a(
                                '<i class="glyphicon glyphicon-trash"></i>'  . Yii::t('app', 'Delete'),
                                ['delete', 'id' => $model->id],
                                [
                                    'id'    => 'delete-element',
                                    'class' => 'btn gray-button',
                                    'data'  => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                        'method'  => 'post',
                                    ],
                                    'data-pjax' => true
                                ]
                            )
                            ?>
                        </li>
                    <?php endif; ?>
                <?php } ?>
            </ul>
        </div>

        <div class="container-fluid content-contact-property">
            <?php
            $form = ActiveForm::begin([
                'action'  => $urlForm,
                'options' => [
                    'enctype'   => 'multipart/form-data',
                    'class'     => 'form-horizontal',
                    'data-pjax' => true,
                    'id'        => 'contactForm'
                ]
            ]);
            ?>
            <div class="container-fluid contact-left-block col-md-4"><!-- Left Contact part-->
                <?= $this->render(
                    '_contactInformation',
                    [
                        'model'             => $model,
                        'form'              => $form,
                        'agents'            => $agents,
                        'titles'            => $titles,
                        'nationalities'     => $nationalities,
                        'religions'         => $religions,
                        'sources'           => $sources,
                        'contactType'       => $contactType,
                        'genderList'        => $genderList,
                        'usersSearchModel'  => $usersSearchModel,
                        'usersDataProvider' => $usersDataProvider,
                        'assignedToUser'    => $assignedToUser,
                        'disabledFormElement' => $disabledFormElement,
                        'languages'           => $languages
                    ]
                )?>
            </div><!-- /Left Contact part-->

            <div class="container-fluid contact-middle-block col-md-4"><!-- Middle Contact part-->
                <?= $this->render(
                    '_contactDetails',
                    [
                        'model' => $model,
                        'form'  => $form,
                        'disabledFormElement' => $disabledFormElement
                    ]
                )?>
            </div><!-- /Middle Contact part-->
            <?php ActiveForm::end(); ?>

        <div
            <?php if(Yii::$app->controller->action->id === 'create' || !$model->id):?>
                id="listing-widget-actions"
                class="container-fluid col-md-4 notes-block opacity-half"
            <?php else:?>
                class="container-fluid col-md-4 notes-block"
            <?php endif?>
            ><!-- Right part-->
            <?= $this->render(
                '_notes',
                [
                    'model'           => $model,
                    'form'            => $form,
                    'noteModel'       => $noteModel,
                    'documentModel'   => $documentModel,
                    'viewingModel'    => $viewingModel,
                    'historyProperty' => $historyProperty,
                    'rentalsForContactDataProvider' => $rentalsForContactDataProvider,
                    'salesForContactDataProvider'   => $salesForContactDataProvider
                ]
            )?>
        </div><!-- /Right part-->

        </div>


    </div>

</div><!-- /Top Contact Block -->

<div class="container-fluid  bottom-rentals-content clearfix">
    <?= $this->render(
        '_grid',
        [
            'contactsArchiveSearch' => $contactsArchiveSearch,
            'contactsArchiveDataProvider' => $contactsArchiveDataProvider,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'titleModel' => $titleModel,
            'nationModel' => $nationModel,
            'religionModel' => $religionModel,
            'contactSourceModel' => $contactSourceModel,
            'agents' => $agents,
            'titles' => $titles,
            'nationalities' => $nationalities,
            'religions' => $religions,
            'sources' => $sources,
            'contactType' => $contactType,
            'genderList' => $genderList,
            'filteredColumns'  => $filteredColumns,
            'userColumns'      => $userColumns,
            'columnsGrid'      => $columnsGrid,
            'model'            => $model
        ]
    )?>
</div>
<?php Pjax::end(); ?>

</div>

<?php
$urlGridPanelArchive = Url::to(['contact/grid-panel-archive']);
$urlGridPanelCurrent = Url::to(['contact/grid-panel-current']);
$urlUnArchive        = Url::to(['contact/unarchive']);
$urlCreate = Url::to(['contacts/create']);

$script = <<<JS
/******* Edit Element in Listings ******/
var allElements = [
    'contactMobile',
    'contactPhone',
    'contactEmail',
    'contactAddress_1',
    'contactAddress_2',
    'contactFacebook',
    'contactTwitter',
    'contactLinkedIn',
    'contactGooglePlus',
    'contactInstagram',
    'contactWeChat',
    'contactSkype',
    'contactTitle',
    'contactFirstName',
    'contactLastName',
    'contactGender',
    'contactDateOfBirth',
    'contactNationality',
    'contactReligion',
    'contactLanguage_1',
    'contactLanguage_2',
    'contactHobbies',
    'contactCreatedBy',
    'contactSource',
    'contactType',
    'contactCompanyName',
    'contactDesignation',
    'assignedTo',
    'contactMobileWork',
    'contactMobileOther',
    'contactPhoneWork',
    'contactPhoneOther',
    'contactEmailWork',
    'contactEmailOther',
    'contactAddressWork_1',
    'contactAddressWork_2',
    'contactFaxWork',
    'contactFaxPersonal',
    'contactFaxOther',
    'contactWebsite'
];

$(document).ready(function() {

    $(document).on('pjax:success', function(e) {
        finishLoadingProcess();
        if (e.relatedTarget && e.relatedTarget.className == "view-contact") {
            $("html, body").animate({ scrollTop: 0 }, 1000);
        }
    })

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

    $("body").on("click", "#open-archived-listings", function() {
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

    $('body').on('click', '#save-edit-element', function() {
        $.pjax({
                type       : 'POST',
                url        : $('#contactForm').attr('action'),
                container  : '#result',
                data       : $('#contactForm').serialize(),
                push       : false,
                scrollTo   : false
                //replace    : false,
                //timeout    : 10000
            })
   })

   $(document).on('pjax:send', function() {
        startLoadingProcess();
    });

    $(document).on('pjax:complete', function(e) {
        finishLoadingProcess();
    });
})
JS;

$this->registerJs($script, View::POS_READY);

//$this->registerJsFile('@web/js/contacts.js', ['depends' => 'yii\web\JqueryAsset']);
?>