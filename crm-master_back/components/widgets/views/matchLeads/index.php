<?php
use yii\helpers\Html;
use yii\bootstrap\{Modal, Tabs};
?>

<?php Modal::begin([
    'header' => Yii::t('app', 'Matching Leads'),
    'id' => 'modal-matching-leads',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
])?>
<?= Tabs::widget([
    'items' => [
        [
            'label'   => Yii::t('app', 'My Leads'),
            'content' => $this->render('_grid', [
                    'provider'     => $provider,
                    'leadStatuses' =>  $leadStatuses
                ]),
            'active'  => true
        ],
        [
            'label'   => Yii::t('app', 'Company Leads'),
            'content' => $this->render('_grid', [
                    'provider'     => $providerCompany,
                    'leadStatuses' =>  $leadStatuses
                ])
        ]
    ]
])?>
<?php Modal::end();?>