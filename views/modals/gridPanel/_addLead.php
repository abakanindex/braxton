<?php
use yii\bootstrap\Modal;

$header = '<h4>' . Yii::t('app', 'Add New Lead') . '</h4>'
    . '<div>'
    . Yii::t('app', 'To create a new lead for <b>' . $model->ref . '</b> please fill out the following form and click save button.')
    . '</div>'
?>

<?php Modal::begin([
    'header' => $header,
    'id'     => 'modal-add-lead',
    'size'   => 'modal-lg'
])
?>
<?= $this->render('@app/views/leads/_externalForm', [
    'model' => $model
])?>
<?php Modal::end();?>