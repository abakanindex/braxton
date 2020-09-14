<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\admin\dataselect\EmployeesQuantity */

$this->title = Yii::t('app', 'Create Employees Quantity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees Quantities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-quantity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
