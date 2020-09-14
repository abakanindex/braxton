<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>

<?php
$pjax = Pjax::begin(['id' => 'rentals-list-pjax', 'enablePushState' => false]);
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => '.list-view',
    ],
    'itemView' => '_matching_rentals_item',
]);
Pjax::end();
