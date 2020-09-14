<?php

use app\modules\reports\models\ReportsMenuItem;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menu Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Menu Items'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            [
                'label' => Yii::t('app', 'Status'),
                'value' => function ($model) {
                    return ($model->status == ReportsMenuItem::STATUS_ACTIVE) ? Yii::t('app', 'active') : Yii::t('app', 'not active');
                },
            ],
            'uri',
            'class',
            [
                'label' => Yii::t('app', 'Parent menu item'),
                'value' => function ($model) {
                    return ($model->parent_id != '' || $model->parent_id != 0) ? $model->parent->title : '';
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ]

    ]) ?>
</div>
