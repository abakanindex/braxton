<?php

use app\models\reference_books\PropertyCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">

    <!--h1><?= Html::encode($this->title) ?></h1-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sale', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'ref',
            'unit',
            [
                'attribute' => 'category',
                'value' => 'category.title',
                'filter' => ArrayHelper::map(PropertyCategory::find()->asArray()->all(), 'id', 'title'),
                'headerOptions' => ['style' => 'min-width:140px;'],
            ],
            'emirate',
            'location',
            'sub_location',
            'beds',
            'area',
            'price',
            'price_2',
            'user_id',
            'completion_status',
            'bath',
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
            [
                'attribute' => 'description',
                'value' => function ($model) {
                    return strip_tags(StringHelper::truncate($model->description, 200));
                }
            ],
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
    ]); ?>
</div>
