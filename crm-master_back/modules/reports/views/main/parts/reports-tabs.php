<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var string $idForPjax
 * @var $dataProvider
 */
?>

<div class="row" style="margin: 20px">
    <?php
    Pjax::begin(['id' => $idForPjax, 'clientOptions' => []]);
    try {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'itemView' => function ($model) {
                return Html::a(
                        $model->name,
                        ['main/report', 'id' => $model->url_id],
                        ['style' => 'padding-top: 2px;padding-bottom: 2px;']
                );
            },
        ]);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
    Pjax::end();
    ?>
</div>