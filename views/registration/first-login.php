<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 19.09.2017
 * Time: 20:52
 */

/**
 * @var $model = app\models\RegistrationForm;
 * @var $dataProvider array;
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;


?>

                        <h3><?= $this->title = Yii::$app->request->serverName ?> </h3>
                        <h2>Welcome to Systavision Estate CRM!</h2>
                        <?= Html::a('Go to login page', '/site/index') ?>


            <!-- /.col -->

