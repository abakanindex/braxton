<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaskManager */

$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Task Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-manager-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUserName' => $modelUserName,
        'sales' => $sales,
        'rentals' => $rentals,
        'salesSearchModel' => $salesSearchModel,
        'salesDataProvider' => $salesDataProvider,
        'rentalsSearchModel' => $rentalsSearchModel,
        'rentalsDataProvider' => $rentalsDataProvider,
        'usersSearchModel' => $usersSearchModel,
        'usersDataProvider' => $usersDataProvider,
        'leadsSearchModel' => $leadsSearchModel,
        'leadsDataProvider' => $leadsDataProvider,
        'contactsSearchModel' => $contactsSearchModel,
        'contactsDataProvider' => $contactsDataProvider,
    ]) ?>

</div>
