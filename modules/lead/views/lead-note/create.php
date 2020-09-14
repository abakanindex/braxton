<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\lead\models\LeadNote */

$this->title = Yii::t('app', 'Create Lead Note');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lead Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-note-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
