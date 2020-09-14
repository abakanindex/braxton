<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lead_viewing\models\PropertyRequirement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-requirement-form-block">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'id' => 'property-requirement-form',
        'action' => ($model->isNewRecord) ?
            ['/lead/property-requirement/create', 'leadId' => $model->lead_id] :
            ['/lead/property-requirement/update', 'id' => $model->id],
        'validationUrl' => ['/lead/property-requirement/validate'],
    ]); ?>

    <div style="display: none">
        <?= $form->field($model, 'lead_id')->textInput() ?>
    </div>

    <?php
    $categories = \app\models\reference_books\PropertyCategory::find()->all();
    $items = ArrayHelper::map($categories, 'id', 'title');
    $params = [
        'prompt' => Yii::t('app', 'Select category')
    ];
    echo $form->field($model, 'category_id')->dropDownList($items, $params);
    ?>

    <?= $form->field($model, 'company_id')->textInput(['style' => 'display: none'])->label(false) ?>

    <?= $form->field($model, 'emirate')->dropDownList($emirates, ['prompt' => '', 'id' => 'emirateDropDown']);?>

    <?= $form->field($model, 'location')->dropDownList($locationsCurrent, ['prompt' => '', 'id' => 'locationDropDown'])?>

    <?= $form->field($model, 'sub_location')->dropDownList($subLocationsCurrent, ['prompt' => '', 'id' => 'subLocationDropDown'])?>

    <?= $form->field($model, 'min_beds')->textInput() ?>

    <?= $form->field($model, 'max_beds')->textInput() ?>

    <?= $form->field($model, 'min_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_area')->textInput() ?>

    <?= $form->field($model, 'max_area')->textInput() ?>

    <?= $form->field($model, 'unit_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit')->textInput() ?>

    <?= $form->field($model, 'min_baths')->textInput() ?>

    <?= $form->field($model, 'max_baths')->textInput() ?>



    <div style="display: none">
        <? /*= $form->field($model, 'company_id')->textInput() */ ?>
    </div>

    <div class="form-group">
        <?php
        if ($model->isNewRecord)
            echo Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']);
        else
            echo Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']);
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
