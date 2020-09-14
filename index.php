<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07.09.2017
 * Time: 17:23
 */


if (strpos($_SERVER['REQUEST_URI'], 'yii2') !== false) {
    header('Location: /app/yii2/web/index.php');
}
