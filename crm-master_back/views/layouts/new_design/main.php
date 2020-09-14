<?php

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
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    <?php $this->registerCssFile('@web/new-design/css/bootstrap.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/font-awesome.min.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/fontello.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/style.css') ?>
    <?php $this->registerCssFile('@web/new-design/css/toggle-menu.css') ?>
</head>
<body>
    <?php $this->beginBody() ?>
        <div class="wrap clearfix">

        <?= $this->render(
            'new_header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'new_left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'new_content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>
    <div class="footer">
        <p>
            <span>Copyright © 2014-2017 Est8World.</span> All rights reserved.
        </p>
    </div>
<?php $this->endBody() ?>


<?php $this->registerJsFile('@web/new-design/js/menu.js'); ?>
</body>
</html>
<?php $this->endPage() ?>

