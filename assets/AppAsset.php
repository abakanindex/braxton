<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        // 'dist/css/AdminLTE.css',
    ];
    public $js = [
        'js/yii.confirm.overrides.js',
       //  '//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js',
       // 'js/adminlte.js',
       // '//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js',
       // 'dist/js/pages/dashboard.js',
       // 'dist/js/pages/dashboard2.js',
    ];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\BootboxAsset',
    ];
}
