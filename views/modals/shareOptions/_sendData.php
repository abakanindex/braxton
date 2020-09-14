<?php
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\widgets\Pjax;
use yii\helpers\{
    Html, Url
};

Modal::begin([
    'id'     => 'modal-send-links-to-preview-page',
    'header' => '<h4>' . Yii::t('app', 'Share data') . '</h4>'
]);
?>
<?php Pjax::begin(['timeout' => false, 'enablePushState' => false]);?>

<?= Tabs::widget([
    'items' => [
        [
            'label'   => Yii::t('app', 'Contacts'),
            'content' => $this->render('@app/views/modals/shareOptions/parts/_gridViewContacts', [
                    'contactsDataProvider' => $contactsDataProvider,
                    'contactsSearchModel'  => $contactsSearchModel
                ]),
        ],
        [
            'label'   => Yii::t('app', 'Leads'),
            'content' => $this->render('@app/views/modals/shareOptions/parts/_gridViewLeads', [
                    'myLeadsDataProvider'  => $myLeadsDataProvider,
                    'leadsSearchModel'     => $leadsSearchModel
                ]),
        ]
    ]
])?>

<div class="margin-bottom-15">
    <input type="text" id="share-options-set-email" placeholder="<?= Yii::t('app', 'Type email or select above')?>" class="form-control">
</div>
<div class="pull-right">
    <input type="button" value="<?= Yii::t('app', 'Send links')?>" class="btn btn-success" id="btn-share-links">
    <input type="button" value="<?= Yii::t('app', 'Send brochure')?>" class="btn btn-info" id="btn-send-brochure">
</div>
<div class="clearfix"></div>

<?php Pjax::end();?>
<?php Modal::end();?>