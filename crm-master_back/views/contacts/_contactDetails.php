<?php
use borales\extensions\phoneInput\PhoneInput;

$dataOptionsPhone = [
    'jsOptions' => [
        'initialCountry' => 'ae',
    ]
];
$isManageAction = (Yii::$app->controller->action->id === 'create' || Yii::$app->controller->action->id === 'update') ? true : false;;
?>
<div class="content-left-block"><!--Property Address & Detalis-->
    <h3>Contact Details</h3>
    <div class="property-list">
        <div class="form-group">
            <div class="col-sm-6">
                <label for="" class="control-label"><?=Yii::t('app', 'Personal Mobile')?></label>
                <span class="color-red">*</span>
            </div>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'personal_mobile')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'personal_mobile')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactMobile'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Personal Phone')?></label>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'personal_phone')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'personal_phone')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactPhone'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label for="" class="control-label"><?=Yii::t('app', 'Personal Email')?></label>
                <span class="color-red">*</span>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'personal_email')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactEmail'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label for="" class="control-label"><?=Yii::t('app', 'Work Mobile')?></label>
                <span class="color-red">*</span>
            </div>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'work_mobile')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'work_mobile')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactMobileWork'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Other Mobile')?></label>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'other_mobile')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'other_mobile')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactMobileOther'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Work Phone')?></label>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'work_phone')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'work_phone')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactPhoneWork'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Other Phone')?></label>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'other_phone')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'other_phone')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactPhoneOther'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label for="" class="control-label"><?=Yii::t('app', 'Work Email')?></label>
                <span class="color-red">*</span>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'work_email')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactEmailWork'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Other Email')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'other_email')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactEmailOther'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Work Fax')?></label>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'work_fax')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'work_fax', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactFaxWork'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Home Fax')?></label>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'home_fax')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'home_fax', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactFaxPersonal'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Other Fax')?></label>
            <div class="col-sm-6">
                <?php if($isManageAction):?>
                    <?= $form->field($model, 'other_fax')->widget(borales\extensions\phoneInput\PhoneInput::className(), $dataOptionsPhone)->label(false) ?>
                <?php else:?>
                    <?= $form->field($model, 'other_fax', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactFaxOther'])->label(false) ?>
                <?php endif;?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Home Address 1')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'home_address_1', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactAddress_1'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Home Address 2')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'home_address_2', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactAddress_2'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Company Address 1')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'company_address_1', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactAddressWork_1'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Company Address 2')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'company_address_2', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactAddressWork_2'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Facebook')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'facebook', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactFacebook'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Twitter')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'twitter', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactTwitter'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Linkedin')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'linkedin', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactLinkedIn'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Google')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'google', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactGooglePlus'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Instagram')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'instagram', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactInstagram'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Wechat')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'wechat', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactWeChat'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Skype')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'skype', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactSkype'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Website')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'website', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactWebsite'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?= $model->getAttributeLabel('postal_code')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'postal_code', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=$model->getAttributeLabel('po_box')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'po_box', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement])->label(false) ?>
            </div>
        </div>
    </div>
</div><!-- /Property Address & Detalis-->