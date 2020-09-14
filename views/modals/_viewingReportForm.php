<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\web\View;
?>

<?php Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'How was your viewing?') . '</h4>',
    'id'     => 'modal-viewing-report-form',
    'footer' => Html::button(Yii::t('app', 'Cancel'), [
                        'class' => 'btn btn-default pull-right',
                        'id' => 'viewing-report-cancel',
                        'data-dismiss' => 'modal',
                    ])
        . Html::submitButton(Yii::t('app', 'Save'), [
                'class' => 'btn btn-success',
                'id' => 'viewing-report-save',
                'style' => 'margin: 0 10px;',
        ])
    ])
?>
    <div id="modal-content"></div>
<?php Modal::end();?>

<?php
$viewingReportForm = Url::toRoute(['/viewing/viewing-report-form']);
$viewingReportCancellation = Url::toRoute(['/viewing/viewing-report-cancellation']);
$viewingReportSave = Url::toRoute(['/viewing/viewing-report-save']);

$script = <<<js
$(document).ready(function() {
    // start Viewing report
    var modalViewingReportForm = $('#modal-viewing-report-form');
    setTimeout(function() {
        $.ajax({
            url: '$viewingReportForm',
            type: 'post',
            // data: form.serialize(),
            success: function (response) {
                if (response) {
                    modalViewingReportForm.modal('show');
                    modalViewingReportForm.find('#modal-content').html(response);
                }
            }
        }).always(function() {});
    }, 20000);
    
    modalViewingReportForm.on("click", "#viewing-report-cancel, .close", function() {
        $.ajax({
            url: '$viewingReportCancellation',
            type: 'post',
            data: modalViewingReportForm.find('#viewing-report-form').serialize(),
            success: function (response) {}
        });
    });
    
    modalViewingReportForm.on("click", "#viewing-report-save", function() {
        modalViewingReportForm.modal('hide');
        $.ajax({
            url: '$viewingReportSave',
            type: 'post',
            data: modalViewingReportForm.find('#viewing-report-form').serialize(),
            success: function (response) {}
        });
    });
    // end Viewing report
})
js;

$this->registerJs($script, View::POS_READY);
?>