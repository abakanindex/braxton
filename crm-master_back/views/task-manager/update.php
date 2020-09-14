<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskManager */

$this->title = 'Update Task Manager';
$this->params['breadcrumbs'][] = ['label' => 'Task Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-manager-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'usersSearchModel' => $usersSearchModel,
        'usersDataProvider' => $usersDataProvider,
        'salesSearchModel' => $salesSearchModel,
        'salesDataProvider' => $salesDataProvider,
        'rentalsSearchModel' => $rentalsSearchModel,
        'rentalsDataProvider' => $rentalsDataProvider,
        'leadsSearchModel' => $leadsSearchModel,
        'leadsDataProvider' => $leadsDataProvider,
        'contactsSearchModel' => $contactsSearchModel,
        'contactsDataProvider' => $contactsDataProvider,
    ]) ?>

</div>
