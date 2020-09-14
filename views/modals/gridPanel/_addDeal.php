<?php
use yii\bootstrap\Modal;

$header = '<h4>' . Yii::t('app', 'Add New Deal') . '</h4>'
    . '<div>'
    . Yii::t('app', 'To create a new deal for <b>' . $model->ref . '</b> please fill out the following form and click save button.')
    . '</div>'
    . '<div>'
    . Yii::t('app', '* This will create a skeletal deal record. You can complete the information for this deal by navigating through the \'View Deals\' options or going to Deals screen.')
    . '</div>'
?>

<?php Modal::begin([
    'header' => $header,
    'id'     => 'modal-add-deal',
    'size'   => 'modal-lg'
])
?>
<?= $this->render('@app/modules/deals/views/deals/_externalForm', [
    'model' => $model,
    'ownerRecord' => $ownerRecord,
    'categories' => $categories,
    'emiratesDropDown' => $emiratesDropDown,
    'locationDropDown' => $locationDropDown,
    'subLocationDropDown' => $subLocationDropDown,
])?>
<?php Modal::end();?>

