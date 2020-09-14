<?php

use app\modules\reports\models\Reports;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\reports\models\ReportsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reports-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Reports'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type',
                'value' => function ($model)
                {
                    return Reports::getTypeTitle($model->type);
                },
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($model)
                {
                    return $model->user->username . ' (id=' . $model->user->id . ')';
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model)
                {
                    return date('m/d/Y', $model->created_at);
                },
            ],
            'name',
            'description:ntext',
            [
                'attribute' => 'date_type',
                'value' => function ($model)
                {
                    return Reports::getDateTypeTitle($model->date_type);
                },
            ],
            'date_to',
            'date_from',
            'url_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
