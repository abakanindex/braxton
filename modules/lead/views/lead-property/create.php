<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\lead\models\LeadProperty */

$this->title = Yii::t('app', 'Create Lead Property');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lead Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-property-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
