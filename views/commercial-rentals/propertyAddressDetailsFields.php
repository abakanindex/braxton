<?= $form->field($model, 'user_id')->widget(
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

<?= $form->field($model, 'ref')->textInput(); ?>

<?= $form->field($model, 'completion_status')->dropDownList([
    '0' => Yii::t('app', 'Select'),
    'Completed Property' => Yii::t('app', 'Completed Property'),
    'Off-plan' => Yii::t('app', 'Off-plan')
]); ?>

<?php
$categories = \app\models\reference_books\PropertyCategory::find()->all();
$items = ArrayHelper::map($categories, 'id', 'title');
$params = [
    'prompt' => Yii::t('app', 'Select category')
];
echo $form->field($model, 'category_id')->dropDownList($items, $params);
?>

<?= $form->field($model, 'emirate')->textInput(); ?>

<?= $form->field($model, 'permit')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'location')->textInput(); ?>

<?= $form->field($model, 'sub_location')->textInput(); ?>

<?= $form->field($model, 'tenure')->textInput(); ?>

<?= $form->field($model, 'unit')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'type')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'street')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'floor')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'built')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'plot')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'view')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'furnished')->dropDownList([
    '0' => Yii::t('app', 'Select'),
    'Furnished' => Yii::t('app', 'Furnished'),
    'Unfurnished' => Yii::t('app', 'Unfurnished'),
    'Partly Furnished' => Yii::t('app', 'Partly Furnished'),
]);
?>