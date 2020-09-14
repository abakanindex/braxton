<?php
use yii\bootstrap\Modal;

Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Warning') . '</h4>',
    'id'     => 'modal-create-first',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">'
        . Yii::t('app', 'OK')
        . '</button>',
]);
?>
<div>
    <h5><?= $message?></h5>
</div>
<?php
Modal::end()
?>