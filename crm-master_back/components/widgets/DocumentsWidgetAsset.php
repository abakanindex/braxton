<?php
namespace app\components\widgets;

use yii\web\AssetBundle;

class DocumentsWidgetAsset extends AssetBundle
{
    public $sourcePath = '@app/components/widgets/assets/';
    public $baseUrl = '@web';
    public $css = [];
    public $js = ['documents.js'];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}