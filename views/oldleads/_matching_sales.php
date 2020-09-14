<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>

<?php
$pjaxCounter = ($counter) ? $counter : '';
$pjax = Pjax::begin(['id' => 'sales-list-pjax' . $pjaxCounter, 'enablePushState' => false]);
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => '.list-view',
    ],
    'itemView' => '_matching_sales_item',
]);
Pjax::end();
