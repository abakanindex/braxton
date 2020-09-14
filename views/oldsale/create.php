<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sale */

$this->title = 'Create Sale';
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
        'modelImg' => $modelImg,
        'modelImgTwo' => $modelImgTwo,
        'modelContactItems' => $modelContactItems,
    ]) ?>

</div>
