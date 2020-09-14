<?php

use app\modules\reports\models\ReportsMenuItem;
use yii\helpers\Html;
use execut\widget\TreeView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this \yii\web\View */
/* @var $content string */


// dmstr\web\AdminLteAsset::register($this);

// $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
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
<div class="wrapper clearfix">

    <?= $this->render(
        'header.php',
        ['directoryAsset' => $directoryAsset, 'modelProfile' => $modelProfile]
    ) ?>

    ?>
    <div id="content" class="container-fluid clearfix">
        <div class="row">
            <div class="col-sm-3">
                <?php
                $reportsMenuItems = ReportsMenuItem::find()->where(['status' => ReportsMenuItem::STATUS_ACTIVE, 'parent_id' => null])->with('childs')->all();
                $reportsMenuItemsArr = [];
                function addMenuItemToArr($reportsMenuItems)
                {
                    $reportsMenuItemsArr = [];
                    foreach ($reportsMenuItems as $reportsMenuItem) {
                        if (count($reportsMenuItem->childs) > 0) {
                            $nodes = addMenuItemToArr($reportsMenuItem->childs);
                            $reportsMenuItemsArr[] = [
                                'text' => ucwords(Yii::t('app', $reportsMenuItem->title)),
                                'nodes' => $nodes,
                            ];
                        } else {
                            $reportsMenuItemsArr[] = [
                                'text' => ucwords(Yii::t('app', $reportsMenuItem->title)),
                                'href' => Url::to([$reportsMenuItem->uri]),
                            ];
                        }


                    }
                    return $reportsMenuItemsArr;
                }
                $reportsMenuItemsArr = addMenuItemToArr($reportsMenuItems);
                echo TreeView::widget([
                    'data' => $reportsMenuItemsArr,
                    'size' => TreeView::SIZE_SMALL,
                    'clientOptions' => [
                        'onNodeSelected' => new JsExpression('function (undefined, item) {
                                if (item.href)
                                    window.location.href = item.href;
                            }'),
                        'selectedBackColor' => 'rgb(40, 153, 57)',
                    ],
                ]);
                ?>
            </div>
            <div class="col-sm-9">
                <section class="content-header">
                    <?php if (isset($this->blocks['content-header'])) { ?>
                        <!--            <h1>--><? //= $this->blocks['content-header'] ?><!--</h1>-->
                    <?php } else { ?>
                        <!--            <h1>-->
                        <!--                --><?php
//                if ($this->title !== null) {
//                    echo \yii\helpers\Html::encode($this->title);
//                } else {
//                    echo \yii\helpers\Inflector::camel2words(
//                        \yii\helpers\Inflector::id2camel($this->context->module->id)
//                    );
//                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
//                } ?>
                        <!--            </h1>-->
                    <?php } ?>

                </section>

                <section class="content">
                    <?= $content ?>
                </section>
            </div>
        </div>
    </div>
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


