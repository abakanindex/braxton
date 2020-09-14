<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Update User: {nameAttribute}', [
    'nameAttribute' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput(['type' => 'email', 'disabled' => 'true']) ?>

    <?= $form->field($model, 'country')
        ->dropDownList(
            ArrayHelper::map(\app\models\Country::find()
                ->orderBy('en')
                ->all(),
                'country_id', 'en')) ?>
    <?= $form->field($model, 'status')
        ->dropDownList(
            ArrayHelper::map(\app\models\UserStatus::find()
                ->asArray()
                ->all(),
                'id', 'title'), ['disabled' => true]) ?>
    <?= $form->field($model, 'phone_number')->textInput(['type' => 'phone']) ?>
    <?= Html::button('Save', ['type' => 'submit']) ?>
    <?php ActiveForm::end() ?>

</div>
