<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>
<div class="container-fluid  bottom-rentals-content clearfix">
    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
        <?=GridView::widget([
            'dataProvider' => $contactsDataProvider,
            'filterModel'  => $contactsSearchModel,
            'layout' => "{items}\n{pager}",
            'tableOptions' => [
                'class' => 'listings_row table table-bordered',
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\RadioButtonColumn',
                    'radioOptions' => function ($model) {
                            return [
                                'value' => $model->ref,
                                'class' => 'share-options-check-contact'
                            ];
                        }
                ],
                'ref' => [
                    'attribute' => 'ref',
                    'format' => 'raw',
                    'value' => function($model) {
                            return Html::a($model->ref,
                                Url::to(['/contacts/view', 'id' => $model->id]),
                                ['target' => '_blank', 'data-pjax' => '0',]);
                        }
                ],
                'last_name',
                'first_name',
                'personal_mobile',
                'personal_email',
                'work_mobile',
                'work_email',
                'contact_type'
            ],
        ]);
        ?>
    </div>
</div>