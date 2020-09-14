<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PaymentPlan */

$this->title = 'Create Payment Plan';
$this->params['breadcrumbs'][] = ['label' => 'Payment Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
