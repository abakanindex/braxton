<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Update Fields') . '</h4>',
    'id'     => 'modal-bulk-update',
])
?>
<div class="row">
    <div class="col-md-6">
        <?= Yii::t('app', 'Selected records only?')?>
    </div>
    <div class="col-md-6">
        <input type="radio" class="height-auto" checked>
        <label class="color-red" id="countRecordToUpdate"></label>
        <label class="color-red">
            <?= Yii::t('app', 'record(-s) will be updated.')?>
        </label>
    </div>
</div>
<div class="row margin-top-15">
    <div class="col-md-6">
        <?= Yii::t('app', 'Choose field')?>
    </div>
    <div class="col-md-6">
        <select class="form-control" id="selectField">
            <option value="-1"></option>
            <option data-attribute="agent_id" data-target-id="b_u_agent_id" data-target-description="setValue"><?= Yii::t('app', 'Assigned To')?></option>
            <option data-attribute="landlord_id" data-target-id="b_u_landlord_id" data-target-description="setValue"><?= Yii::t('app', 'Owner')?></option>
            <option data-attribute="completion_status" data-target-id="b_u_completion_status" data-target-description="setValue"><?= Yii::t('app', 'Completion Status')?></option>
            <option data-attribute="category_id" data-target-id="b_u_category_id" data-target-description="setValue"><?= Yii::t('app', 'Category')?></option>
            <option data-attribute="beds" data-target-id="b_u_beds" data-target-description="setValue"><?= Yii::t('app', 'Beds')?></option>
            <option data-attribute="baths" data-target-id="b_u_baths" data-target-description="setValue"><?= Yii::t('app', 'Baths')?></option>
            <option data-attribute="rera_permit" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'RERA Permit No.')?></option>
            <option data-attribute="tenure" data-target-id="b_u_tenure" data-target-description="setValue"><?= Yii::t('app', 'Tenure')?></option>
            <option data-attribute="unit" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Unit No.')?></option>
            <option data-attribute="unit_type" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Type')?></option>
            <option data-attribute="street_no" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Street No.')?></option>
            <option data-attribute="floor_no" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Floor')?></option>
            <option data-attribute="size" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Built-up area')?></option>
            <option data-attribute="plot_size" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Plot area')?></option>
            <option data-attribute="view_id" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'View')?></option>
            <option data-attribute="furnished" data-target-id="b_u_furnished" data-target-description="setValue"><?= Yii::t('app', 'Furnished')?></option>
            <option data-attribute="status" data-target-id="b_u_status" data-target-description="setValue"><?= Yii::t('app', 'Status')?></option>
            <option data-attribute="prop_status" data-target-id="b_u_prop_status" data-target-description="setValue"><?= Yii::t('app', 'Property Status')?></option>
            <option data-attribute="region_id" data-target-id="b_u_region_id"><?= Yii::t('app', 'Emirate')?>, <?= Yii::t('app', 'Location')?>, <?= Yii::t('app', 'Sub-location')?></option>
            <option data-attribute="source_of_listing" data-target-id="b_u_source_of_listing" data-target-description="setValue"><?= Yii::t('app', 'Source of listing')?></option>
            <option data-attribute="featured" data-target-id="b_u_featured" data-target-description="setValue"><?= Yii::t('app', 'Featured')?></option>
            <option data-attribute="dewa_no" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'DEWA Number')?></option>
            <option data-attribute="strno" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'STR')?></option>
            <option data-attribute="available_date" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Next available')?></option>
            <option data-attribute="remind_me" data-target-id="b_u_remind_me" data-target-description="setValue"><?= Yii::t('app', 'Remind')?></option>
            <option data-attribute="key_location" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Key Location')?></option>
            <option data-attribute="tenanted" data-target-id="b_u_tenanted" data-target-description="setValue"><?= Yii::t('app', 'Property Tenanted?')?></option>
            <option data-attribute="rented_at" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Rented at')?></option>
            <option data-attribute="rented_until" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Rented until')?></option>
            <option data-attribute="maintenance" data-target-id="b_u_newValue" data-target-description="setValue"><?= Yii::t('app', 'Maintenance Fee')?></option>
            <option data-attribute="managed" data-target-id="b_u_managed" data-target-description="setValue"><?= Yii::t('app', 'Managed')?></option>
            <option data-attribute="exclusive" data-target-id="b_u_exclusive" data-target-description="setValue"><?= Yii::t('app', 'Exclusive')?></option>
            <option data-attribute="invite" data-target-id="b_u_invite" data-target-description="setValue"><?= Yii::t('app', 'Invite')?></option>
            <option data-attribute="poa" data-target-id="b_u_poa" data-target-description="setValue"><?= Yii::t('app', 'POA')?></option>
        </select>
    </div>
</div>

<div class="row margin-top-15">
    <div class="col-md-6 display-none  add-display-none" id="setValue">
        <?= Yii::t('app', 'Set Value')?>
    </div>
    <div class="col-md-6">
        <input type="text" class="form-control display-none add-display-none" id="b_u_newValue">
        <?= Html::dropDownList('', '', $source, [
            'class'  => 'form-control display-none add-display-none',
            'prompt' => '',
            'id'     => 'b_u_source_of_listing'
        ])
        ?>
        <?= Html::dropDownList('', '',
            [
                '0'   => Yii::t('app', 'Select'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_featured'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                '0'        => Yii::t('app', 'Never'),
                '1 day'    => Yii::t('app', '1 day'),
                '1 week'   => Yii::t('app', '1 week'),
                '2 weeks'  => Yii::t('app', '2 weeks'),
                '10 weeks' => Yii::t('app', '10 weeks'),
                '1 month'  => Yii::t('app', '1 month'),
                '2 month'  => Yii::t('app', '2 month'),
                '3 month'  => Yii::t('app', '3 month'),
                '4 month'  => Yii::t('app', '4 month'),
                '6 month'  => Yii::t('app', '6 month'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_remind_me'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                'No'  => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_tenanted'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                'No'  => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_managed'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                'No'  => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_exclusive'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                'No'  => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_invite'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                'No'  => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_poa'
            ])
        ?>

        <?= Html::dropDownList('', '',
            [
                '0'                  => Yii::t('app', 'Select'),
                'Completed Property' => Yii::t('app', 'Completed Property'),
                'Off-plan'           => Yii::t('app', 'Off-plan')
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_completion_status'
            ])
        ?>
        <?= Html::dropDownList('', '',
            $category,
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_category_id'
            ])
        ?>
        <?= Html::dropDownList('', '',
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
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_beds'
            ])
        ?>
        <?= Html::dropDownList('', '',
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
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_baths'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                '0'         => Yii::t('app', 'Select'),
                'Freehold'  => Yii::t('app', 'Freehold'),
                'Leasehold' => Yii::t('app', 'Leasehold'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_tenure'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                '0'                => Yii::t('app', 'Select'),
                'Furnished'        => Yii::t('app', 'Furnished'),
                'Unfurnished'      => Yii::t('app', 'Unfurnished'),
                'Partly Furnished' => Yii::t('app', 'Partly Furnished'),
            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_furnished'
            ])
        ?>
        <?= Html::dropDownList('', '',
            [
                '0'           => Yii::t('app', 'Select'),
                'Published'   => Yii::t('app', 'Published'),
                'Unpublished' => Yii::t('app', 'Unpublished'),
                'Draft'       => Yii::t('app', 'Draft'),
                'Pending'     => Yii::t('app', 'Pending'),

            ],
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_status'
            ])
        ?>
        <?= Html::dropDownList('', '',
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
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_prop_status'
            ])
        ?>
        <?= Html::dropDownList('', '',
            $agentUser,
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_agent_id'
            ])
        ?>
        <?= Html::dropDownList('', '',
            $owner,
            [
                'class'  => 'form-control display-none add-display-none',
                'prompt' => '',
                'id'     => 'b_u_landlord_id'
            ])
        ?>
    </div>
</div>

<div class="display-none add-display-none" id="b_u_region_id">
    <div class="row">
        <div class="col-md-6">
            <?= Yii::t('app', 'Emirate')?>
        </div>
        <div class="col-md-6">
            <?= Html::dropDownList('', '', $emirates, [
                'id'     => 'emiratesSelect',
                'class'  => 'form-control',
                'prompt' => ''
            ])?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Yii::t('app', 'Location')?>
        </div>
        <div class="col-md-6">
            <?= Html::dropDownList('', '', array(), [
                'id'       => 'locationsSelect',
                'class'    => 'form-control',
                'prompt'   => '',
                'disabled' => true,
            ])?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= Yii::t('app', 'Sub-location')?>
        </div>
        <div class="col-md-6">
            <?= Html::dropDownList('', '', array(), [
                'id'       => 'subLocationsSelect',
                'class'    => 'form-control',
                'prompt'   => '',
                'disabled' => true,
            ])?>
        </div>
    </div>
</div>

<div class="text-center margin-top-15">
    <?= Html::button(
        '<i class="fa fa-check-circle"></i>' . Yii::t('app', ' Update'),
        [
            'class'     => 'btn btn-success',
            'id'        => 'submitBulkUpdate'
        ]
    ) ?>
</div>

<?php Modal::end();?>