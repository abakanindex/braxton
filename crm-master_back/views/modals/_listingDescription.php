<?php
use yii\helpers\{Html, Url};
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/**
 * @var $model
 */
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Property Description') . '</h4>',
    'id'     => 'modal-listing-description',
    'size'   => 'modal-lg',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
]);
Pjax::begin(['timeout' => false, 'enablePushState' => false]);
?>
    <div class="container-fluid clearfix">

        <div class="row">
            <div class="col-md-12">
                <h4><b><?= $model->name; ?></b></h4>
            </div>
            <div class="col-md-12 margin-top-15">
                <?= $model->description; ?>
            </div>
        </div>

    </div>
<?php
Pjax::end();
Modal::end();
