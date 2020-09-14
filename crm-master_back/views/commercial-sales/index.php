<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommercialSalesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Commercial Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">

    <!--h1><?= Html::encode($this->title) ?></h1-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Commercial Sale', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ref',
            'unit',
            'category',
            'emirate',
            'location',
            'sub_location',
            'built',
            'price',
            'price_2',
            'user_id',
            'completion_status',
            'permit',
            'tenure',
            'type',
            'street',
            'floor',
            'plot',
            'view',
            'furnished',
            'parking',
            'status',
//            'photos:ntext',
//            'floor_plans:ntext',
            'language',
            'title',
            'description:ntext',
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
