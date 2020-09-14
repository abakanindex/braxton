<?php

namespace blumster\migration;

use yii\web\AssetBundle;

class DesignerAsset extends AssetBundle
{
    public $sourcePath = '@blumster/migration/assets';
    public $css = [ 'main.css' ];
    public $js = [ 'main.js' ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
