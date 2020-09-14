 
<?php 

echo '<label class="control-label">Avatar</label>';
echo kartik\file\FileInput::widget([
    'model' => $modelImg,
    'attribute' => 'imageFiles',
    'language' => 'en',
    'options' => [
        'accept' => 'image/*',
        'multiple' => false,
    ],
    'pluginOptions' => [
        'showPreview' => true,
        'initialPreviewAsData' => true,
        'overwriteInitial' => true,
        'showUpload' => false,
        'initialPreview' => '/web/images/img/' . $model->avatar,
        'showCaption' => false,
        'showRemove' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        'browseLabel' => 'Select Photo',
        'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
    ]
]);
?>

    <?= $form->field($model, 'assigned_to')->widget(
        kartik\select2\Select2::classname(), [
            'name' => 'contact_source',
            'data' => $modelUser,
            'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
            'options' => ['placeholder' => 'Select a contact source'],
            'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 10
            ],
        ]
    ); ?>

    <?= $form->field($model, 'ref')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'title')->widget(
            kartik\select2\Select2::classname(), [
                'name'          => 'title',
                'data'          => $titlesModel,
                'theme'         => kartik\select2\Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => 'Select a title'],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ]
        );

    ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([
            '0'      => Yii::t('app', 'Select'),
            'Male'   => Yii::t('app', 'Male'),
            'Female' => Yii::t('app', 'Female'),
        ]) 
    ?>

    <?= $form->field($model, 'date_of_birth')->widget(
            yii\jui\DatePicker::className(),
            [
                'model'         => $model,
                'attribute'     => 'available',
                'language'      => 'en',
                'dateFormat'    => 'dd-MM-yyyy',
                'clientOptions' => ['defaultDate' => '01-01-2017', ],
                'options'       => ['class'=>'form-control', ],
            ]
        );
    ?>

    <?=  $form->field($model, 'nationalities')->widget(
            kartik\select2\Select2::classname(), [
                'name'          => 'nationalities',
                'data'          => $nationModel,
                'theme'         => kartik\select2\Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => 'Select a nationalities'],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ]
        );
    ?>

    <?= $form->field($model, 'religion')->widget(
            kartik\select2\Select2::classname(), [
                'name'          => 'religion',
                'data'          => $religionModel,
                'theme'         => kartik\select2\Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => 'Select a religion'],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ]
        ); 
    ?>

    <?= $form->field($model, 'languagesd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hobbies')->textInput(['maxlength' => true]) ?>
