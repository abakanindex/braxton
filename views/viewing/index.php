<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = Yii::t('app', 'My Viewings');
?>
<div class="reminder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Id',
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->id,
                        Url::to(['/viewing/view', 'id' => $model->id]),
                        ['target' => '_blank', 'data-pjax' => '0',]);
                }
            ],
            'client_name',
            'date',
            'agent_id',
            'created_by',
            'note',
            'ref',
            'listing_ref',
            'status',
            'type',
            'type_listing_ref',
        ]]); ?>
    <?php Pjax::end(); ?>
</div>
