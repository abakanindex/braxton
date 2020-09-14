<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contacts */

$this->title = Yii::t('app', 'Create Contacts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid create-content">


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'nationModel' => $nationModel,
        'titlesModel' => $titlesModel,
        'religionModel' => $religionModel,
        'sourceModel' => $sourceModel,
        'modelImg' => $modelImg,
        'modelUser' => $modelUser,
    ]) ?>

</div>
