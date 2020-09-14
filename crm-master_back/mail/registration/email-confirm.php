<?php
/**
 * Created by PhpStorm.
 * User: qq
 * Date: 23.11.2017
 * Time: 15:20
 */

/**
 * var $model = app\models\User
 */

Yii::$app->urlManager->setBaseUrl('http://crm/web/registration/confirm-email/');
$link = Yii::$app->urlManager->createUrl(['activation' => $model->activation]);


echo $link;