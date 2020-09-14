<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContactsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contacts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'assigned_to') ?>

    <?= $form->field($model, 'ref') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'date_of_birth') ?>

    <?php // echo $form->field($model, 'nationalities') ?>

    <?php // echo $form->field($model, 'religion') ?>

    <?php // echo $form->field($model, 'languagesd') ?>

    <?php // echo $form->field($model, 'hobbies') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'fb') ?>

    <?php // echo $form->field($model, 'tw') ?>

    <?php // echo $form->field($model, 'linkedin') ?>

    <?php // echo $form->field($model, 'skype') ?>

    <?php // echo $form->field($model, 'googlplus') ?>

    <?php // echo $form->field($model, 'wechat') ?>

    <?php // echo $form->field($model, 'in') ?>

    <?php // echo $form->field($model, 'contact_source') ?>

    <?php // echo $form->field($model, 'company_name') ?>

    <?php // echo $form->field($model, 'designation') ?>

    <?php // echo $form->field($model, 'contact_type') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'documents') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'company_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
