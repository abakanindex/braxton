<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\menu\models\MenuItems */

$this->title = Yii::t('app', 'Update Menu Items: {nameAttribute}', [
    'nameAttribute' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="menu-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
