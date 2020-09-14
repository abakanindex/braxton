<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('SystaVision CRM') ?></title>
    <?php $this->head() ?>
    <?= $this->render('_setCss')?>
</head>
<body class="login-page">

<?php $this->beginBody() ?>
<div id="loading_process"></div>

<?= $content ?>

<?php $this->endBody() ?>

<? $this->registerJsFile('@web/js/custom.js');?>
</body>
</html>
<?php $this->endPage() ?>
