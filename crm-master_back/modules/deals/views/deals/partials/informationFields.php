<?php

use yii\helpers\{Html, Url};
use yii\web\View;
use app\modules\deals\models\Deals;

/**
 * @var $usersDataProvider
 * @var $usersSearchModel
 * @var $topModel
 * @var $disabledAttribute
 * @var array $listingRefDataProvider
 * @var $leadRefDataProvider
 * @var $source
 * @var $form
 * @var int $typeRental
 * @var string $textBuyer
 * @var string $textSeller
 * @var string $textTenant
 * @var string $textLandlord
 * @var $unitModel
 * @var $leadModel
 * @var $assignedToSeller
 */
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
                        'class'    => 'form-control',
                        'id'    => 'typeDropDown',
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
                <?= $form->field($topModel, 'model_id', ['template' => '{input}'])
                    ->hiddenInput(['id' => 'listingRef'])
                    ->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group" id="inputLeadRef">
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
                <?= $form->field($topModel, 'lead_id', ['template' => '{input}'])
                    ->hiddenInput(['id' => 'leadRef'])
                    ->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBuyer" class="col-sm-6 control-label">
                <?= $topModel->type == $typeRental ? $textTenant : $textBuyer ?>
            </label>
            <div class="col-sm-6" id="inputBuyer">
                <?= $leadModel->first_name . ' ' . $leadModel->last_name ?>
            </div>
        </div>
        <br/>
        <div class="form-group">
            <label for="inputSeller" class="col-sm-6 control-label">
                <?= $topModel->type == $typeRental ? $textLandlord : $textSeller ?>
            </label>
            <div class="col-sm-6" id="inputSeller">
                <?= is_numeric($unitModel->landlord_id)
                    ? $assignedToSeller->first_name . ' ' . $assignedToSeller->last_name
                    : $unitModel->landlord_id ?>
            </div>
        </div>
        <br/>
        <div class="form-group">
            <label for="inputSource" class="col-sm-6 control-label"><?= Yii::t('app', 'Source') ?></label>
            <div class="col-sm-6">
                <?= $form->field($leadModel, 'source')->dropDownList(
                    $source,
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control',
                        'id'       => 'inputSource',
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
                        'prompt' => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control',
                    ])
                    ->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPropStatus" class="col-sm-6 control-label"><?= Yii::t('app', 'Property Status') ?></label>
            <div class="col-sm-6">
                <?= $form->field($unitModel, 'prop_status')->dropDownList(
                    [
                        '0'         => Yii::t('app', 'Select'),
                        'Available' => Yii::t('app', 'Available'),
                        'Off-Plan'  => Yii::t('app', 'Off-Plan'),
                        'Pending'   => Yii::t('app', 'Pending'),
                        'Reserved'  => Yii::t('app', 'Reserved'),
                        'Sold'      => Yii::t('app', 'Sold'),
                        'Upcoming'  => Yii::t('app', 'Upcoming'),
                    ],
                    [
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control',
                        'id'       => 'inputPropStatus',
                    ])
                    ->label(false); ?>
            </div>
        </div>
    </div>
</div>