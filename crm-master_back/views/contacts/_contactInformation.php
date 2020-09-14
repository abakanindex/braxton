<?php
use yii\helpers\Html;
use kartik\select2\Select2;
?>
<div class="contact-top-column-height">

    <div class="contact-big-block"><!-- Owner -->
        <!--<h3>Contact</h3>-->
        <div class="owner-head">
            <!--<img alt="user image" class="owner-image img-circle " src="img/user3-128x128.jpg">-->
            <div class="owner-name">
                <h4 id="head-info-full-name"><?= $model->last_name . " " , $model->first_name ?></h4>
                <p><?=Yii::t('app', 'Contact')?></p>
            </div>
        </div>
        <div class="owner-property property-list">
            <p><i class="fa fa-mobile"></i><?=$model->personal_mobile?></p>
            <p><i class="fa fa-phone"></i><?=$model->personal_phone?></p>
            <p><i class="fa fa-envelope"></i><?=$model->personal_email?></p>

        </div>
    </div><!--/Owner-->

</div>

<div class="contact-bottom-column-height">

<div class="contact-small-block"><!--Additional Information-->
<h3>Contact information</h3>
<div class="property-list">
    <div class="">
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Assigned To')?></label>
            <div class="col-sm-6">
                <?= Html::input('text', '', ($assignedToUser) ? $assignedToUser->username : Yii::t('app', ' Select'), [
                    'data-toggle'  => 'modal',
                    'data-target'  => '#users-gridview',
                    'class'        => 'form-control cursor-pointer',
                    'id'           => 'change-assigned-to',
                    'readonly'     => true,
                    'autocomplete' => 'off',
                    'pjax'         => true,
                ])?>
                <?= $form->field($model, 'assigned_to', [
                    'template' => '{input}',
                    'options'  => [
                        'tag' => false,
                    ],
                ])->hiddenInput(['disabled' => $disabledFormElement, 'id' => 'assignedTo'])->label(false);?>
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Created By')?></label>
            <div class="col-sm-6">
                <input type="text" disabled value="<?= $model->createdBy->username?>" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Ref')?></label>
            <div class="col-sm-6">
                <input type="text" disabled value="<?= $model->ref?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Title')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'title', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList($titles, ['disabled' => $disabledFormElement, 'id' => 'contactTitle'])->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label for="" class="control-label"><?=Yii::t('app', 'First Name')?></label>
                <span class="color-red">*</span>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactFirstName'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <label for="" class="control-label"><?=Yii::t('app', 'Last Name')?></label>
                <span class="color-red">*</span>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactLastName'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Gender')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'gender', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList($genderList, ['disabled' => $disabledFormElement, 'id' => 'contactGender'])->label(false)
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Date of Birth')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'date_of_birth', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->widget(
                        yii\jui\DatePicker::className(),
                        [
                            'model'         => $model,
                            'attribute'     => 'available',
                            'language'      => 'en',
                            'dateFormat'    => 'dd-MM-yyyy',
                            'clientOptions' => [
                                'changeYear'  => true,
                                'changeMonth' => true,
                                'yearRange'   => '1920:' . date('Y')
                            ],
                            'options'       => [
                                'class'=>'form-control',
                                'disabled' => $disabledFormElement,
                                'id' => 'contactDateOfBirth',
                                'autocomplete' => 'off'
                            ],
                        ]
                    )->label(false);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Nationality')?></label>
            <div class="col-sm-6">
                <?=  $form->field($model, 'nationality', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList($nationalities, ['disabled' => $disabledFormElement, 'id' => 'contactNationality', 'prompt' => ''])->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Religion')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'religion', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList($religions, ['disabled' => $disabledFormElement, 'id' => 'contactReligion', 'prompt' => ''])->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Native Language')?></label>
            <div class="col-sm-6">
                <?= Select2::widget([
                    'model'     => $model,
                    'attribute' => 'native_language',
                    'theme'     => Select2::THEME_BOOTSTRAP,
                    'data'      => $languages,
                    'options'   => ['placeholder' => '', 'id' => 'contactLanguage_1', 'disabled' => $disabledFormElement]
                ])?>

            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Second Language')?></label>
            <div class="col-sm-6">
                <?= Select2::widget([
                    'model'     => $model,
                    'attribute' => 'second_language',
                    'theme'     => Select2::THEME_BOOTSTRAP,
                    'data'      => $languages,
                    'options'   => ['placeholder' => '', 'id' => 'contactLanguage_2', 'disabled' => $disabledFormElement]
                ])?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?= Yii::t('app', 'Contact Source')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'contact_source', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList($sources, ['disabled' => $disabledFormElement, 'id' => 'contactSource', 'prompt' => ''])->label(false);?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Contact Type')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'contact_type', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->dropDownList($contactType, ['disabled' => $disabledFormElement, 'id' => 'contactType', 'prompt' => ''])->label(false);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Company')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'company_id', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactCompanyName'])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-6 control-label"><?=Yii::t('app', 'Designation')?></label>
            <div class="col-sm-6">
                <?= $form->field($model, 'designation', [
                    'template' => '{input}', // Leave only input (remove label, error and hint)
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ],
                ])->textInput(['maxlength' => true, 'disabled' => $disabledFormElement, 'id' => 'contactDesignation'])->label(false) ?>
            </div>
        </div>

    </div>
</div>
</div><!-- /Additional Information-->

</div>