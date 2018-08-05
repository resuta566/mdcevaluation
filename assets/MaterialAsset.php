<?php
namespace app\assets;

use yii\web\AssetBundle;

class MaterialAsset extends AssetBundle
{
    public $lol = '@views';
    public $sourcePath = '@vendor/ramosisw/';
    public $css = [
        'yii2-material-dashboard/assets/css/material-dashboard.css'
    
    ];
    public $js = [
        'yii2-material-dashboard/assets/js/core/jquery.min.js',
        'yii2-material-dashboard/assets/js/core/popper.min.js',
        'yii2-material-dashboard/assets/js/core/bootstrap-material-design.min.js',
        'yii2-material-dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js',
        'yii2-material-dashboard/assets/js/plugins/bootstrap-notify.js',
        'yii2-material-dashboard/assets/js/material-dashboard.min.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}