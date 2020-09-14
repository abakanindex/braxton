<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\{Tabs, Modal};
use yii\widgets\Pjax;

Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Listings') . '</h4>',
    'id'     => 'listings-gridview',
    'size'   => 'modal-lg',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
]);
?>
    <div class="container-fluid  bottom-rentals-content clearfix">
        <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Sales'),
                        'active' => true,
                        'content' => $this->render('partsListingsList/_gridSales', [
                            'saleDataProvider' => $saleDataProvider,
                            'saleSearchModel' => $saleSearchModel,
                        ]),
                        'options' => [
                            'id' => 'deal-tab-sale',
                        ],
                    ],
                    [
                        'label' => Yii::t('app', 'Rentals'),
                        'content' => $this->render('partsListingsList/_gridRentals', [
                            'rentalDataProvider' => $rentalDataProvider,
                            'rentalSearchModel' => $rentalSearchModel,
                        ]),
                        'options' => [
                            'id' => 'deal-tab-rental',
                        ],
                    ]
                ]
            ])?>
        </div>
    </div>
<?php Modal::end(); ?>
