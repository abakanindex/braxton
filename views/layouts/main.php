<?php

use yii\helpers\Html;
use app\assets\AppAsset;


/* @var $this \yii\web\View */
/* @var $content string */


AppAsset::register($this);
// dmstr\web\AdminLteAsset::register($this);
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
    <?= $this->render('_setCss')?>
</head>
<body>
    <?php $this->beginBody() ?>
        <div id="loading_process"></div>
        <div class="wrap clearfix">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>
    <div class="footer">
        <p>
            <span>Copyright © 2014-<?= date('Y') ?> Est8World.</span> All rights reserved.
        </p>
    </div>

<?php $this->endBody() ?>

<?= $this->render('_setJs')?>
</body>
</html>
<?php $this->endPage() ?>

