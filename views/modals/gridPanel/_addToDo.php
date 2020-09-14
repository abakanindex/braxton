<?php
use yii\helpers\{Html, ArrayHelper, Url};
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

$header = '<h4>' . Yii::t('app', 'Add New To-do') . '</h4>'
    . '<div>'
    . Yii::t('app', 'To create a new to-do for <b>' . $ref . '</b> please fill out the following form and click save button.')
    . '</div>'
?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Users') . '</h4>',
    'id'     => 'users-modal',
    'size'   => 'modal-lg'
]);
echo "<div id='modalContent'>";
echo "<div style='margin-top: 10px'>";
echo GridView::widget([
    'id' => 'users-gridview',
    'dataProvider' => $usersDataProvider,
    //'filterModel' => $usersSearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'username',
    ],
]);
echo "</div>";
echo Html::a('Add Responsibles', '#', ['class' => 'add-responsibles btn btn-success']);
echo "</div>";
Modal::end();
?>

<?php Modal::begin([
    'header' => $header,
    'id'     => 'modal-add-to-do',
    'size'   => 'modal-lg'
])
?>
<?= $this->render('@app/views/task-manager/_externalForm', [
    'ref' => $ref
])?>
<?php Modal::end();?>