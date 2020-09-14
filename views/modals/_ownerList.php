<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Contacts') . '</h4>',
    'id'     => 'contacts-gridview',
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
                'dataProvider' => $contactsDataProvider,
                'filterModel' => $contactsSearchModel,
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
                                    'class' => 'select-landlord-id',
                                    'data-username' => $model->last_name . " " . $model->first_name,
                                    'data-email' => $model->work_email
                                        ? $model->work_email
                                        : $model->personal_email,
                                    'data-mobile' => $model->work_mobile
                                        ? $model->work_mobile
                                        : $model->personal_mobile
                                ];
                            }
                    ],
                    'ref' => [
                        'label' =>  Yii::t('app', 'Referral'),
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
<?php
Pjax::end();
Modal::end();
?>