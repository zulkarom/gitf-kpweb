<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
	
    public $baseUrl = '@web';
	
    public $css = [
        "css/bootstrap.min.css",
		"css/font-awesome.min.css",
		"css/themify-icons.css",
		"css/style.css",	
    ];
	

	
    public $js = [
		"js/jquery-3.2.1.min.js",
		"js/main.js",
		
		
    ];
	
	
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
