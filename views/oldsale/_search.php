<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SaleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'ref') ?>

    <?= $form->field($model, 'completion_status') ?>

    <?= $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'beds') ?>

    <?php // echo $form->field($model, 'bath') ?>

    <?php // echo $form->field($model, 'emirate') ?>

    <?php // echo $form->field($model, 'permit') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'sub_location') ?>

    <?php // echo $form->field($model, 'tenure') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'built') ?>

    <?php // echo $form->field($model, 'plot') ?>

    <?php // echo $form->field($model, 'view') ?>

    <?php // echo $form->field($model, 'furnished') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'parking') ?>

    <?php // echo $form->field($model, 'price_2') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'photos') ?>

    <?php // echo $form->field($model, 'floor_plans') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'portals') ?>

    <?php // echo $form->field($model, 'features') ?>

    <?php // echo $form->field($model, 'neighbourhood') ?>

    <?php // echo $form->field($model, 'property_status') ?>

    <?php // echo $form->field($model, 'source_listing') ?>

    <?php // echo $form->field($model, 'featured') ?>

    <?php // echo $form->field($model, 'dewa') ?>

    <?php // echo $form->field($model, 'str') ?>

    <?php // echo $form->field($model, 'available') ?>

    <?php // echo $form->field($model, 'remind') ?>

    <?php // echo $form->field($model, 'key_location') ?>

    <?php // echo $form->field($model, 'property') ?>

    <?php // echo $form->field($model, 'rented_at') ?>

    <?php // echo $form->field($model, 'rented_until') ?>

    <?php // echo $form->field($model, 'maintenance') ?>

    <?php // echo $form->field($model, 'managed') ?>

    <?php // echo $form->field($model, 'exclusive') ?>

    <?php // echo $form->field($model, 'invite') ?>

    <?php // echo $form->field($model, 'poa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
