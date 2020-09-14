<?php

use yii\helpers\Html;
use app\modules\deals\models\Deals;

/**
 * @var $usersDataProvider
 * @var $usersSearchModel
 * @var $topModel
 * @var $disabledAttribute
 * @var $listingRefDataProvider
 * @var $leadRefDataProvider
 * @var $source
 * @var $form
 */
?>

<?php
echo  $this->render('@app/views/modals/_usersList', [
    'usersDataProvider' => $usersDataProvider,
    'usersSearchModel'  => $usersSearchModel,
    'gridVersion'       => '@app/views/modals/partsUsersList/_gridVersionOne'
]);
echo  $this->render('@app/views/modals/_listingsList', [
    'listingRefDataProvider' => $listingRefDataProvider,
]);
echo  $this->render('@app/views/modals/_leadsList', [
    'leadRefDataProvider' => $leadRefDataProvider,
]);
echo  $this->render('@app/views/modals/_buyerList', [
    'usersDataProvider' => $usersDataProvider,
]);
echo  $this->render('@app/views/modals/_sellerList', [
    'usersDataProvider' => $usersDataProvider,
]);
?>

<div class="content-left-block"><!--Property Address & Detalis-->
    <h3><?= Yii::t('app', 'Deal Information') ?></h3>
    <div class="property-list">
        <div class="form-group">
            <label for="inputRef" class="col-sm-6 control-label"><?= Yii::t('app', 'Reference') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'ref')->textInput(['disabled' => true, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputType" class="col-sm-6 control-label">Type</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'type')->dropDownList(
                    Deals::getTypes(),
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control'
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCreatedBy" class="col-sm-6 control-label"><?= Yii::t('app', 'Created By') ?></label>
            <div class="col-sm-6">
                <?= Html::input('text', '', $assignedToUser->username ?? $topModel->created_by, [
//                    'data-toggle'  => 'modal',
//                    'data-target'  => '#users-gridview',
                    'class'        => 'form-control cursor-pointer',
//                    'id'           => 'change-assigned-to',
                    'disabled'     => true,
                    'autocomplete' => 'off'
                ])?>
                <?= $form->field($topModel, 'created_by', [
                    'template' => '{input}',
                    'options'  => [
                        'tag' => false,
                    ],
                ])->hiddenInput(['id' => 'createdBy'])->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputListingRef" class="col-sm-6 control-label"><?= Yii::t('app', 'Listing Ref') ?></label>
            <div class="col-sm-6">
                <?= Html::input('text', '', $unitModel->ref ?? $topModel->model_id, [
                    'data-toggle'  => 'modal',
                    'data-target'  => '#listings-gridview',
                    'class'        => 'form-control cursor-pointer',
                    'id'           => 'change-listing-ref',
                    'disabled'     => $disabledAttribute,
                    'autocomplete' => 'off'
                ])?>
                <?= $form->field($topModel, 'model_id', [
                    'template' => '{input}',
                    'options'  => [
                        'tag' => false,
                    ],
                ])->hiddenInput(['id' => 'listingRef'])->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLeadRef" class="col-sm-6 control-label"><?= Yii::t('app', 'Lead Ref') ?></label>
            <div class="col-sm-6">
                <?= Html::input('text', '', $assignedToLead->reference ?? $topModel->lead_id, [
                    'data-toggle'  => 'modal',
                    'data-target'  => '#leads-gridview',
                    'class'        => 'form-control cursor-pointer',
                    'id'           => 'change-lead-ref',
                    'disabled'     => $disabledAttribute,
                    'autocomplete' => 'off'
                ])?>
                <?= $form->field($topModel, 'lead_id', [
                    'template' => '{input}',
                    'options'  => [
                        'tag' => false,
                    ],
                ])->hiddenInput(['id' => 'leadRef'])->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBuyer" class="col-sm-6 control-label"><?= Yii::t('app', 'Buyer') ?></label>
            <div class="col-sm-6">
                <?= Html::input('text', '', $assignedToBuyer->username ?? $topModel->buyer_id, [
                    'data-toggle'  => 'modal',
                    'data-target'  => '#buyers-gridview',
                    'class'        => 'form-control cursor-pointer',
                    'id'           => 'change-buyer',
                    'disabled'     => $disabledAttribute,
                    'autocomplete' => 'off'
                ])?>
                <?= $form->field($topModel, 'buyer_id', [
                    'template' => '{input}',
                    'options'  => [
                        'tag' => false,
                    ],
                ])->hiddenInput(['id' => 'buyerDeal'])->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSeller" class="col-sm-6 control-label"><?= Yii::t('app', 'Seller') ?></label>
            <div class="col-sm-6">
                <?= Html::input('text', '', $assignedToSeller->username ?? $topModel->seller_id, [
                    'data-toggle'  => 'modal',
                    'data-target'  => '#sellers-gridview',
                    'class'        => 'form-control cursor-pointer',
                    'id'           => 'change-seller',
                    'disabled'     => $disabledAttribute,
                    'autocomplete' => 'off'
                ])?>
                <?= $form->field($topModel, 'seller_id', [
                    'template' => '{input}',
                    'options'  => [
                        'tag' => false,
                    ],
                ])->hiddenInput(['id' => 'sellerDeal'])->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSource" class="col-sm-6 control-label"><?= Yii::t('app', 'Source') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'source')->dropDownList(
                    $source,
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control'
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputStatus" class="col-sm-6 control-label"><?= Yii::t('app', 'Status') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'status')->dropDownList(
                    Deals::getStatuses(),
                    [
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control'
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubStatus" class="col-sm-6 control-label"><?= Yii::t('app', 'Sub Status') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'sub_status')->dropDownList(
                    Deals::getSubStatuses(),
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control'
                    ]
                )->label(false); ?>
            </div>
        </div>


    </div>
</div>
<?php
$script = <<<JS
// $('.open-users-gridview').on('click', function() {
// $('#users-modal').modal('show');
// return false;
// });

JS;
$this->registerJs($script, yii\web\View::POS_READY);
