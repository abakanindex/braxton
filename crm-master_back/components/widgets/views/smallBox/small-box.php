<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\date\DatePicker;

?>

<div class="small-box bg-<?php echo $color ?>">
    <div class="inner">
        <h3><?php echo $count ?></h3>
        <p><?php echo Yii::t('app', $text) ?></p>
    </div>
    <div class="icon">
        <i class="fa fa-<?php echo $icon ?>" aria-hidden="true"></i>
    </div>
    <a href="<?php echo $url ?>" class="small-box-footer"><?php echo Yii::t('app', $urlText) ?>
        <i class="fa fa-arrow-circle-right"></i>
    </a>
</div>