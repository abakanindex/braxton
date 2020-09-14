<?php
namespace app\components\widgets;

use yii\web\AssetBundle;

class ViewingsLeadWidgetAsset extends AssetBundle
{
    public $sourcePath = '@app/components/widgets/assets/';
    public $baseUrl = '@web';
    public $css = [];
    public $js = ['viewings.js'];
    public $depends = [
        'yii\web\JqueryAsset'
        /*'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',*/
    ];
}