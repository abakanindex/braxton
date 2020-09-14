<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CommercialSales */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Commercial Sales', 'url' => ['index']];
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
    </p>

    <label class="control-label">Photos</label>
    <?= dosamigos\gallery\Gallery::widget(['items' => $modelItemsGallery]); ?>
    <br/>
    <label class="control-label">Floor plans</label>
    <?= dosamigos\gallery\Gallery::widget(['items' => $modelItemsGalleryTwo]); ?>
    <br/>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
        'attributes' => [
            'user_id',
            'ref',
            'completion_status',
            'category',
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
            'parking',
            'price_2',
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
            'title',
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

</div>

