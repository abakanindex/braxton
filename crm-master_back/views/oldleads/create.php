<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Leads */

$this->title = Yii::t('app', 'Create Lead');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'companyAgents' => $companyAgents,
    ]) ?>

</div>
