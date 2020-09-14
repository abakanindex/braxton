<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>
<div class="container-fluid  bottom-rentals-content clearfix">
    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
        <?=GridView::widget([
            'dataProvider' => $myLeadsDataProvider,
            'filterModel'  => $leadsSearchModel,
            'layout' => "{items}\n{pager}",
            'tableOptions' => [
                'class' => 'listings_row table table-bordered',
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\RadioButtonColumn',
                    'radioOptions' => function ($model) {
                            return [
                                'value' => $model->reference,
                                'class' => 'share-options-check-lead'
                            ];
                        }
                ],
                'reference',
                'last_name',
                'first_name',
                'email'
            ],
        ]);
        ?>
    </div>
</div>