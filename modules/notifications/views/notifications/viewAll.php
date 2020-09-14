<?php

use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Notifications');
?>
<div class="reminder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'key',
            [
                'label' => 'Title',
                'attribute' => 'title',
                'format' => 'raw',
                'value' => 'title',
            ],
            'type',
            'seen',
            'flashed',
            'created_at',
        ]]); ?>
    <?php Pjax::end(); ?>
</div>
