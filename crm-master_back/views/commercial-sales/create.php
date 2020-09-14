<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CommercialSales */

$this->title = 'Create Commercial Sale';
$this->params['breadcrumbs'][] = ['label' => 'Commercial Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commercial-sales-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
        'modelImg' => $modelImg,
        'modelImgTwo' => $modelImgTwo,
    ]) ?>

</div>
