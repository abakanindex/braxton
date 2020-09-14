<?php

use app\models\Reminder;
use app\components\widgets\ReminderInfoWidget;
use app\components\widgets\ReminderWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaskManager */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Task Managers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-manager-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description:html',
            [
                'label' => Yii::t('app', 'Responsible'),
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    $users = \app\models\TaskResponsibleUser::find()->where(['task_id' => $model->id])->with(['user'])->all();
                    $usersList = '<ul style="list-style: none">';
                    foreach ($users as $user)
                        $usersList .= '<li>' . $user->user->username . '</li>';
                    $usersList .= '</ul>';
                    return $usersList;
                }, $model),
            ],
            [
                'label' => Yii::t('app', 'Dealine'),
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    if ($model->deadline)
                        return date('Y-m-d H:i', $model->deadline);
                    else
                        return '';
                }, $model),
            ],
            'remind',
            [
                'label' => Yii::t('app', 'Sales'),
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    $salesLinks = \app\models\TaskSaleLink::find()->where(['task_id' => $model->id])->with(['sale'])->all();
                    $salesList = '<ul style="list-style: none">';
                    foreach ($salesLinks as $salesLink)
                        $salesList .= '<li>' . Html::a($salesLink->sale->ref, ['sale/view', 'id' => $salesLink->sale->id]) . '</li>';
                    $salesList .= '</ul>';
                    return $salesList;
                }, $model),
            ],
            [
                'label' => Yii::t('app', 'Rentals'),
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    $rentalsLinks = \app\models\TaskRentalLink::find()->where(['task_id' => $model->id])->with(['rental'])->all();
                    $rentalsList = '<ul style="list-style: none">';
                    foreach ($rentalsLinks as $rentalsLink)
                        $rentalsList .= '<li>' . Html::a($rentalsLink->rental->ref, ['rentals/view', 'id' => $rentalsLink->rental->id]) . '</li>';
                    $rentalsList .= '</ul>';
                    return $rentalsList;
                }, $model),
            ],
            [
                'label' => Yii::t('app', 'Leads'),
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    $leadsLinks = \app\models\TaskLeadLink::find()->where(['task_id' => $model->id])->with(['lead'])->all();
                    $leadsList = '<ul style="list-style: none">';
                    foreach ($leadsLinks as $leadsLink)
                        $leadsList .= '<li>' . Html::a($leadsLink->lead->reference, ['leads/' . $leadsLink->lead->reference]) . '</li>';
                    $leadsList .= '</ul>';
                    return $leadsList;
                }, $model),
            ],
            [
                'label' => Yii::t('app', 'Contacts'),
                'format' => 'raw',
                'value' => call_user_func(function ($model) {
                    $contactsLinks = \app\models\TaskContactLink::find()->where(['task_id' => $model->id])->with(['contact'])->all();
                    $contactsList = '<ul style="list-style: none">';
                    foreach ($contactsLinks as $contactsLink)
                        $contactsList .= '<li>' . Html::a($contactsLink->contact->ref, ['contacts/view', 'id' => $contactsLink->contact->id]) . '</li>';
                    $contactsList .= '</ul>';
                    return $contactsList;
                }, $model),
            ],
        ],
    ]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?= ReminderInfoWidget::widget(['keyId' => $model->id, 'keyType' => Reminder::KEY_TYPE_TASKMANAGER]) ?>
        </div>
    </div>

</div>
