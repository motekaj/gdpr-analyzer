<?php

namespace app\assets;

use yii\web\AssetBundle;

class SbadminAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/sbadmin';
    // public $baseUrl = '@web';
    public $css = [
    	'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
    	'vendor/fontawesome-free/css/all.min.css',
        'css/sb-admin-2.min.css',
    ];
    public $js = [
    	'vendor/jquery-easing/jquery.easing.min.js',
        'vendor/bootstrap/js/bootstrap.bundle.min.js',
    	'js/sb-admin-2.js',
    	'vendor/chart.js/Chart.min.js',
    	'js/demo/chart-area-demo.js',
    	'js/demo/chart-pie-demo.js',


    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
