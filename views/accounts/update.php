<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title = Yii::t('app', 'Update Accounts: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="accounts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelImg' => $modelImg,
    ]) ?>

</div>
