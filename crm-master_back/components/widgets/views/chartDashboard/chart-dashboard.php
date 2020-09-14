<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

?>

<div class="box box-<?php echo $type ?>">
    <div class="box-header">
        <i class="fa fa-bar-chart"></i>

        <h3 class="box-title"><?php echo Yii::t('app', $title) ?></h3>

        <div class="pull-right box-tools">
            <button type="button" class="btn btn-<?php echo $type ?> btn-sm" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-<?php echo $type ?> btn-sm" data-widget="remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    <div class="box-body">
        <?php echo $boxBody ?>
    </div>
</div>