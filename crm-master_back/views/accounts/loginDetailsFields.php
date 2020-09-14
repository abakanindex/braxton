<?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'user_role')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'mobile_number')->widget(
    borales\extensions\phoneInput\PhoneInput::className()
); ?>

<?= $form->field($model, 'job_title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'office_tel')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'rera_brn')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'rental_comm')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'sales_comm')->textInput(['maxlength' => true]) ?>

<?php
    $items = [
        'English' => Yii::t('app', 'English'),
        'French' => Yii::t('app', 'French'),
        'Spanish' => Yii::t('app', 'Spanish'),
        'Chinese' => Yii::t('app', 'Chinese'),
        'Bayut' => Yii::t('app', 'Bayut'),
        'Arabic' => Yii::t('app', 'Arabic'),
        'Russian' => Yii::t('app', 'Russian'),
        'Portuguese' => Yii::t('app', 'Portuguese'),
        'German' => Yii::t('app', 'German'),
        'Japanese' => Yii::t('app', 'Japanese'),
        'Italian' => Yii::t('app', 'Italian'),
        'Turkish' => Yii::t('app', 'Turkish'),
        'Polish' => Yii::t('app', 'Polish'),
        'Persian' => Yii::t('app', 'Persian'),
        'Urdu' => Yii::t('app', 'Urdu'),
    ];
?>
<?php $atr = $model->languages_spoken ? 'languages_spoken' : 'languages_spoken[]' ; ?>

<?= $form->field($model, $atr)->widget(
    kartik\select2\Select2::classname(), [
        'name' => 'languages_spoken[]',
        'data' => $items,
        'theme' => kartik\select2\Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Select a contact source', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
        ],
    ]
)

?>

<?= $form->field($model, 'status')->dropDownList([
    'Active' => Yii::t('app', 'Active'),
    'Inactive' => Yii::t('app', 'Inactive'),]) ?>
