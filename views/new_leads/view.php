<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Leads */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'auto',
            'Ref',
            'Type',
            'Status',
            'Sub Status',
            'Priority',
            'Hot LeadHot',
            'First Name',
            'Last Name',
            'Mobile No',
            'Category',
            'Emirate',
            'Location',
            'Sub-location',
            'Unit Type',
            'Unit No',
            'Min Beds',
            'Max Beds',
            'Min Price',
            'Max Price',
            'Min Area',
            'Max Area',
            'Listing Ref',
            'Source',
            'Agent 1',
            'Agent 2',
            'Agent 3',
            'Agent 4',
            'Agent 5',
            'Created By',
            'Finance',
            'Enquiry Date',
            'Updated',
            'Agent Referrala',
            'Shared LeadS',
            'Contact Company',
            'Email Address:email',
        ],
    ]) ?>

</div>
