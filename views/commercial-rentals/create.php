<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CommercialRentals */

$this->title = 'Create Commercial Rentals';
$this->params['breadcrumbs'][] = ['label' => 'Commercial Rentals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commercial-rentals-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
        'modelImg' => $modelImg,
        'modelImgTwo' => $modelImgTwo,
    ]) ?>

</div>
