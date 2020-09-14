<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Accounts */

$this->title = Yii::t('app', 'Create Accounts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelImg' => $modelImg,
    ]) ?>

</div>
