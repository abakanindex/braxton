<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Leads') . '</h4>',
    'id'     => 'modal-leads-gridview',
    'size'   => 'modal-lg',
]);
?>

<div class="container-fluid  bottom-rentals-content clearfix">
    <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
        <?=GridView::widget([
            'dataProvider' => $leadsDataProvider,
            //'filterModel' => $contactsSearchModel,
            'layout' => "{items}\n{pager}",
            'tableOptions' => [
                'class' => 'listings_row table table-bordered',
            ],
            'columns' => [
                'status' => [
                    'label' => Yii::t('app', 'Status'),
                    'value' => function($dataProvider) {
                            return $dataProvider->getStatus($dataProvider->status);
                        }
                ],
                'last_name',
                'first_name',
                'emirate',
                'mobile_number'
            ],
        ]);
        ?>
    </div>
</div>

<?php
Modal::end();
?>