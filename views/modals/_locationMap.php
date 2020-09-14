<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>

<?php Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Location') . '</h4>',
    'id'     => 'modal-location-map',
    'size'   => 'modal-lg',
    'footer'   => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
])?>
    <div id="googleMap"></div>
    <div class="row margin-top-15">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <?= $topModel->getAttributeLabel('latitude')?>
                </div>
                <div class="col-md-10">
                    <?= $form->field($topModel, 'latitude', ['options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput(['readonly' => true, 'class' => 'form-control', 'id' => 'latitude'])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <?= $topModel->getAttributeLabel('longitude')?>
                </div>
                <div class="col-md-10">
                    <?= $form->field($topModel, 'longitude', ['options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput(['readonly' => true, 'class' => 'form-control', 'id' => 'longitude'])->label(false); ?>
                </div>
            </div>
        </div>
    </div>
<?php Modal::end();?>