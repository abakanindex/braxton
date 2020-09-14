<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\lead_viewing\models\PropertyRequirement */

$this->title = Yii::t('app', 'Create Property Requirement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Property Requirements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-requirement-create">

    <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

    <?= $this->render($viewToRender, [
        'model'               => $model,
        'emirates'            => $emirates,
        'locationsCurrent'    => $locationsCurrent,
        'subLocationsCurrent' => $subLocationsCurrent,
        'form'                => $form
    ]) ?>

</div>
