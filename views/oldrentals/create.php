<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rentals */

$this->title = 'Create Rentals';
$this->params['breadcrumbs'][] = ['label' => 'Rentals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rentals-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
        'modelImg' => $modelImg,
        'modelImgTwo' => $modelImgTwo,
        'modelContactItems' => $modelContactItems,
    ]) ?>

</div>
