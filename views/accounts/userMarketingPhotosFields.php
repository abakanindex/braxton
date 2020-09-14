<?php

echo '<label class="control-label">Avatar</label>';
echo kartik\file\FileInput::widget([
    'model' => $modelImg,
    'attribute' => 'imageFiles',
    'language' => 'en',
    'options' => [
        'multiple' => false,
    ],
    'pluginOptions' => [
        'showPreview' => true,
        'initialPreviewAsData' => true,
        'overwriteInitial' => true,
        'showUpload' => false,
        'initialPreview' => ($model->avatar ? \yii\helpers\Url::to('@web/images/img/' . $model->avatar, true): ""),
        'showCaption' => false,
        'showRemove' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        'browseLabel' => 'Select Photo',
        'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
    ]
]);
?>

<?= $form->field($model, 'bio')->widget(vova07\imperavi\Widget::className(), [
    'settings' => [
        'lang' => 'en',
        'buttons' => ['link']
    ],
]); ?>

<?= $form->field($model, 'edit_other_managers')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'permissions')->dropDownList(
    $items = [
        'No approval required' => Yii::t('app', 'No approval required'),
        'Approval required for new and edit listings' => Yii::t('app', 'Approval required for new and edit listings'),
        'Approval required for new listings' => Yii::t('app', 'Approval required for new listings'),
    ]); ?>

<?= $form->field($model, 'excel_export')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>

<?= $form->field($model, 'sms_allowed')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>

<?= $form->field($model, 'listing_detail')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>

<?= $form->field($model, 'can_assign_leads')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>

<?= $form->field($model, 'show_owner')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>

<?= $form->field($model, 'delete_data')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'edit_published_listings')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>

<?= $form->field($model, 'access_time')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'hr_manager')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>

<?= $form->field($model, 'agent_type')->dropDownList(
    $items = [
        'External Agent' => Yii::t('app', 'External Agent'),
        'Internal Agent' => Yii::t('app', 'Internal Agent'),
    ]); ?>

<?= $form->field($model, 'contact_lookup_broad_search')->dropDownList(
    $items = [
        'No' => Yii::t('app', 'No'),
        'Yes' => Yii::t('app', 'Yes'),
    ]); ?>