<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommercialSales */

$this->title = 'Update Commercial Sale';
$this->params['breadcrumbs'][] = ['label' => 'Commercial Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="commercial-sales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
        'modelImg' => $modelImg,
        'modelImgTwo' => $modelImgTwo,
    ]) ?>

</div>
