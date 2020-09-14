<?php

use yii\helpers\Html;
use app\modules\deals\models\Deals;
use yii\jui\DatePicker;

/**
 * @var $topModel
 * @var $form
 * @var $disabledAttribute
 * @var array $agents
 * @var $unitModel
 * @var $category
 * @var $locationsAll
 * @var $emirates
 * @var $locationsCurrent
 * @var $subLocations
 * @var $locations
 */

echo $this->render('@app/views/modals/_locationMap', [
    'topModel' => $unitModel,
    'form'     => $form
]);
echo $this->render('@app/views/modals/_searchLocation', [
    'locationsAll' => $locationsAll
]);
?>
<div class="col-md-6 rentals-big-block"><!-- transactionCommissionFields -->
    <h3><?= Yii::t('app', 'Transaction Details') ?></h3>
    <div class="property-list">
        <div class="form-group">
            <label for="inputDealPrice" class="col-sm-6 control-label"><?= Yii::t('app', 'Deal Price (AED)') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'deal_price')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputDeposit" class="col-sm-6 control-label"><?= Yii::t('app', 'Deposit (AED)') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'deposit')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
    </div>

    <h3><?= Yii::t('app', 'Commission Details') ?></h3>
    <div class="property-list">
        <div class="form-group">
            <label for="inputGross" class="col-sm-6 control-label"><?= Yii::t('app', 'Gross Commission (AED)') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'gross_commission')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <br/>
        <div class="form-group">
            <label for="inputVat" class="col-sm-6 form-check-label"><?= Yii::t('app', 'Include Commission VAT') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'is_vat')->checkbox(['disabled' => $disabledAttribute, 'class' => 'form-check-input'])->label(''); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputIsExternalReferral" class="col-sm-6 form-check-label"><?= Yii::t('app', 'Split with External Referral?') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'is_external_referral')->checkbox(['disabled' => $disabledAttribute, 'class' => 'form-check-input'])->label(''); ?>
            </div>
        </div>
        <hr/>
        <div class="form-group">
            <label for="inputAgent1" class="col-sm-6 control-label"><?= Yii::t('app', 'Agent 1') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'agent_1')->dropDownList(
                    $agents,
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control'
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCommissionAgent1" class="col-sm-6 control-label"><?= Yii::t('app', 'Commission (AED)') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'agent_1_commission')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <br/>
        <div class="form-group">
            <label for="inputAgent2" class="col-sm-6 control-label"><?= Yii::t('app', 'Agent 2') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'agent_2')->dropDownList(
                    $agents,
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control'
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCommissionAgent2" class="col-sm-6 control-label"><?= Yii::t('app', 'Commission (AED)') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'agent_2_commission')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <br/>
        <div class="form-group">
            <label for="inputAgent3" class="col-sm-6 control-label"><?= Yii::t('app', 'Agent 3') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'agent_3')->dropDownList(
                    $agents,
                    [
                        'prompt'   => Yii::t('app', 'Select'),
                        'disabled' => $disabledAttribute,
                        'class'    => 'form-control'
                    ]
                )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCommissionAgent3" class="col-sm-6 control-label"><?= Yii::t('app', 'Commission (AED)') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'agent_3_commission')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
    </div>

    <h3><?= Yii::t('app', 'Deal Closure') ?></h3>
    <div class="property-list">
        <div class="form-group">
            <label for="inputEstimatedDate" class="col-sm-6 control-label"><?= Yii::t('app', 'Estimated Deal Date') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'estimated_date')->widget(
                    DatePicker::class,
                    [
                        'model'      => $model,
                        'attribute'  => 'Estimated Date',
                        'language'   => 'ru',
                        'dateFormat' => 'dd-MM-yyyy',
                        'clientOptions' => [
                            'defaultDate' => 'now',
                        ],
                        'options' => [
                            'class'    =>'form-control',
                            'disabled' => $disabledAttribute,

                        ],
                    ]
                )->label(false);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputActualDate" class="col-sm-6 control-label"><?= Yii::t('app', 'Actual Deal Date') ?></label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'actual_date')->widget(
                    DatePicker::class,
                    [
                        'model'      => $model,
                        'attribute'  => 'Actual Date',
                        'language'   => 'ru',
                        'dateFormat' => 'dd-MM-yyyy',
                        'clientOptions' => [
                            'defaultDate' => 'now',
                        ],
                        'options' => [
                            'class'    =>'form-control',
                            'disabled' => $disabledAttribute,

                        ],
                    ]
                )->label(false);
                ?>
            </div>
        </div>
    </div>

</div><!--/transactionCommissionFields-->

<div class="col-md-6 rentals-big-block"><!--Unit Details-->
    <h3><?= Yii::t('app', 'Unit Details') ?></h3>
<!--    <div id="media-tab">-->
        <div class="property-list" style="overflow-y: inherit">
                    <?php if (
                        Yii::$app->controller->action->id === 'create' or
                        Yii::$app->controller->action->id === 'update'
                    ): ?>

                    <?php else: ?>

                    <?php endif; ?>
            <div class="form-group">
                <label for="inputUnit" class="col-sm-6 control-label"><?= Yii::t('app', 'Unit No.') ?></label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'unit')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputCategory" class="col-sm-6 control-label"><?= Yii::t('app', 'Category') ?></label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'category_id')->dropDownList(
                        $category,
                        [
                            'prompt'   => Yii::t('app', 'Select'),
                            'disabled' => $disabledAttribute,
                            'class'    => 'form-control'
                        ]
                    )->label(false);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputBeds" class="col-sm-6 control-label"><?= Yii::t('app', 'Beds') ?></label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'beds')->dropDownList(
                        [
                            '0'  => Yii::t('app', 'Select'),
                            '1'  => Yii::t('app', '1'),
                            '2'  => Yii::t('app', '2'),
                            '3'  => Yii::t('app', '3'),
                            '4'  => Yii::t('app', '4'),
                            '5'  => Yii::t('app', '5'),
                            '6'  => Yii::t('app', '6'),
                            '7'  => Yii::t('app', '7'),
                            '8'  => Yii::t('app', '8'),
                            '9'  => Yii::t('app', '9'),
                            '10' => Yii::t('app', '10'),
                            '11' => Yii::t('app', '11'),
                            '12' => Yii::t('app', '12'),
                            '13' => Yii::t('app', '13'),
                            '14' => Yii::t('app', '14'),
                            '15' => Yii::t('app', '15'),
                            '16' => Yii::t('app', '16'),
                        ],
                        [
                            'disabled' => $disabledAttribute,
                            'class'    => 'form-control'
                        ]
                    )->label(false);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputType" class="col-sm-6 control-label"><?= Yii::t('app', 'Unit Type') ?></label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'unit_type')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmirate" class="col-sm-6 control-label">
                    <?= Yii::t('app', 'Emirate') ?>
                    <?=Html::a(
                        '<i class="fa fa-search"></i>',
                        '#',
                        [
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-search-location',
                            'class'       => 'pull-right'
                        ]
                    )?>
                </label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'region_id')->dropDownList($emirates, ['disabled' => $disabledAttribute, 'prompt' => '', 'id' => 'emirateDropDown'])->label(false);?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputLocation" class="col-sm-6 control-label">
                    <?= Yii::t('app', 'Location') ?>
                    <?=Html::a(
                        '<i class="fa fa-map-marker"></i>',
                        '#',
                        [
                            'data-toggle' => 'modal',
                            'data-target' => '#modal-location-map',
                            'class'       => 'pull-right'
                        ]
                    )?>
                </label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'area_location_id')->dropDownList($locationsCurrent, ['disabled' => $disabledAttribute, 'prompt' => '', 'id' => 'locationDropDown'])->label(false)?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputSubLocation" class="col-sm-6 control-label"><?= Yii::t('app', 'Sub-location') ?></label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'sub_area_location_id')->dropDownList($subLocationsCurrent, ['disabled' => $disabledAttribute, 'prompt' => '', 'id' => 'subLocationDropDown'])->label(false)?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputStreetNo" class="col-sm-6 control-label"><?= Yii::t('app', 'Street No') ?></label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'street_no')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="inputFloor" class="col-sm-6 control-label"><?= Yii::t('app', 'Floor') ?></label>
                <div class="col-sm-6">
                    <?= $form->field($unitModel, 'floor_no')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
                </div>
            </div>

        </div>
</div><!--/Unit Details-->
<?php
echo $this->render('@app/views/scripts/_locationMap', [
    'locations'    => $locations,
    'subLocations' => $subLocations
]);
