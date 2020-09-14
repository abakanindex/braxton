<div class="contact-top-column-height">

    <div class="contact-big-block"><!-- Owner -->
        <!--<h3>Contact</h3>-->
        <div class="owner-head">
            <!--<img alt="user image" class="owner-image img-circle " src="img/user3-128x128.jpg">-->
            <div class="owner-name">
                <h3><?= $model->last_name.' '.$model->first_name; ?></h3>
                <!--<p>Contact</p>-->
            </div>
        </div>
        <div class="owner-property property-list">
            <div class="form-group">
                <label for="inputUserName" class="col-sm-6 control-label"><?= $model->getAttributeLabel('username'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'username')
                        ->textInput(['id' => 'inputUserName', 'disabled' => $disabled])
                        ->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <?php if (Yii::$app->controller->action->id === 'create' or Yii::$app->controller->action->id === 'update') : ?>
                    <div style="padding: 10px;">
                        If you leave this field blank, your password will remain unchanged, otherwise your password will be updated.
                    </div>
                <?php endif; ?>
                <label for="inputUserPassword" class="col-sm-6 control-label"><?= $model->getAttributeLabel('password_hash'); ?></label>
                <div class="col-sm-6">
                    <?php if (Yii::$app->controller->action->id === 'create' or Yii::$app->controller->action->id === 'update') : ?>
                    <?= $form->field($model, 'password_hash', [
                        'template' => '{input}<span class=\'glyphicon glyphicon-eye-open form-control-feedback\'></span>',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->passwordInput(['id' => 'inputUserPassword', 'value' => '', 'disabled' => $disabled])
                    ->label(false);
                    ?>
                    <?php else : ?>
                        <?= $form->field($model, 'password_hash')
                            ->passwordInput(['disabled' => $disabled])
                            ->label(false);
                        ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (Yii::$app->user->can('Owner') or Yii::$app->user->can('Admin')): ?>
                <div class="form-group">
                    <label for="inputUserRole" class="col-sm-6 control-label"><?= $model->getAttributeLabel('role'); ?></label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'role', [
                            'template' => '{input}',
                            'options' => [
                                'tag' => false,
                            ],
                        ])->dropDownList($authItems, ['id' => 'inputUserRole', 'disabled' => $disabled])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputUserStatus" class="col-sm-6 control-label">Status</label>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'status', [
                            'template' => '{input}',
                            'options' => [
                                'tag' => false,
                            ],
                        ])->dropDownList($userStatuses, ['id' => 'inputUserStatus', 'disabled' => $disabled])->label(false); ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('Owner') or Yii::$app->user->can('Admin') or Yii::$app->user->can('Department Leader') or Yii::$app->user->can('Manager')): ?>
                <div class="form-group">
                    <label for="inputUserRole" class="col-sm-6 control-label">Make owner of the group</label>
                    <div class="col-sm-6">

                        <?= $form->field($formGroup, 'ownergroup', [
                            'template' => '{input}',
                            'options' => [
                                'tag' => false,
                            ],
                        ])->dropDownList(
                            $groupsItems, [
                                'id' => 'inputUserGroup',
                                'multiple' => 'multiple',
                                'disabled' => $disabled,
                                'name' => 'owner[]',
                            ]
                        )->label(false); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div><!--/Owner-->

</div>
<div class="contact-bottom-column-height">

    <div class="contact-small-block"><!--User Details-->
        <h3>User Details</h3>
        <div class="property-list">
            <div class="form-group">
                <label for="inputUserFirstName" class="col-sm-6 control-label"><?= $model->getAttributeLabel('first_name'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'first_name', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserFirstName', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserLastName" class="col-sm-6 control-label"><?= $model->getAttributeLabel('last_name'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'last_name', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserLastName', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserEmail"
                       class="col-sm-6 control-label"><?= $model->getAttributeLabel('email'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'email')
                        ->textInput(['id' => 'inputUserEmail', 'disabled' => $disabled])
                        ->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserMobileNumber"
                       class="col-sm-6 control-label"><?= $model->getAttributeLabel('mobile_no'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'mobile_no', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserMobileNumber', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserJobTitle" class="col-sm-6 control-label"><?= $model->getAttributeLabel('job_title'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'job_title', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserJobTitle', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserDepartment" class="col-sm-6 control-label"><?= $model->getAttributeLabel('department'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'department', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserDepartment', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserOfficeTel" class="col-sm-6 control-label"><?= $model->getAttributeLabel('office_no'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'office_no', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserOfficeTel', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserRERABRN" class="col-sm-6 control-label"><?= $model->getAttributeLabel('rera'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'rera', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserRERABRN', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserRentalComm" class="col-sm-6 control-label"><?= $model->getAttributeLabel('rental_commission'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'rental_commission', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserRentalComm', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserSalesComm" class="col-sm-6 control-label"><?= $model->getAttributeLabel('sales_commission'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'sales_commission', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserSalesComm', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserSignature" class="col-sm-6 control-label"><?= $model->getAttributeLabel('agent_signature'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'agent_signature', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserSignature', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUserLanguagesSpoken"
                       class="col-sm-6 control-label"><?= $model->getAttributeLabel('language'); ?></label>
                <div class="col-sm-6">
                    <?= $form->field($model, 'language', [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ])->textInput(['id' => 'inputUserLanguagesSpoken', 'disabled' => $disabled])->label(false); ?>
                </div>
            </div>
        </div>
    </div><!-- /User Details-->

</div>
<style>
    .glyphicon-eye-open {
        pointer-events: auto;
        cursor: pointer;
        right: 10px;
        top: -4px;
    }
    #inputUserPassword {
        padding-right: 20px;
    }
</style>

<?php
$script = <<<JS
    var pass = $('#inputUserPassword');
    $('.glyphicon-eye-open').click(function() {
        pass.attr('type', pass.attr('type') === 'password' ? 'text' : 'password');
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);