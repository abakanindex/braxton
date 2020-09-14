<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\lead\models\LeadContactNote */

$this->title = Yii::t('app', 'Create Lead Contact Note');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lead Contact Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-contact-note-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
