<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\EmailLeadSource */

$this->title = Yii::t('app', 'Create Email Lead Source');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Email Lead Sources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-lead-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
