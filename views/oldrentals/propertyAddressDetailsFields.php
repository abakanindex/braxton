<?php

use yii\helpers\ArrayHelper;

?>
<?=
$form->field($model, 'owner')->widget(
            kartik\select2\Select2::classname(), [
                'name'          => 'contact_source',
                'data'          => $modelContactItems,
                'theme'         => kartik\select2\Select2::THEME_BOOTSTRAP,
                'options'       => ['placeholder' => 'Select a owner'],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ' '],
                    'maximumInputLength' => 10
                ],
            ]
        );

    ?>

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

<?= $form->field($model, 'ref')->textInput(['disabled' => true]); ?>

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

<?= $form->field($model, 'area')->textInput() ?>

<?= $form->field($model, 'beds')->dropDownList([
    '0' => Yii::t('app', 'Select'),
    '1' => Yii::t('app', '1'),
    '2' => Yii::t('app', '2'),
    '3' => Yii::t('app', '3'),
    '4' => Yii::t('app', '4'),
    '5' => Yii::t('app', '5'),
    '6' => Yii::t('app', '6'),
    '7' => Yii::t('app', '7'),
    '8' => Yii::t('app', '8'),
    '9' => Yii::t('app', '9'),
    '10' => Yii::t('app', '10'),
    '11' => Yii::t('app', '11'),
    '12' => Yii::t('app', '12'),
    '13' => Yii::t('app', '13'),
    '14' => Yii::t('app', '14'),
    '15' => Yii::t('app', '15'),
    '16' => Yii::t('app', '16'),
]);
?>
<?= $form->field($model, 'bath')->dropDownList([
    '0' => Yii::t('app', 'Select'),
    '1' => Yii::t('app', '1'),
    '2' => Yii::t('app', '2'),
    '3' => Yii::t('app', '3'),
    '4' => Yii::t('app', '4'),
    '5' => Yii::t('app', '5'),
    '6' => Yii::t('app', '6'),
    '7' => Yii::t('app', '7'),
    '8' => Yii::t('app', '8'),
    '9' => Yii::t('app', '9'),
    '10' => Yii::t('app', '10'),
    '11' => Yii::t('app', '11'),
    '12' => Yii::t('app', '12'),
]);
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
<?= $form->field($model, 'status')->dropDownList([
    'Published' => Yii::t('app', 'Published'),
    'Unfurnished' => Yii::t('app', 'Unfurnished'),
    'Draft' => Yii::t('app', 'Draft'),
]); ?>

<?= $form->field($model, 'parking')->textInput(['maxlength' => true]); ?>
