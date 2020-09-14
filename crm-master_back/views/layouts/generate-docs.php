<?php

use yii\helpers\Html;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
    <?php $this->registerCssFile('@web/new-design/css/bootstrap.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/font-awesome.min.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/fontello.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/style.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/preview-page.css') ?>
    <?php $this->registerCssFile('@web/css/custom.css') ?>
</head>
<body class="">

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
