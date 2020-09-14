<?php
use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Agent 2') . '</h4>',
    'id'     => 'agent2-gridview',
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
                'dataProvider' => $usersDataProvider,
                'filterModel' => $usersSearchModel,
                'layout' => "{items}\n{pager}",
                'tableOptions' => [
                    'class' => 'listings_row table table-bordered',
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\RadioButtonColumn',
                        'radioOptions' => function ($model) {
                            return [
                                'value' => $model->id,
                                'class' => 'select-agent2',
                                'data-agent' => $model->username
                            ];
                        }
                    ],
                    [
                        'label' => 'User Name',
                        'attribute' => 'username',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a($model->username,
                                Url::to(['/users/user-settings/view', 'id' => $model->id]),
                                ['target' => '_blank', 'data-pjax' => '0',]);
                        }
                    ],
                    'last_name',
                    'first_name',
                    'job_title',
                    'office_no',
                    'mobile_no',
                    'email'
                ],
            ]);
            ?>
        </div>
    </div>
<?php
Pjax::end();
Modal::end();
?>