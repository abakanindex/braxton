<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div class="panel panel-default property-requirement-view">
    <div class="panel-body">
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
                'lead_id',
                'category_id',
                'location',
                'sub_location',
                'min_beds',
                'max_beds',
                'min_price',
                'max_price',
                'min_area',
                'max_area',
                'unit_type',
                'unit',
            ],
        ]) ?>

    </div>
</div>
