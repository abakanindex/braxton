<div class="row small-column-height">
<div class="col-md-6 rentals-small-block"><!--Additional Information-->
<h3>Additional Information</h3>
<div class="property-list">
<div class="form-group">
    <label for="inputSourceOflisting" class="col-sm-6 control-label">Source of listing</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'source_of_listing')->dropDownList(
            $source,
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]
        )->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputFeatured" class="col-sm-6 control-label">Featured</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'featured')->dropDownList(
            [
                '0' => Yii::t('app', 'Select'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]
        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputDEWANumber" class="col-sm-6 control-label">DEWA Number</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'dewa_no')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputSTR" class="col-sm-6 control-label">STR #</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'strno')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputNextAvailable" class="col-sm-6 control-label">Next available</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'available_date')->widget(
            yii\jui\DatePicker::className(),
            [
                'model' => $model,
                'attribute' => 'Available Date',
                'language' => 'ru',
                'dateFormat' => 'dd-MM-yyyy',
                'clientOptions' => [
                    'changeYear'  => true,
                    'changeMonth' => true,
                    'yearRange'   => '1920:' . date('Y')
                ],
                'options' => [
                    'class' => 'form-control',
                    'disabled' => $disabledAttribute,
                    'autocomplete' => 'off'
                ],

            ]
        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputRemind" class="col-sm-6 control-label">Remind</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'remind_me')->dropDownList(
            [
                '0' => Yii::t('app', 'Never'),
                '1 day' => Yii::t('app', '1 day'),
                '1 week' => Yii::t('app', '1 week'),
                '2 weeks' => Yii::t('app', '2 weeks'),
                '10 weeks' => Yii::t('app', '10 weeks'),
                '1 month' => Yii::t('app', '1 month'),
                '2 month' => Yii::t('app', '2 month'),
                '3 month' => Yii::t('app', '3 month'),
                '4 month' => Yii::t('app', '4 month'),
                '6 month' => Yii::t('app', '6 month'),
            ],
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]

        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputKeyLocation" class="col-sm-6 control-label">Key Location</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'key_location')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputPropertyTenanted" class="col-sm-6 control-label">Property Tenanted?</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'tenanted')->dropDownList(
            [
                'No' => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]

        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputRentedAt" class="col-sm-6 control-label">Rented at</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'rented_at')->widget(
            yii\jui\DatePicker::className(),
            [
                'model' => $model,
                'attribute' => 'Available Date',
                'language' => 'ru',
                'dateFormat' => 'dd-MM-yyyy',
                'clientOptions' => [
                    'changeYear'  => true,
                    'changeMonth' => true,
                    'yearRange'   => '1920:' . date('Y')
                ],
                'options' => [
                    'class' => 'form-control',
                    'disabled' => $disabledAttribute,
                    'autocomplete' => 'off'
                ],

            ]
        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputRentedUntil" class="col-sm-6 control-label">Rented until</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'rented_until')->widget(
            yii\jui\DatePicker::className(),
            [
                'model' => $model,
                'attribute' => 'Available Date',
                'language' => 'ru',
                'dateFormat' => 'dd-MM-yyyy',
                'clientOptions' => [
                    'changeYear'  => true,
                    'changeMonth' => true,
                    'yearRange'   => '1920:' . date('Y')
                ],
                'options' => [
                    'class' => 'form-control',
                    'disabled' => $disabledAttribute,
                    'autocomplete' => 'off'
                ],

            ]
        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputMaintenanceFee" class="col-sm-6 control-label">Maintenance Fee</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'maintenance')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control'])->label(false); ?>
    </div>
</div>
<div class="form-group">
    <label for="inputManaged" class="col-sm-6 control-label">Managed</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'managed')->dropDownList(
            [
                'No' => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]

        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputExclusive" class="col-sm-6 control-label">Exclusive</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'exclusive')->dropDownList(
            [
                'No' => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]

        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputInvite" class="col-sm-6 control-label">Invite</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'invite')->dropDownList(
            [
                'No' => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]

        )->label(false);
        ?>
    </div>
</div>
<div class="form-group">
    <label for="inputPOA" class="col-sm-6 control-label">POA</label>
    <div class="col-sm-6">
        <?= $form->field($topModel, 'poa')->dropDownList(
            [
                'No' => Yii::t('app', 'No'),
                'Yes' => Yii::t('app', 'Yes'),
            ],
            [
                'prompt' => Yii::t('app', 'Select'),
                'disabled' => $disabledAttribute,
                'class' => 'form-control'
            ]

        )->label(false);
        ?>
    </div>
</div>
</div>
</div><!-- /Additional Information-->

<?php if (Yii::$app->controller->action->id === 'create'
    or Yii::$app->controller->action->id === 'update') : ?>
    <div class="col-md-6 rentals-small-block" style="padding-left: 0; padding-right: 0;">
        <!--Title and Description-->
        <div class="property-list">
            <div class="form-group">
                <label for="inputLanguage" class="col-sm-6 control-label">Language</label>
                <div class="col-sm-6">
                    <div class="form-group field-sale-language">

                            <select class="form-control" name="language" disabled>
                                <option value="1" selected>English</option>
                                <option value="2">Russian</option>
                                <option value="3">Arabic</option>
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputTitle" class="col-sm-6 control-label"><?= Yii::t('app', 'Title') ?></label>
                    <div class="col-sm-6 with-maxlength">
                        <span class="chars-remaining badge badge-danger"></span> characters remaining
                        <?= $form->field($topModel, 'name')->textInput(['disabled' => $disabledAttribute, 'class' => 'form-control countdown', 'id' => 'sale-name'])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDescription"
                           class="col-sm-6 control-label"><?= Yii::t('app', 'Description') ?>
                    </label>
                    <div class="col-sm-12">
                        <span class="chars-remaining2 badge badge-danger"></span> characters remaining
                        <?= $form->field($topModel, 'description')->widget(\mihaildev\ckeditor\CKEditor::class, [
                            'editorOptions' => [
                                'preset' => 'basic', //basic, standard or full
                                'inline' => false,
                                'removeButtons' => 'Undo,Redo,Superscript,Subscript,Strike,About,TextColor,BGColor,Link,Unlink,Anchor,Smiley,Image,Flash,Table',
                            ],
                            'options' => ['id' => 'sale-description']
                        ])->label(false); ?>
                    </div>
                </div>
            </div>
        </div><!--Title and Description-->
    <?php else : ?>
    <div class="col-md-6 rentals-small-block"><!--Title and Description-->
        <div><b><?= $topModel->name; ?></b></div>
        <br>
        <div>
            <?php
            if (strlen($topModel->description) > 180) {
                echo substr ($topModel->description, 0, 180) . '...';
                echo '<br>';
                echo ' ', \yii\helpers\Html::a(
                    Yii::t('app', ' Read More') . ' >',
                    '#',
                    [
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-listing-description',
                        'class' => 'listing-description-link'
                    ]
                );
            } else {
                echo $topModel->description;
            }
            ?>
        </div>
    </div><!--Title and Description-->
    <?php endif ?>
</div>

<?php
$script = <<<JS
    $("#sale-name").maxLength({
        maxChars: 60,
        remainHolder: '.chars-remaining'
    });

    $("#sale-description").maxLength({
        maxChars: 1000,
        remainHolder: '.chars-remaining2'
        //countHolder: '.chars-count2',
		//maxHolder: '.chars-max2',
    })

    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.instances['sale-description'].on('change', function() {
            $("#sale-description").val(CKEDITOR.instances['sale-description'].getData()).trigger('paste');
            //$("#sale-description").keydown();
        });
    }

    $('body').on('paste', "#sale-description", function() {
    })
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>