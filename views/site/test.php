<?php
/**
 * Created by PhpStorm.
 * User: qp
 * Date: 05.02.2018
 * Time: 12:08
 */
use app\modules\admin\import\models\Curl;

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
]);