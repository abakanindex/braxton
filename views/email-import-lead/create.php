<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailImportLead */

$this->title = Yii::t('app', 'Create Email Import Lead');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Email Import Leads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-import-lead-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
