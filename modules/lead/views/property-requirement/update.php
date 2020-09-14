<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lead_viewing\models\PropertyRequirement */

$this->title = Yii::t('app', 'Update Property Requirement: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Requirements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-requirement-update">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render('_form', [
        'model'               => $model,
        'locationsCurrent'    => $locationsCurrent,
        'subLocationsCurrent' => $subLocationsCurrent,
        'emirates'            => $emirates
    ]) ?>

</div>
