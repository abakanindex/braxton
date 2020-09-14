<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div id="modal-viewing" class="modal-viewing modal fade">
    <div class="modal-dialog">
        <div id="modal-viewing-content" class="modal-content">
        </div>
    </div>
</div>

<div id="modal-viewing-sales" class="modal-viewing-sales modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <?= Yii::t('app', 'Sales') ?></h4>
            </div>
            <div class="modal-body modal-viewing-sales-body">
                <?php Pjax::begin(['id' => 'viewings-sales-gridview', 'timeout' => false, 'enablePushState' => false]) ?>
                <?= GridView::widget([
                    'id' => 'viewing-sales-gridview',
                    'dataProvider' => $salesDataProvider,
                    'filterModel' => $salesSearchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\CheckboxColumn'],
                        'ref',
                    ],
                ]); ?>
                <?php Pjax::end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
                <?php
                echo Html::submitButton(Yii::t('app', 'Add'), ['id' => 'add-viewing-sales', 'class' => 'btn btn-success']);
                ?>
            </div>
        </div>
    </div>
</div>

<div id="modal-viewing-rentals" class="modal-viewing-rentals modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <?= Yii::t('app', 'Rentals') ?></h4>
            </div>
            <div class="modal-body modal-viewing-rentals-body">
                <?php Pjax::begin(['id' => 'viewings-rentals-gridview', 'timeout' => false, 'enablePushState' => false]) ?>
                <?= GridView::widget([
                    'id' => 'viewing-rentals-gridview',
                    'dataProvider' => $rentalsDataProvider,
                    'filterModel' => $rentalsSearchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['class' => 'yii\grid\CheckboxColumn'],
                        'ref',
                    ],
                ]); ?>
                <?php Pjax::end() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?= Yii::t('app', 'OK') ?></button>
                <?php
                echo Html::submitButton(Yii::t('app', 'Add'), ['id' => 'add-viewing-rentals', 'class' => 'btn btn-success']);
                ?>
            </div>
        </div>
    </div>
</div>