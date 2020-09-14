<?php
use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Users') . '</h4>',
    'id'     => 'users-gridview',
    'size'   => 'modal-lg',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
]);
Pjax::begin(['timeout' => false, 'enablePushState' => false]);
?>
    <div class="container-fluid  bottom-rentals-content clearfix">
        <div style="overflow-x: auto; padding-right: 0; padding-left: 0;" class="container-fluid clearfix">
            <?= $this->render($gridVersion, [
                'usersDataProvider' => $usersDataProvider,
                'usersSearchModel'  => $usersSearchModel
            ])?>
        </div>
    </div>
<?php
Pjax::end();
Modal::end();
