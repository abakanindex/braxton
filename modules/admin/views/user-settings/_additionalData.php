<div class="content-left-block"><!--Property Address & Detalis-->
    <div class="property-list user-middle-block">
        <div class="bordered-property-block">
            <h4>Import Email Leads</h4>
            <div class="form-group">
                <label for="inputUserImportEnabled" class="col-sm-6 control-label"><?= $model->getAttributeLabel('imap_enabled')?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'imap_enabled', [
                        'template' => '{input}', // Leave only input (remove label, error and hint)
                        'options' => [
                            'tag' => false, // Don't wrap with "form-group" div
                        ],
                    ])->dropDownList([
                            0 => 'No',
                            1 => 'Yes'
                        ], ['disabled' => $disabled, 'id' => 'inputUserImportEnabled'])->label(false);?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserImportImap"
                       class="col-sm-6 control-label"><?= $model->getAttributeLabel('imap')?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'imap', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false
                        ],
                    ])->textInput(['id' => 'inputUserImportImap', 'disabled' =>  $disabled,])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserImportEmail" class="col-sm-6 control-label"><?= $model->getAttributeLabel('imap_email')?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'imap_email', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false
                        ],
                    ])->textInput(['id' => 'inputUserImportEmail', 'disabled' =>  $disabled,])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserImportPassword" class="col-sm-6 control-label"><?= $model->getAttributeLabel('imap_password')?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'imap_password', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false
                        ],
                    ])->passwordInput(['id' => 'inputUserImportPassword', 'disabled' =>  $disabled,])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserImportPort"
                       class="col-sm-6 control-label"><?= $model->getAttributeLabel('imap_port')?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'imap_port', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false
                        ],
                    ])->textInput(['id' => 'inputUserImportPort', 'disabled' =>  $disabled,])->label(false) ?>
                </div>
            </div>
        </div>
<!--        <div class="bordered-property-block">-->
<!--            <h4>Email Notification Settings</h4>-->
<!--            <div class="form-group">-->
<!--                <label for="inputUserAvailabilityEmails"-->
<!--                       class="col-sm-6 control-label">Property Availability-->
<!--                    Emails</label>-->
<!--                <div class="col-sm-6">-->
<!--                    <select class="form-control" id="inputUserAvailabilityEmails" disabled="--><?//= $disabled ?><!--">-->
<!--                        <option>No</option>-->
<!--                        <option>Yes</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="bordered-property-block">-->
<!--            <h4>Two-step verification</h4>-->
<!--            <div class="form-group">-->
<!--                <label for="inputUserGoogleAuthenticator"-->
<!--                       class="col-sm-6 control-label">Google Authenticator</label>-->
<!--                <div class="col-sm-6">-->
<!--                    <select class="form-control" id="inputUserGoogleAuthenticator" disabled="--><?//= $disabled ?><!--">-->
<!--                        <option>Disabled</option>-->
<!--                        <option>Enabled</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="bordered-property-block">-->
<!--            <h4>SMS Verification</h4>-->
<!--            <div class="form-group">-->
<!--                <label for="inputUserSMSVerificationNumber"-->
<!--                       class="col-sm-6 control-label">SMS Verification-->
<!--                    Number</label>-->
<!--                <div class="col-sm-6">-->
<!--                    <input type="text" class="form-control"-->
<!--                           id="inputUserSMSVerificationNumber" placeholder="" disabled="--><?//= $disabled ?><!--" >-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="bordered-property-block">
            <h4>Specialization</h4>
            <div class="form-group">
                <?php
                foreach($model->userCategories as $uC) {
                    $dataUserCat[] = $uC->category_id;
                }
                $model->userCategoriesData = $dataUserCat;
                ?>
                <?= $form->field($model, 'userCategoriesData')->checkboxList($propertyCategory, ['separator'=>'<br/>', 'itemOptions' => ['disabled' => $disabled, 'class' => 'height-auto']])->label(false)?>
            </div>
<!--            <div class="form-group">-->
<!--                <label for="inputUserLanguagesSpoken"-->
<!--                       class="col-sm-6 control-label">Locations</label>-->
<!--                <div class="col-sm-6">-->
<!--                    <select class="form-control"-->
<!--                            id="inputUserSpecializationLocations" multiple size="3" disabled="--><?//= $disabled ?><!--">-->
<!--                        <option>Locations 1</option>-->
<!--                        <option>Locations 2</option>-->
<!--                        <option>Locations 3</option>-->
<!--                        <option>Locations 4</option>-->
<!--                        <option>Locations 5</option>-->
<!--                        <option>Locations 6</option>-->
<!--                        <option>Locations 7</option>-->
<!--                        <option>Locations 8</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</div><!-- /Property Address & Detalis-->