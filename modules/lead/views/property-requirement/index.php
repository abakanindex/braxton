<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lead_viewing\models\PropertyRequirementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Property Requirements');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-requirement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Property Requirement'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'lead_id',
            'category_id',
            'location',
            'sub_location',
            //'min_beds',
            //'max_beds',
            //'min price',
            //'max price',
            //'min_area',
            //'max_area',
            //'unit_type',
            //'unit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
