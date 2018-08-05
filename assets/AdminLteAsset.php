<?php
namespace app\assets;

use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@bower/';
    public $css = ['admin-lte/dist/css/AdminLTE.css'];
    public $js = ['admin-lte/dist/js/AdminLTE/app.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}