<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>

<?= $this->render('@app/views/modals/_locationMap', [
    'topModel' => $topModel,
    'form'     => $form
])?>

<?= $this->render('@app/views/modals/_searchLocation', [
    'locationsAll' => $locationsAll
])?>

<?php
Modal::begin([
    'header' => Yii::t('app', 'Price options based on Frequency'),
    'id'     => 'modal-price-frequency'
]);
?>
<?= Yii::t('app', 'These pricing options for frequency will be sent to applicable portals to indicate that the property is also a
short term rental. The options in the cheques field will apply only on to the per year price of the listing.')?>
<div class="row margin-top-15">
    <div class="col-md-12">
        <div class="col-md-4 f-w-bold"><?= Yii::t('app', 'Per Day')?></div>
        <div class="col-md-4"><?= Yii::t('app', 'Price (AED)')?></div>
        <div class="col-md-4">
            <?= $form->field($topModel, 'price_per_day')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'type' => 'number'])->label(false); ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-4 f-w-bold"><?= Yii::t('app', 'Per Week')?></div>
        <div class="col-md-4"><?= Yii::t('app', 'Price (AED)')?></div>
        <div class="col-md-4">
            <?= $form->field($topModel, 'price_per_week')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'type' => 'number'])->label(false); ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-4 f-w-bold"><?= Yii::t('app', 'Per Month')?></div>
        <div class="col-md-4"><?= Yii::t('app', 'Price (AED)')?></div>
        <div class="col-md-4">
            <?= $form->field($topModel, 'price_per_month')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control', 'type' => 'number'])->label(false); ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-4 f-w-bold"><?= Yii::t('app', 'Per Year(default)')?></div>
        <div class="col-md-4"><?= Yii::t('app', 'Price (AED)')?></div>
        <div class="col-md-4">
            <?= $form->field($topModel, 'price')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control price-for-year', 'type' => 'number'])->label(false); ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-8 f-w-bold"><?= Yii::t('app', 'Number of paid cheques')?></div>
        <div class="col-md-4">
            <?= $form->field($topModel, 'cheques')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
        </div>
    </div>
</div>
<?php
Modal::end([])
?>

<div class="content-left-block"><!--Property Address & Detalis-->
    <h3>Property Details</h3>
    <div class="property-list">
        <div class="form-group">
            <label for="inputAssigned" class="col-sm-6 control-label">Assigned To</label>
            <div class="col-sm-6">
                <?= Html::input('text', '', ($assignedToUser) ? $assignedToUser->username : Yii::t('app', ' Select'), [
                    'data-toggle'  => 'modal',
                    'data-target'  => '#users-gridview',
                    'class'        => 'form-control cursor-pointer',
                    'id'           => 'change-assigned-to',
                    'disabled'     => $disabledAttribute,
                    'autocomplete' => 'off'
                ])?>
                <?= $form->field($topModel, 'agent_id', [
                    'template' => '{input}',
                    'options'  => [
                        'tag' => false,
                    ],
                ])->hiddenInput(['id' => 'assignedTo'])->label(false);?>
                <div class="help-block"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputRef" class="col-sm-6 control-label">Ref</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'ref')->textInput(['disabled' => true, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCompletionStatus" class="col-sm-6 control-label">Completion Status</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'completion_status')->dropDownList(
                            [
                                '0'                  => Yii::t('app', 'Select'),
                                'Completed Property' => Yii::t('app', 'Completed Property'),
                                'Off-plan'           => Yii::t('app', 'Off-plan')
                            ], 
                            [
                                'disabled' => $disabledAttribute, 
                                'class'    => 'form-control'
                            ]
                    )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCategory" class="col-sm-6 control-label">Category</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'category_id')->dropDownList(
                        $category,
                        [
                            'disabled' => $disabledAttribute, 
                            'class'    => 'form-control'
                        ]

                    )->label(false);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBeds" class="col-sm-6 control-label">Beds</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'beds')->dropDownList(
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
            <label for="inputBaths" class="col-sm-6 control-label">Baths</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'baths')->dropDownList(
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
            <label for="inputEmirate" class="col-sm-6 control-label">
                Emirate
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
                <?= $form->field($topModel, 'region_id')->dropDownList($emirates, ['disabled' => $disabledAttribute, 'prompt' => '', 'id' => 'emirateDropDown'])->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputRERA" class="col-sm-6 control-label">RERA Permit No.</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'rera_permit')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLocation" class="col-sm-6 control-label">
                Location
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
                <?= $form->field($topModel, 'area_location_id')->dropDownList($locationsCurrent, ['disabled' => $disabledAttribute, 'prompt' => '', 'id' => 'locationDropDown'])->label(false)?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputTenure" class="col-sm-6 control-label">Tenure</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'tenure')->dropDownList(
                        [
                            '0'         => Yii::t('app', 'Select'),
                            'Freehold'  => Yii::t('app', 'Freehold'),
                            'Leasehold' => Yii::t('app', 'Leasehold'),
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
            <label for="inputSub-location" class="col-sm-6 control-label">Sub-location</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'sub_area_location_id')->dropDownList($subLocationsCurrent, ['disabled' => $disabledAttribute, 'prompt' => '', 'id' => 'subLocationDropDown'])->label(false)?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputUnit" class="col-sm-6 control-label">Unit No.</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'unit')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputType" class="col-sm-6 control-label">Type</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'unit_type')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputStreet" class="col-sm-6 control-label">Street No.</label>
            <div class="col-sm-6">             
                <?= $form->field($topModel, 'street_no')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputFloor" class="col-sm-6 control-label">Floor</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'floor_no')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBuilt-up" class="col-sm-6 control-label">Built-up area</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'size')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPlot" class="col-sm-6 control-label">Plot area</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'plot_size')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputView" class="col-sm-6 control-label">View</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'view_id')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputFurnished" class="col-sm-6 control-label">Furnished</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'furnished')->dropDownList(
                        [
                            '0'                => Yii::t('app', 'Select'),
                            'Furnished'        => Yii::t('app', 'Furnished'),
                            'Unfurnished'      => Yii::t('app', 'Unfurnished'),
                            'Partly Furnished' => Yii::t('app', 'Partly Furnished'),
                        ],
                        [
                            'disabled' => $disabledAttribute, 
                            'class'    => 'form-control'
                        ]
                    )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPriceAED" class="col-sm-6 control-label">Price (AED)</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'price')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control price-for-year', 'type' => 'number'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPrice" class="col-sm-6 control-label">Frequency</label>
            <div class="col-sm-6">
                <?= Html::a(
                    'Add/Edit Frequency Options',
                    '#',
                    [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-price-frequency'
                    ]
                )?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPrice" class="col-sm-6 control-label">Price /</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'unit_size_price')->textInput(['readonly' => true, 'class' => 'form-control'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputCommission" class="col-sm-6 control-label">Commission in %</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'CommissionPercent')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
                <?= $form->field($topModel, 'commission')->textInput(['class' => 'form-control', 'readonly' => true])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputDeposit" class="col-sm-6 control-label">Deposit</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'deposit')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputDeposit" class="col-sm-6 control-label">Status</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'status')->dropDownList(
                        [
                            '0'           => Yii::t('app', 'Select'),
                            'Published'   => Yii::t('app', 'Published'),
                            'Unpublished' => Yii::t('app', 'Unpublished'),
                            'Draft'       => Yii::t('app', 'Draft'),
                            'Pending'     => Yii::t('app', 'Pending'),
                
                        ],
                        [
                            'disabled' => $disabledAttribute, 
                            'class'    => 'form-control'
                        ]
                        
                    )->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="inputDeposit" class="col-sm-6 control-label">Property Status</label>
            <div class="col-sm-6">
                <?= $form->field($topModel, 'prop_status')->dropDownList(
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
                            'class'    => 'form-control'
                        ]
                        
                    )->label(false);
                ?>
            </div>
        </div>
    </div>
</div><!-- /Property Address & Detalis-->

<?php 
echo $this->render('@app/views/scripts/_locationMap', [
    'locations'    => $locations,
    'subLocations' => $subLocations
]);

$this->registerJs(
    "
            $('#rentals-price').keyup(function() {
                var price = $('#rentals-price').val();
                var percent = $('#rentals-commissionpercent').val();
                var res = price*percent/100;
                $('#rentals-commission').val(res);

                var price = $('#rentals-price').val();
                var percent = $('#rentals-depositpercent').val();
            });

            $('#rentals-commissionpercent').keyup(function() {
                var price = $('#rentals-price').val();
                var percent = $('#rentals-commissionpercent').val();
                var res = price*percent/100;
                $('#rentals-commission').val(res);
            });
    "
);


?>