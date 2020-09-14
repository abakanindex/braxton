<?php
use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Leads') . '</h4>',
    'id'     => 'leads-gridview',
    'size'   => 'modal-lg',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
]);
Pjax::begin(['timeout' => false, 'enablePushState' => false]);
?>
    <div class="container-fluid  bottom-rentals-content clearfix">
        <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
            <?=GridView::widget([
                'tableOptions' => [
                    'class' => 'listings_row table table-bordered',
                ],
                'dataProvider' => $leadRefDataProvider,
                'filterModel' => $leadRefSearchModel,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    [
                        'class' => 'yii\grid\RadioButtonColumn',
                        'radioOptions' => function ($model) {
                            return [
                                'value' => $model->id,
                                'class' => 'select-lead-ref',
                                'data-lead-ref' => $model->reference
                            ];
                        }
                    ],
                    [
                        'label' => 'Reference',
                        'attribute' => 'reference',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a($model->reference,
                                Url::to(['/leads/view', 'id' => $model->id]),
                                ['target' => '_blank', 'data-pjax' => '0',]);
                        },
                    ],
                    'type_id' => [
                        'label' => 'Type',
                        'attribute' => 'type_id',
                        'value' => 'typeOne.title',
                        'filter' => Html::activeDropDownList($leadRefSearchModel, 'type_id', $leadTypes, ['class' => 'form-control', 'prompt' => ''])
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'status',
                        'value' => function($leadRefDataProvider) use ($leadStatuses) {
                            return $leadStatuses[$leadRefDataProvider->status];
                        },
                        'filter' => Html::activeDropDownList($leadRefSearchModel, 'status', $leadStatuses, ['class' => 'form-control', 'prompt' => ''])
                    ],
                    [
                        'label' => 'SubStatus',
                        'attribute' => 'sub_status_id',
                        'value' => 'subStatus.title',
                        'filter' => Html::activeDropDownList($leadRefSearchModel, 'sub_status_id', $leadSubStatuses, ['class' => 'form-control', 'prompt' => '']),
                    ],
                    'first_name',
                    'last_name',
                    'mobile_number',
                    [
                        'label' => 'Assigned To',
                        'attribute' => 'created_by_user_id',
                        'value' => function($leadRefDataProvider) {
                            if (is_numeric($leadRefDataProvider->created_by_user_id)) {
                                return $leadRefDataProvider->createdByUser->username;
                            } else {
                                return $leadRefDataProvider->created_by_user_id;
                            }
                        },
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
<?php
Pjax::end();
Modal::end();
?>