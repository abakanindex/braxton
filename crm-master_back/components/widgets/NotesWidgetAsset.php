<?php
namespace app\components\widgets;

use yii\web\AssetBundle;

class NotesWidgetAsset extends AssetBundle
{
    public $sourcePath = '@app/components/widgets/assets/';
    public $baseUrl = '@web';
    public $css = [];
    public $js = ['notes.js'];
    public $depends = [
        'yii\web\JqueryAsset'
        /*'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',*/
    ];
}