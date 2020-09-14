<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
?>

<?php Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Advanced Search') . '</h4>',
    'id'     => 'modal-advanced-search',
    'size'   => 'modal-lg'
])
?>
<?= $this->render($advancedSearchPath, [
    'searchModel'        => $searchModel,
    'source'             => $source,
    'portalsItems'       => $portalsItems,
    'featuresItems'      => $featuresItems,
    'agentUser'          => $agentUser,
    'owner'              => $owner,
    'category'           => $category,
    'flagListing'        => $flagListing
])?>
<?php Modal::end();?>