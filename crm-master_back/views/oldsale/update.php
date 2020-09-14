<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sale */

$this->title = 'Update Sale';
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sale-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
        'modelImg' => $modelImg,
        'modelImgTwo' => $modelImgTwo,
        'modelContactItems' => $modelContactItems,
    ]) ?>

</div>
