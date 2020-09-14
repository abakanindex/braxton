<?php

use app\models\Reminder;
use app\modules\lead_viewing\models\LeadViewing;
use app\widgets\LeadViewingWidget;
use app\widgets\ReminderWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sale */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-view">


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
    <div class="row">
        <div class="col-sm-6">
            <?= ReminderWidget::widget(['keyId' => $model->id, 'keyType' => Reminder::KEY_TYPE_SALE]) ?>
        </div>
        <div class="col-sm-6">
            <?php echo LeadViewingWidget::widget([
                'saleId' => $model->id,
                'action' => LeadViewing::ACTION_CREATE,
                'salesSearchModel' => $leadViewingSalesSearchModel,
                'salesDataProvider' => $leadViewingSalesDataProvider,
                'rentalsSearchModel' => $leadViewingRentalsSearchModel,
                'rentalsDataProvider' => $leadViewingRentalsDataProvider,
                'leadViewingLeadsSearchModel' => $leadViewingLeadsSearchModel,
                'leadViewingLeadsDataProvider' => $leadViewingLeadsDataProvider,
            ]) ?>
        </div>
    </div>
    </p>

    <label class="control-label">Photos</label>
    <?= dosamigos\gallery\Gallery::widget(['items' => $modelItemsGallery]); ?>
    <br/>

    <label class="control-label">Floor plans</label>
    <?= dosamigos\gallery\Gallery::widget(['items' => $modelItemsGalleryTwo]); ?>
    <br/>

    <label class="control-label">Assigned To</label>
    <br/>
    <?php
    echo 'Name: ' . $modelUser->username . '<br/>';
    ?>
    <br/>

    <label class="control-label">Owner</label>
    <br/>
    <img src="<?= '/web/images/img/' . $modelContactItems->avatar ?>" style="width: 200px;
    border-radius: 111px;">
    <br/>
    <?php
    echo 'Name and First Name: ' .
        $modelContactItems->first_name . ' ' .
        $modelContactItems->last_name . '<br/>';
    echo 'mobile: ' . $modelContactItems->mobile . '<br/>';
    echo 'phone:' . $modelContactItems->phone . '<br/>';
    echo 'email:' . $modelContactItems->email . '<br/>';
    ?>
    <br/>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
        'attributes' => [
            'ref',
            'completion_status',
            [
                'attribute' => 'category_id',
                'value' => $model->categoryRel,
            ],
            'beds',
            'bath',
            'emirate',
            'permit',
            'location',
            'sub_location',
            'tenure',
            'unit',
            'type',
            'street',
            'floor',
            'built',
            'plot',
            'view',
            'furnished',
            'price',
            'price_2',
            'commission',
            'deposit',
            'parking',
            'status',
//            [
//                'label' => 'photos',
//                'value' => function () use ($modelItemsGallery) {
//
//                    echo dosamigos\gallery\Gallery::widget(['items' => $modelItemsGallery]);
//
//                },
//            ],
//            'floor_plans',
            'language',
            'description:html',
            'portals:ntext',
            'features:ntext',
            'neighbourhood:ntext',
            'property_status',
            'source_listing',
            'featured',
            'dewa',
            'str',
            'available',
            'remind',
            'key_location',
            'property',
            'rented_at',
            'rented_until',
            'maintenance',
            'managed',
            'exclusive',
            'invite',
            'poa',
        ],
    ]) ?>


    <?php echo '<pre>';var_dump($modelHistory); ?>

</div>